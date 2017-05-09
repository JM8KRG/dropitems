<?php

use Illuminate\Database\Seeder;

class DropItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '書籍',
            'PCパーツ / PC周辺機器',
            'アニメグッズ',
            'CD / DVD / BD',
            'その他'
        ];
        foreach ($categories as $category) {
            DB::table('item_categories')->insert([
                'category' => $category,
            ]);
        }

        $conditions = [
            '非常に良い',
            '良い',
            '可'
        ];
        foreach ($conditions as $condition) {
            DB::table('item_conditions')->insert([
                'condition' => $condition,
            ]);
        }
    }
}
