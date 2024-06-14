<?php

namespace App\Jobs;

use App\Events\RowCreated;
use App\Models\Row;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;

class ProcessExcelChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;
    protected $startLineNumber;
    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($chunk, $startLineNumber)
    {
        $this->chunk = $chunk;
        $this->startLineNumber = $startLineNumber;
        $this->filePath = 'result.txt';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processedRows = 0;

        foreach ($this->chunk as $index => $row) {
            // Пропустим заголовок
            if ($index === 0 && $this->startLineNumber === 1) continue;

            $lineNumber = $this->startLineNumber + $index; // Номер строки в оригинальном файле

            $data = [
                'id' => $row[0],
                'name' => $row[1],
                'date' => $row[2],
            ];

            $validator = Validator::make($data, [
                'id' => 'required|unique:rows,id|integer|gt:0',
                'name' => 'required|string|regex:/^[a-zA-Z ]+$/',
                'date' => 'required|date_format:d.m.Y',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorString = implode(', ', $errors);
                $logMessage = "$lineNumber - $errorString";

                Storage::append($this->filePath, $logMessage);
                continue;
            } else {
                $processedRows++;
            }

            $row = Row::query()->create(
                [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'date' => $data['date'],
                ]
            );
            broadcast(new RowCreated($row))->toOthers();
        }

        // Сохраняем прогресс выполнения в Redis
        $chunkIndex = ($this->startLineNumber - 1) / 1000; // Индекс текущего чанка
        Redis::set("chunk_progress:$chunkIndex", $processedRows);
    }
}
