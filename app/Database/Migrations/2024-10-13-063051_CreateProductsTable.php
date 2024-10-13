<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'name'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'price'         => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2', // Total of 10 digits, 2 decimal places
            ],
            'category_id'   => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'brand_id'      => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'qty'           => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'alert_stock'   => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'image_path'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => 'no_image_available.jpg', // Default image path
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'     
        ]);

        $this->forge->addPrimaryKey('id');
        // $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('brand_id', 'brands', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
