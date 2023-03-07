<?php

namespace App\Imports;

use App\Models\Invoices;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoicesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Invoices([
//            'name'     => $row[0],
//            'email'    => $row[1],
//            'password' => Hash::make($row[2]),
        ]);
    }
}
