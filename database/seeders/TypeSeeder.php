<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Ô tô',
        ];
        Type::create($data);

        $data = [
            'name' => 'Xe máy',
        ];
        Type::create($data);

        $data = [
            'name' => 'Xe đạp',
        ];
        Type::create($data);
    }
}
