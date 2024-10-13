<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run()
    {
                
        $data = [
            [
                'name'          => 'Milk',
                'price'         => 100.00,
                'category_id'   => 1, // Make sure this category exists
                'brand_id'      => 1, // Make sure this brand exists
                'qty'           => 50,
                'alert_stock'   => 10,                
            ],
            [
                'name'          => 'Mobile',
                'price'         => 150.50,
                'category_id'   => 2, // Make sure this category exists
                'brand_id'      => 2, // Make sure this brand exists
                'qty'           => 30,
                'alert_stock'   => 5,                
            ],
            [
                'name'          => 'laptop',
                'price'         => 75.00,
                'category_id'   => 3, // Make sure this category exists
                'brand_id'      => 3, // Make sure this brand exists
                'qty'           => 100,
                'alert_stock'   => 20,                
            ],
            [
                'name'          => 'vegitable',
                'price'         => 200.00,
                'category_id'   => 4, // Make sure this category exists
                'brand_id'      => 4, // Make sure this brand exists
                'qty'           => 10,
                'alert_stock'   => 2,
            ],
        ];

        // Using Query Builder to insert data
        $this->db->table('products')->insertBatch($data);
    }
}
