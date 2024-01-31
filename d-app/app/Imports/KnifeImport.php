<?php

namespace App\Imports;

use App\Models\Knife;
use Maatwebsite\Excel\Concerns\ToModel;

class KnifeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Knife([
            //
        ]);
    }
}
