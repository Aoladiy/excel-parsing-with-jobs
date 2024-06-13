<?php

namespace App\Http\Controllers;

use App\Http\Requests\parseExcelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RowController extends Controller
{
    /**
     * Показать форму загрузки файла.
     */
    public function showUploadForm()
    {
        return view('upload-form');
    }

    /**
     * Распарсить загруженный файл.
     */
    public function parseExcel(parseExcelRequest $request)
    {
        Artisan::call('parse:excel', [
            'file' => $request->file('file'),
        ]);

        return back()->with('success', 'Файл загружен и команда запущена!');
    }

    /**
     * Получить все стрки с группировкой по дате.
     */
    public function getRows(Request $request): Collection
    {
        return DB::table('rows')
            ->select('id', 'name', 'date')
            ->orderBy('date')
            ->get()
            ->groupBy('date');
    }
}
