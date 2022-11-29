<?php

namespace Database\Seeders;

use App\Models\Producer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Ducati',
        ];
        Producer::create($data);

        $data = [
            'name' => 'Ferrari',
        ];
        Producer::create($data);

        $data = [
            'name' => 'Lamborghini',
        ];
        Producer::create($data);

        $data = [
            'name' => 'Audi',
        ];
        Producer::create($data);
    }
}
