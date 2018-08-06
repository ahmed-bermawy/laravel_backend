<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin Roles
        $role = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            "permissions" => ["admin" => true],
        ]);

        // Create Editor Role
        $role = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Editor',
            'slug' => 'editor',
            "permissions" => ["editor" => true],
        ]);

        // Create Contributor Role
        $role = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Contributor',
            'slug' => 'contributor',
            "permissions" => ["contributor" => true],
        ]);

        // Create Subscriber Role
        $role = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Subscriber',
            'slug' => 'subscriber',
            "permissions" => ["subscriber" => true],
        ]);

        $this->command->info('Seeding Roles ...');
    }
}
