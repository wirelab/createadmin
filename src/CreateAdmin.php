<?php

namespace Wirelab\CreateAdmin;

use \Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a admin';

    /**
     * Create a new command instance.
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
        $class = config(
            'auth.providers.' . config(
                'auth.guards.' . config(
                    'auth.defaults.guard'
                ) . '.provider'
            ) . '.model'
        );
        $user = new $class;
        $fillables = $user->getFillable();

        $total = count($fillables);

        foreach($fillables as $key => $fillable) {
            if ($fillable == 'password') {
                $user->password = \Hash::make($this->secret(($key+1) . "/" . $total . " User $fillable"));
            } else {
                $user->$fillable = $this->ask(($key+1) . "/" . $total . " User $fillable");
            }
        }

        if ($this->confirm("Do you want to create the user?", true)) {
            $user->save();
            $this->info("User created (id: {$user->id}))");
        }

        return true;
    }
}