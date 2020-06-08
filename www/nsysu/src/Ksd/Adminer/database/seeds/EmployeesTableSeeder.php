<?php
namespace Ksd\Adminer\Database\Seeds;

use Illuminate\Database\Seeder;
use Hash;
use DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('employees')->insert([
            'account' => 'admin',
            'password' => Hash::make('ksd123456'),
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('role')->insert([
            'name' => '系統管理者',
            'description' => '系統管理者',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('acl')->insert([
            [
                'name' => 'ACCOUNT_MANAGER',
                'description' => '帳號管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'ROLE_MANAGER',
                'description' => '角色管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'ACL_MANAGER',
                'description' => '權限管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('role_acl')->insert([
            [
                'role_id' => 1,
                'acl_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'acl_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'acl_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('employee_role')->insert([
            'employee_id' => 1,
            'role_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);*/
        
        DB::table('acl')->insert([
            [
                'name' => 'PRODUCT_REVIEW_MANAGER',
                'description' => '商品審核管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PRODUCT_MANAGER',
                'description' => '商品管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'VERIFICATION',
                'description' => '商品核銷',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
