<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Libraries\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data =array(            
            'email' =>'admin@gmail.com',            
            // 'password'=>password_hash('admin',PASSWORD_BCRYPT),
            'password' => Hash::make('admin')
        );

        $this->db->table('users')->insert($data);
    }
}