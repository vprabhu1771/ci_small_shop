<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Electronics',                
            ],
            [
                'name' => 'Furniture',                
            ],
            [
                'name' => 'Books',            
            ],
            [
                'name' => 'Clothing',            
            ],
            [
                'name' => 'Sports',            
            ],
        ];

        // Insert the data into the 'categories' table
        $this->db->table('categories')->insertBatch($data);
    }
}
