<?php

return [

    'roles' => [
        ['id' => 1, 'name' => 'Super Admin'],
        ['id' => 2, 'name' => 'Admin Sucursal'],
        ['id' => 3, 'name' => 'Asesor']
    ],

    'permissions' => [

        /* Offices */
        ['name' => 'offices.view', 'roles' => [1]],
        ['name' => 'offices.index', 'roles' => [1]],
        ['name' => 'offices.store', 'roles' => [1]],
        ['name' => 'offices.show', 'roles' => [1]],
        ['name' => 'offices.update', 'roles' => [1]],

        /* Employee */
        ['name' => 'employees.view', 'roles' => [1,2]],
        ['name' => 'employees.index', 'roles' => [1,2]],
        ['name' => 'employees.store', 'roles' => [1,2]],
        ['name' => 'employees.show', 'roles' => [1,2]],
        ['name' => 'employees.update', 'roles' => [1,2]],
        ['name' => 'employees.activate', 'roles' => [1,2]],
        ['name' => 'employees.deactivate', 'roles' => [1,2]],

    ],

    'employees_admin' => [
        ['name' => 'Albia Admin', 'email' => 'superadmin@albia.es', 'password' => 'Qwe2021*asd', 'role' => 1]
    ],

    'ceremony_types' => [
        ['id' => 1, 'name' => 'Inhumación'],
        ['id' => 2, 'name' => 'Sepelio'],
        ['id' => 3, 'name' => 'Sepultura'],
        ['id' => 4, 'name' => 'Incineración']
    ]
];
