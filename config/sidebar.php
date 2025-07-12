<?php

// config/sidebar.php
return [
    [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'ti-smart-home',
        'permission' => '',
        'children' => [],
    ],
    [
        'label' => 'Categories',
        'route' => 'admin.categories.index',
        'icon' => 'ti ti-category-plus',
        'permission' => '',
        'children' => [],
    ],
    [
        'label' => 'Menus',
        'route' => 'admin.menus.index',
        'icon' => 'ti ti-burger',
        'permission' => '',
        'children' => [],
    ],
    [
        'label' => 'Tables',
        'route' => 'admin.tables.index',
        'icon' => 'ti ti-table',
        'permission' => '',
        'children' => [],
    ],
    [
        'label' => 'Reservations',
        'route' => 'admin.reservations.index',
        'icon' => 'ti-user-search',
        'permission' => '',
        'children' => [],
    ],
      [
        'label' => 'Staffs',
        'route' => 'admin.staffs.index',
        'icon' => 'ti ti-users-group',
        'permission' => '',
        'children' => [],
    ],

    // [
    //     'label' => 'قطاع الإغاثة',
    //     'route' => '',
    //     'icon' => 'ti-heart-handshake',
    //     'permission' => 'people-list',
    //     'children' => [
    //         [
    //             'label' => 'المستفيدين',
    //             'route' => 'people.index',
    //         ],
    //         [
    //             'label' => 'المربعات السكنية',
    //             'route' => 'zones.index',
    //         ],
    //     ],
    // ],

];