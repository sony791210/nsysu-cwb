<?php


use App\Module\Employee\Employee;
use Hashids\Hashids;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $hashids = new Hashids('crm', 10);
            $code = $hashids->encode($employee->employee_id);
            $employee->personal_code = $code;
            $employee->save();
        }
    }
}
