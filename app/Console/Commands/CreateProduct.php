<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Throwable;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product {numberProduct}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create product with number of products';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $numberProduct = $this->argument('numberProduct');
        try {
            Product::factory($numberProduct)->create();
            $this->info("Created success");
        } catch (Throwable $exception) {
            $this->info($exception->getMessage());
        }
    }
}
