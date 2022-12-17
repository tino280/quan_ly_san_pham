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
            'type_id' => 2,
        ];
        Producer::create($data);

        $data = [
            'name' => 'Ferrari',
            'type_id' => 1,
        ];
        Producer::create($data);

        $data = [
            'name' => 'Lamborghini',
            'type_id' => 1,
        ];
        Producer::create($data);

        $data = [
            'name' => 'Audi',
            'type_id' => 1,
        ];
        Producer::create($data);

        $data = [
            'name' => 'Giant',
            'type_id' => 3,
        ];
        Producer::create($data);
    }
}
