<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addfield([
            'id'=>[
                'type' => 'INT',
                'unsigned' =>true,
                'auto_increment' =>true,
            ],            
            'email'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
            ],
            'password'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
            ],            
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addkey('id',true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
