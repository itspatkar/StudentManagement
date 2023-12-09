<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'name' =>  $row['name'],
            'email' =>  $row['email'],
            'gender' => $row['gender'],
            'dob' => $row['dob'],
            'address' => $row['address'],
            'state' => $row['state'],
            'city' => $row['city'],
            'photo' => $row['photo'],
            'skills' => $row['skills'],
            'certificates' => $row['certificates']
        ]);
    }
}
