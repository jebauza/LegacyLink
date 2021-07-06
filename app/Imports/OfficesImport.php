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
        $adminOffice = Role::find(2); //Admin Sucursal
        
        try {
            DB::beginTransaction();
            foreach ($rows as $index => $row)
            {
                if ($index != 0) {
                    preg_match('/[0123456789]{5,5}/', $row[5], $matches, PREG_OFFSET_CAPTURE);
                    $cp = null;
                    $city = null;
                    $address = $row[5];
                    if (!empty($matches)) {
                        $cp = $matches[0][0];
                        $city = substr($row[5], $matches[0][1] + 6);
                        $address = $matches[0][1] > 1 ? substr($row[5], 0, $matches[0][1] - 1) : $address;
                    }
                    $office = Office::updateOrCreate(
                        ['cif' => $row[1], 'name' => $row[4]],
                        [
                            'business_name' => $row[2],
                            'address' => $address,
                            'city' => $city,
                            'cp' => $cp,
                            'country' => 'España',
                            'phone' => $row[6],
                            'contact_person' => $row[7],
                            'email' => $row[8],
                        ]
                    );

                    if ($row[8] && strpos($row[8], '@') != false) {
                        $manager = Employee::firstOrNew(
                            ['email' => $row[8]],
                            [
                                'name' => $row[7] ?? $row[8]
                            ]
                        );
                        $manager->password = Hash::make('Qwe2021*asd');
                        $manager->save();

                        if ($manager) {
                            $manager->assignRole($adminOffice);
                            $manager->offices()->attach($office->id);
                        }
                    }

                    if ($row[10] && strpos($row[10], '@') != false) {
                        $administrative = Employee::firstOrNew(
                            ['email' => $row[10]],
                            [
                                'name' => $row[9] ?? $row[10]
                            ]
                        );
                        $administrative->password = Hash::make('Qwe2021*asd');
                        $administrative->save();

                        if ($administrative) {
                            $administrative->assignRole($adminOffice);
                            $administrative->offices()->attach($office->id);
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
