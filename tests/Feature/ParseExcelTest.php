<?php

namespace Tests\Feature;

use App\Jobs\ProcessExcelChunk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ParseExcelTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Log::info('Setting up tests');
        Artisan::call('migrate:fresh', ['--env' => 'testing']);
        User::factory()->create([
            'email' => '1@1',
            'password' => '1',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_accepts_xlsx_file_lighter_than_4096_kb()
    {
        Storage::fake('local');

        $file = new UploadedFile('short.xlsx', 'short.xlsx');

        $response = $this->withBasicAuth('1@1', '1')
            ->post(route('parse.excel'), [
                'file' => $file
            ]);

        $response->assertStatus(302);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_validation_errors_when_parsing_excel_file()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('invalid_data.csv', 5000);

        $response = $this->withBasicAuth('1@1', '1')
            ->post(route('parse.excel'), [
                'file' => $file,
            ]);

        $response->assertSessionHasErrors();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_unauthorized_access()
    {
        $response = $this->post(route('parse.excel'));

        $response->assertStatus(401);
    }
}
