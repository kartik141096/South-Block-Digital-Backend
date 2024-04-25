<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Home', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:39:51', 'updated_at' => '2024-04-24 10:39:51'],
            ['id' => 2, 'name' => 'Politics', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:40:27', 'updated_at' => '2024-04-24 10:40:27'],
            ['id' => 3, 'name' => 'Entertainment', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:40:48', 'updated_at' => '2024-04-24 10:40:48'],
            ['id' => 4, 'name' => 'World', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:40:48', 'updated_at' => '2024-04-24 10:40:48'],
            ['id' => 5, 'name' => 'Education', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:41:40', 'updated_at' => '2024-04-24 10:41:40'],
            ['id' => 6, 'name' => 'Religion', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:41:40', 'updated_at' => '2024-04-24 10:41:40'],
            ['id' => 7, 'name' => 'Bussiness', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:43:20', 'updated_at' => '2024-04-24 10:43:20'],
            ['id' => 8, 'name' => 'Sports', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:43:20', 'updated_at' => '2024-04-24 10:43:20'],
            ['id' => 9, 'name' => 'Health', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:43:56', 'updated_at' => '2024-04-24 10:43:56'],
            ['id' => 10, 'name' => 'Technology', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:43:56', 'updated_at' => '2024-04-24 10:43:56'],
            ['id' => 11, 'name' => 'India', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:48:01', 'updated_at' => '2024-04-24 10:48:01'],
            ['id' => 12, 'name' => 'Crime', 'is_parent' => 1, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:48:01', 'updated_at' => '2024-04-24 10:48:01'],
            ['id' => 13, 'name' => 'Editorial', 'is_parent' => 0, 'is_active' => 1, 'is_deleted' => 0, 'created_at' => '2024-04-24 10:48:01', 'updated_at' => '2024-04-24 10:48:01'],
        ];

        DB::table('categories')->insert($data);
    }
}
