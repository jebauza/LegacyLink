<?php

namespace App\Imports;

use App\Models\Office;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;


class OfficesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $index => $row)
            {
                if ($index != 0) {
                    $office = Office::updateOrCreate(
                        ['cif' => $row[1], 'name' => $row[4]],
                        [
                            'business_name' => $row[2],
                            'address' => $row[5],
                            'phone' => $row[6],
                            'contact_person' => $row[7],
                            'email' => $row[8],
                        ]
                    );

                    if ($row[8] && strpos($row[8], '@') != false) {
                        $employee = Employee::updateOrCreate(
                            ['email' => $row[8]],
                            [
                                'name' => $row[7] ?? $row[8],
                                'password' => Hash::make('Qwe2021*asd')
                            ]
                        );

                        $employee->password = Hash::make('qweasdzxc');

                        if ($employee) {
                            $employee->assignRole('Admin Sucursal');
                            $employee->offices()->attach($office->id);
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(substr($e->getMessage(),0,500));
        }
    }
}
