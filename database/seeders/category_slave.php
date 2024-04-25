<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class category_slave extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'category_id' => 3, 'name' => 'Bollywood', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:52:39', 'updated_at' => '2024-04-24 10:52:39'],
            ['id' => 2, 'category_id' => 6, 'name' => 'Vastu Tips', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:52:39', 'updated_at' => '2024-04-24 10:52:39'],
            ['id' => 3, 'category_id' => 9, 'name' => 'Lifestyle', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:53:54', 'updated_at' => '2024-04-24 10:53:54'],
            ['id' => 4, 'category_id' => 10, 'name' => 'Automobiles', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:53:54', 'updated_at' => '2024-04-24 10:53:54'],
            ['id' => 5, 'category_id' => 11, 'name' => 'Delhi', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 6, 'category_id' => 11, 'name' => 'Banglore', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 7, 'category_id' => 11, 'name' => 'MP', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 8, 'category_id' => 11, 'name' => 'Bihar', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 9, 'category_id' => 11, 'name' => 'UP', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 10, 'category_id' => 11, 'name' => 'Rajasthan', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 11, 'category_id' => 11, 'name' => 'Haryana', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:56:09', 'updated_at' => '2024-04-24 10:56:09'],
            ['id' => 12, 'category_id' => 12, 'name' => 'Law', 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:59:06', 'updated_at' => '2024-04-24 10:59:06'],
        ];

        DB::table('category_slave')->insert($data);
    }
}
