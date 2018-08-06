<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin for backend form command line';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');
        $first_name = $this->ask('What is your first name?');
        $last_name = $this->ask('What is your last name?');

        $array = [
            'email'=>$email,
            'password'=>$password,
            'first_name'=>$first_name,
            'last_name'=>$last_name] ;

        $result = \Sentinel::registerAndActivate($array);
        $user = \Sentinel::findById($result['id']);
        $role = \Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);

        $this->info("New admin created for $email");
    }
}
