<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogHello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:hello {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log hello';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() :void
    {
        $name = $this->argument('name');
        $this->info("Hello $name .-.");
    }
}
