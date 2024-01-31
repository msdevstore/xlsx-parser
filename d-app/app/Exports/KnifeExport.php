<?php

namespace App\Exports;

use App\Models\Knife;
use Maatwebsite\Excel\Concerns\FromCollection;

class KnifeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Knife::all();
    }
}
