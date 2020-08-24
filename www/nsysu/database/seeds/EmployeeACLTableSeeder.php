<?php

use Illuminate\Database\Seeder;

class EmployeeACLTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
                [
                    'name' => 'sales',
                    'password' => Hash::make('ksd53890045'),
                    'displayName' => 'Sales',
                    'email' => 'sales@citypass.tw',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'admin',
                    'password' => Hash::make('ksd53890045'),
                    'displayName' => 'Admin',
                    'email' => 'admin@citypass.tw',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]]
        );


        DB::table('role')->insert([
            [
                'name' => '系統管理者',
                'description' => '系統管理者',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '業務管理',
                'description' => '業務管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]]);

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
            ],
            [
                'role_id' => 1,
                'acl_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 2,
                'acl_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('employee_role')->insert([
            [
                'employee_id' => 1,
                'role_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ], [
                'employee_id' => 2,
                'role_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]]);
    }
}
