<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Nike',                
            ],
            [
                'name' => 'Adidas',                
            ],
            [
                'name' => 'Puma',                
            ],
            [
                'name' => 'Under Armour',            
            ],
            [
                'name' => 'Reebok',                
            ]
        ];

        // Using Query Builder to insert data
        $this->db->table('brands')->insertBatch($data);
    }
}
