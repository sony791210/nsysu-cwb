<?php

use Illuminate\Database\Seeder;

class AclsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exist_acls = DB::table('acl')->pluck('name')->toArray();
        $insert_data = [];
        foreach(Config::get('acl.acls') as $name => $desc) 
        {
            if ( ! in_array($name, $exist_acls)) {
                $data = [
                    'name' => $name,
                    'description' => $desc,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                array_push($insert_data, $data);
            }
        }
        if (!empty($insert_data)) DB::table('acl')->insert($insert_data);
    }
}
