<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        // Create order_items table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'discount' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign keys
        // $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        // Drop the order_items table
        $this->forge->dropTable('order_items');
    }
}
