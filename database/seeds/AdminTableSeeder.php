<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_array = [
            ['email'=>'ahmed_bermawy@yahoo.com','password'=>'123456','first_name'=>'Ahmed','last_name'=>'Bermawy'],
            ];

        foreach ($admin_array as $row)
        {
            $result = \Sentinel::registerAndActivate($row);
            $user = \Sentinel::findById($result['id']);
            $role = \Sentinel::findRoleBySlug('admin');
            $role->users()->attach($user);
        }

        $this->command->info('Seeding Admin ...');
    }
}
