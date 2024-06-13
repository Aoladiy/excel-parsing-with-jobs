<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RowController extends Controller
{
    public function parseExcel()
    {

    }

    public function getRows(Request $request): Collection
    {
        return DB::table('rows')
            ->select('id', 'name', 'date')
            ->orderBy('date')
            ->get()
            ->groupBy('date');
    }
}
