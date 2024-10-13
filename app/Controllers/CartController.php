<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\Product;
use CodeIgniter\Controller;

class CartController extends Controller
{
    protected $cartModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    public function index()
    {
        $session = session();
        $user_id = $session->get('user')['id']; // Assuming you store user ID in session
        $data['carts'] = $this->cartModel->where('user_id', $user_id)->getCartWithProductDetails();

        return view('frontend/cart', $data);
    }

    public function addToCart()
    {
        $session = session();
        $user_id = $session->get('user')['id'];
        // dd($user_id);
        $productId = $this->request->getPost('product_id');
        // $qty = 1;
        $qty = intval($this->request->getPost('qty')); // Convert to integer        

        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $existingCartItem = $this->cartModel->where('product_id', $productId)
            ->where('user_id', $user_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem['qty'] += 1;
            $this->cartModel->update($existingCartItem['id'], $existingCartItem);
            return redirect()->back()->with('success', $product['name'] . " quantity updated in your cart.");
        } else {
            $this->cartModel->save([
                'product_id' => $productId,
                'user_id' => $user_id,
                'qty' => $qty,
            ]);
            return redirect()->back()->with('success', $product['name'] . " added to your cart.");
        }
    }

    public function increaseQuantity($id)
    {
        $session = session();
        $user_id = $session->get('user')['id'];

        $cartItem = $this->cartModel->find($id);

        if (!$cartItem) {
            return redirect()->to('/cart')->with('error', 'Cart item not found.');
        }

        if ($cartItem['user_id'] != $user_id) {
            return redirect()->to('/cart')->with('error', 'You are not authorized to update this item in the cart.');
        }

        $cartItem['qty'] += 1;
        $this->cartModel->update($id, $cartItem);

        return redirect()->to('/cart')->with('success', 'Quantity increased for ' . $cartItem['product_id']);
    }

    public function decreaseQuantity($id)
    {
        $session = session();
        $user_id = $session->get('user')['id'];

        $cartItem = $this->cartModel->find($id);

        if (!$cartItem) {
            return redirect()->to('/cart')->with('error', 'Cart item not found.');
        }

        if ($cartItem['user_id'] != $user_id) {
            return redirect()->to('/cart')->with('error', 'You are not authorized to update this item in the cart.');
        }

        // Decrease the quantity but ensure it doesn't go below 1
        $cartItem['qty'] = max($cartItem['qty'] - 1, 1);
        $this->cartModel->update($id, $cartItem);

        return redirect()->to('/cart')->with('success', 'Quantity decreased for ' . $cartItem['product_id']);
    }

    public function removeFromCart($id)
    {
        $session = session();
        $user_id = $session->get('user')['id'];

        $cartItem = $this->cartModel->find($id);

        if (!$cartItem) {
            return redirect()->to('/cart')->with('error', 'Cart item not found.');
        }

        if ($cartItem['user_id'] != $user_id) {
            return redirect()->to('/cart')->with('error', 'You are not authorized to remove this item from the cart.');
        }

        $this->cartModel->delete($id);

        return redirect()->to('/cart')->with('success', 'Item removed from your cart.');
    }

    public function clearCart()
    {
        $session = session();
        $user_id = $session->get('user')['id'];

        $this->cartModel->where('user_id', $user_id)->delete();

        return redirect()->to('/cart')->with('success', 'Cart cleared successfully.');
    }
}
