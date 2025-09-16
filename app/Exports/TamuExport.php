<?php

namespace App\Exports;

use App\Models\Tamu;
use Maatwebsite\Excel\Concerns\FromCollection;

class TamuExport implements FromCollection
{
    public function collection()
    {
        return Tamu::all();
    }
}