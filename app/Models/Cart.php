<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $table            = 'carts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',        // Assuming you have a user_id to track which user the cart belongs to
        'product_id',     // Foreign key to the products table
        'qty',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Method to join cart and product tables
    public function getCartWithProductDetails()
    {
        return $this->select('carts.*, products.name as product_name, products.price, products.image_path')
                    ->join('products', 'carts.product_id = products.id')
                    ->findAll(); // fetch all cart items with product details
    }

     // Method to remove a specific cart item
   public function removeCartItem($userId, $productId)
   {
       return $this->where(['user_id' => $userId, 'product_id' => $productId])->delete();
   }

   // Method to clear the entire cart for a user
   public function clearCart($userId)
   {
       if ($this->where('user_id', $userId)->delete()) 
       {
           return true;
       }
       else
       {
           return false;
       }
   }
}
