<?php

namespace App\Console\Commands;

use App\Jobs\ProcessExcelChunk;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ParseExcelFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:excel {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Excel file in chunks of 1000 rows';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray();
        $chunks = array_chunk($rows, 1000);

        foreach ($chunks as $chunk) {
            ProcessExcelChunk::dispatch($chunk);
        }

        $this->info('Excel file parsing started!');
    }
}
