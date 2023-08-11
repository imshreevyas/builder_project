<?php

namespace App\Imports;

use App\Models\salary;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUser implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new salary([
           'user_id' => Auth::user()->id,  
           'empCode' => $row[0],  
           'basic' => $row[1],
           'hra' => $row[2],
           'ca' => $row[3],
           'total' => $row[4]
        ]);
    }
}
