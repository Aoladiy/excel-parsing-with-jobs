<?php

namespace App\Jobs;

use App\Models\Row;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProcessExcelChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;

    /**
     * Create a new job instance.
     */
    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->chunk as $row) {
            // Пропустим заголовок
            if ($row === reset($this->chunk)) continue;

            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'date' => $row[2],
            ];

            // Валидация данных
            $validator = Validator::make($data, [
                'id' => 'required|unique:rows,id|integer|gt:0',
                'name' => 'required|string|regex:/^[a-zA-Z ]+$/',
                'date' => 'required|date_format:d.m.Y',
            ]);

            if ($validator->fails()) {
                // Логируем или пропускаем неправильные данные
                Log::error('Validation failed for row', ['row' => $data, 'errors' => $validator->errors()]);
                continue;
            }
            // Сохранение данных в базу данных
            Row::query()->firstOrCreate(
                ['id' => $data['id']],
                [
                    'name' => $data['name'],
                    'date' => $data['date'],
                ]);
        }
    }
}
