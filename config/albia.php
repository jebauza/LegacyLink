<?php

return [

    'web_client_url' => env('WEB_CLIENT_URL', 'https://web.celebrasuvida.es'),

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
        ['name' => 'offices.destroy', 'roles' => [1]],

        /* Employee */
        ['name' => 'employees.view', 'roles' => [1,2]],
        ['name' => 'employees.index', 'roles' => [1,2]],
        ['name' => 'employees.store', 'roles' => [1,2]],
        ['name' => 'employees.show', 'roles' => [1,2]],
        ['name' => 'employees.update', 'roles' => [1,2]],
        ['name' => 'employees.destroy', 'roles' => [1,2]],
        ['name' => 'employees.status', 'roles' => [1,2]],
        ['name' => 'employees.force-delete', 'roles' => [1,2]],

        /* Webs */
        ['name' => 'webs.view', 'roles' => [1,2,3]],
        ['name' => 'webs.index', 'roles' => [1,2,3]],
        ['name' => 'webs.store', 'roles' => [1,2,3]],
        ['name' => 'webs.show', 'roles' => [1,2,3]],
        ['name' => 'webs.update', 'roles' => [1,2,3]],
        ['name' => 'webs.destroy', 'roles' => [1,2]],

        /* Users */
        ['name' => 'users.view', 'roles' => [1,2,3]],
        ['name' => 'users.index', 'roles' => [1,2,3]],
        ['name' => 'users.store', 'roles' => [1,2,3]],
        ['name' => 'users.show', 'roles' => [1,2,3]],
        ['name' => 'users.update', 'roles' => [1,2,3]],
        ['name' => 'users.destroy', 'roles' => [1,2,3]],
        ['name' => 'users.status', 'roles' => [1,2,3]],
        ['name' => 'users.force-delete', 'roles' => [1,2]],

    ],

    'employees_admin' => [
        ['name' => 'Albia Admin', 'email' => 'superadmin@albia.es', 'password' => 'Qwe2021*asd', 'role' => 1]
    ],

    'ceremony_types' => [
        ['id' => 1, 'name' => 'Inhumación'],
        ['id' => 2, 'name' => 'Ceremonia'],
        ['id' => 3, 'name' => 'Sepultura'],
        ['id' => 4, 'name' => 'Incineración']
    ],

    'provinces' => ['Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres',
        'Cádiz','Cantabria','Castellón','Ciudad Real','Córdoba','La Coruña','Cuenca','Gerona','Granada','Guadalajara',
        'Guipúzcoa','Huelva','Huesca','Islas Baleares','Jaén','León','Lérida','Lugo','Madrid','Málaga','Murcia','Navarra',
        'Orense','Palencia','Las Palmas','Pontevedra','La Rioja','Salamanca','Segovia','Sevilla','Soria','Tarragona',
        'Santa Cruz de Tenerife','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza'
    ],

];
