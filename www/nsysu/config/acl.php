<?php

return [
    // 擁有最高權限身份
    'adminer' => explode(',', env('ACL_ADMIN', 'ksdadmin')),

    // 受保護的帳戶，只要設定在此名單內，除了自己皆不可被他人修改
    'protected_account' => ['admin', 'ksdadmin'],

    'acls' => [
        'ACL_MANAGER' => '權限管理',
        'ROLE_MANAGER' => '角色管理',
        'ACCOUNT_MANAGER' => '帳號管理',
        'SALES_MANAGER' => '業務管理',
        'LINE_MANAGER' => 'Line經銷管理'
    ],
];
