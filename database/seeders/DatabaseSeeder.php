<?php

namespace Database\Seeders;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::insert([
            [
                'id' => 1,
                'name' => 'user'
            ],[
                'id' => 2,
                'name' => 'admin'
            ]
        ]);

        User::factory()->create([
            'firstname' => 'Test Admin',
            'email' => 'admin@example.com',
            'role_id' => 2
        ]);

        User::factory()->create([
            'firstname' => 'Test User',
            'email' => 'user@example.com',
            'role_id' => 1
        ]);

        Category::insert([
            [
                'id' => 1,
                'name' => 'pizza'
            ], [
                'id' => 2,
                'name' => 'drink'
            ]
        ]);

        Product::insert([[
            'category_id' => 1,
            'name' => 'Сицилийская 40см',
            'price' => 699,
            'description' => 'Разновидность пиццы в итальянской кухне, покрытая комбинацией из четырёх видов сыра, обычно расплавленных вместе, с томатным соусом (росса, красный) или без него (бьянка, белый)'
        ],[
            'category_id' => 1,
            'name' => 'Неаполитанская 40см',
            'price' => 659,
            'description' => 'Главным отличием неаполитанской пиццы является её основа, диаметр которой составляет приблизительно 25 с половиной сантиметров. Классическая неаполитанская пицца небольшая по размеру и тонкая в середине, зато толстая с краёв.'
        ],[
            'category_id' => 1,
            'name' => 'Неаполитанская 30см',
            'price' => 559,
            'description' => 'Главным отличием неаполитанской пиццы является её основа, диаметр которой составляет приблизительно 25 с половиной сантиметров. Классическая неаполитанская пицца небольшая по размеру и тонкая в середине, зато толстая с краёв.'
        ],[
            'category_id' => 1,
            'name' => 'Сицилийская 30см',
            'price' => 599,
            'description' => 'Разновидность пиццы в итальянской кухне, покрытая комбинацией из четырёх видов сыра, обычно расплавленных вместе, с томатным соусом (росса, красный) или без него (бьянка, белый)'
        ],[
            'category_id' => 2,
            'name' => 'Кола 0.5',
            'price' => 79,
            'description' => 'Газированный сладкий безалкогольный напиток, содержащий кофеин'
        ],[
            'category_id' => 2,
            'name' => 'Сок 0.5',
            'price' => 59,
            'description' => 'Напиток из свежих фруктов'
        ]]);

        OrderStatus::insert([
            [
                'id' => '1',
                'name' => 'Closed'
            ],[
                'id' => '2',
                'name' => 'Delivered'
            ],[
                'id' => '3',
                'name' => 'Preparing'
            ]
        ]);

        CartProduct::insert([
            [
                'user_id' => 1,
                'product_id' => 3,
                'quantity' => 1
            ], [
                'user_id' => 1,
                'product_id' => 4,
                'quantity' => 1
            ], [
                'user_id' => 2,
                'product_id' => 3,
                'quantity' => 1
            ], [
                'user_id' => 2,
                'product_id' => 4,
                'quantity' => 1
            ],
        ]);
    }
}
