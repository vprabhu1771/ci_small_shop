<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderItem; // Import the OrderItem model
use App\Models\Cart; // Make sure you import the Cart model if it's used

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

// Razorpay
use Razorpay\Api\Api;

class OrderController extends Controller
{
    protected $orderModel;
    protected $orderItemModel; // Declare the property
    protected $cartModel;
    
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem(); // Instantiate the OrderItem model
        $this->cartModel = new Cart(); // Make sure to instantiate the Cart model if it's used
    }

    public function index()
    {
        $userId = session()->get('user')['id']; // Assuming user ID is stored in session
        $orders = $this->orderModel->where('user_id', $userId)
            ->orderBy('id', 'asc')
            ->findAll();

        return view('frontend/order', ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = $this->orderModel->where('id', $id)
            ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontend/order_details', ['order' => $order]);
    }
    
    // Working all issue fixed
    // public function checkout()
    // {
    //     $userId = session()->get('user')['id'];

    //     // Retrieve cart items
    //     $cartItems = $this->cartModel->getCartWithProductDetails($userId);

    //     if (empty($cartItems)) {
    //         return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    //     }

    //     // Begin transaction
    //     $db = \Config\Database::connect();
    //     $db->transBegin();

    //     try {
    //         // Calculate total amount
    //         $totalAmount = array_reduce($cartItems, function ($carry, $cart) {
    //             return $carry + ($cart['price'] * $cart['qty']);
    //         }, 0);

    //         // Prepare order data
    //         $orderData = [
    //             'user_id' => $userId,
    //             'total_amount' => $totalAmount,
    //             'order_status' => 'order_placed'
    //         ];

    //         // Insert the order and get the order ID
    //         $orderId = $this->orderModel->insert($orderData);

    //         // Check if order ID is valid
    //         if (!$orderId) {
    //             throw new \Exception("Failed to create order.");
    //         }

    //         // Store order items
    //         foreach ($cartItems as $row) {
    //             $orderItemsData = [
    //                 'order_id' => $orderId,
    //                 'product_id' => $row['product_id'],
    //                 'qty' => $row['qty'],
    //                 'unit_price' => $row['price'],
    //                 'amount' => $row['qty'] * $row['price'],
    //                 'discount' => 0 // Assuming no discount is applied
    //             ];

    //             // Insert order item
    //             $inserted = $this->orderItemModel->insert($orderItemsData);

    //             // Check if insertion was successful
    //             if (!$inserted) {
    //                 // Log the detailed error message
    //                 log_message('error', 'Failed to insert order item for product ID: ' . $row['product_id'] . ' - ' . json_encode($this->orderItemModel->errors()));
    //                 throw new \Exception("Failed to insert order item for product ID: " . $row['product_id']);
    //             }
    //         }

    //         // Clear the cart
    //         $this->cartModel->clearCart($userId);

    //         // Commit transaction
    //         $db->transCommit();

    //         return redirect()->to(route_to('order.confirmation', $orderId))
    //             ->with('success', 'Order placed successfully.');
    //     } catch (\Exception $e) {
    //         // Rollback transaction in case of error
    //         $db->transRollback();
    //         return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage());
    //     }
    // }
    
    // public function checkout()
    // {
    //     $userId = session()->get('user')['id'];

    //     // Retrieve cart items
    //     $cartItems = $this->cartModel->getCartWithProductDetails($userId);

    //     if (empty($cartItems)) {
    //         return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    //     }

    //     // Calculate total amount
    //     $totalAmount = array_reduce($cartItems, function ($carry, $cart) {
    //         return $carry + ($cart['price'] * $cart['qty']);
    //     }, 0);

    //     // Begin transaction
    //     $db = \Config\Database::connect();
    //     $db->transBegin();

    //     try {
    //         // Prepare order data (but don't finalize it until payment is successful)
    //         $orderData = [
    //             'user_id' => $userId,
    //             'total_amount' => $totalAmount,
    //             'order_status' => 'pending_payment'
    //         ];

    //         // Insert the order and get the order ID
    //         $orderId = $this->orderModel->insert($orderData);

    //         // Create a new Razorpay order
    //         $api = new Api(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));

    //         $razorpayOrder = $api->order->create([
    //             'receipt' => $orderId,
    //             'amount' => $totalAmount * 100, // Razorpay expects the amount in paise
    //             'currency' => 'INR',
    //             'payment_capture' => 1
    //         ]);

    //         // Store the Razorpay order ID in session
    //         session()->set('razorpay_order_id', $razorpayOrder['id']);

    //         // Pass Razorpay order details to the view (payment page)
    //         return view('frontend/payment_page', [
    //             'razorpayOrder' => $razorpayOrder,
    //             'totalAmount' => $totalAmount,
    //             'orderId' => $orderId,
    //             'razorpayKeyId' => getenv('RAZORPAY_KEY_ID')
    //         ]);

    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage());
    //     }
    // }

    public function checkout()
    {
        $userId = session()->get('user')['id'];

        // Retrieve cart items
        $cartItems = $this->cartModel->getCartWithProductDetails($userId);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Begin transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Calculate total amount
            $totalAmount = array_reduce($cartItems, function ($carry, $cart) {
                return $carry + ($cart['price'] * $cart['qty']);
            }, 0);

            // Prepare order data
            $orderData = [
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'order_status' => 'order_placed'
            ];

            // Insert the order and get the order ID
            $orderId = $this->orderModel->insert($orderData);

            // Check if order ID is valid
            if (!$orderId) {
                throw new \Exception("Failed to create order.");
            }

            // Store order items
            foreach ($cartItems as $row) {
                $orderItemsData = [
                    'order_id' => $orderId,
                    'product_id' => $row['product_id'],
                    'qty' => $row['qty'],
                    'unit_price' => $row['price'],
                    'amount' => $row['qty'] * $row['price'],
                    'discount' => 0 // Assuming no discount is applied
                ];

                // Insert order item
                $inserted = $this->orderItemModel->insert($orderItemsData);

                if (!$inserted) {
                    log_message('error', 'Failed to insert order item for product ID: ' . $row['product_id'] . ' - ' . json_encode($this->orderItemModel->errors()));
                    throw new \Exception("Failed to insert order item for product ID: " . $row['product_id']);
                }
            }

            // Initialize Razorpay API
            $apiKey = getenv('RAZORPAY_KEY_ID');
            $apiSecret = getenv('RAZORPAY_KEY_SECRET');
            $api = new Api($apiKey, $apiSecret);

            // Create an order on Razorpay
            $orderAmount = $totalAmount * 100; // Razorpay expects the amount in paise (multiply by 100)
            $orderData = [
                'receipt' => (string) $orderId, // Convert the orderId to a string
                'amount' => $orderAmount,       // This should remain as an integer (in paise)
                'currency' => 'INR',            // Keep this as a string
                'payment_capture' => 1          // Keep this as an integer (auto-capture)
            ];

            $razorpayOrder = $api->order->create($orderData); // Create a new order

            session()->set('order_id', $orderId);

            // Store the Razorpay order ID in session for later use
            session()->set('razorpay_order_id', $razorpayOrder['id']);

            // Commit the transaction
            $db->transCommit();

            // Redirect to the Razorpay payment page
            return view('frontend/razorpay_payment', [
                'orderId' => $orderId,
                'razorpayOrderId' => $razorpayOrder['id'],
                'orderAmount' => $orderAmount / 100, // Show the amount in rupees
                'userEmail' => session()->get('user')['email'], // User email for Razorpay
                'userContact' => session()->get('user')['email'], // User contact for Razorpay
                'apiKey' => $apiKey // Pass the Razorpay API key to the view
            ]);

        } catch (\Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage());
        }
    }
    // public function paymentSuccess()
    // {
    //     $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');
    //     $orderId = session()->get('razorpay_order_id'); // Retrieve the order ID from session

    //     // Update the order status to "Paid"
    //     $this->orderModel->update($orderId, ['status' => 'paid']);

    //     return redirect()->to(route_to('order.confirmation', $orderId))
    //         ->with('success', 'Payment successful and order placed.');
    // }

    public function paymentSuccess()
    {
        $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');

        // dd($razorpayPaymentId);
        $orderId = session()->get('order_id'); // Retrieve Razorpay order ID from session

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Order ID not found. Please try again.');
        }

        // Make sure to fetch the exact order record to update it
        $order = $this->orderModel->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found. Please try again.');
        }

        // Update the order status to "Paid"
        $this->orderModel->update($order['id'], ['status' => 'paid']);

        // Optionally store the payment ID or any other relevant info
        $this->orderModel->update($order['id'], ['payment_id' => $razorpayPaymentId]);

        // Clear the session data
        session()->remove('razorpay_order_id');

        return redirect()->to(route_to('order.confirmation', $order['id']))
            ->with('success', 'Payment successful and order placed.');
    }



    // public function complete_payment()
    // {
    //     $session = session();

    //     $userId = $session->get('user')['id'];
    //     $orderId = $this->request->getPost('order_id');

    //     if (!$orderId) {
    //         return redirect()->route('cart.index')->with('error', 'Order ID is missing.');
    //     }

    //     $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');
    //     $razorpayOrderId = $session->get('razorpay_order_id');

    //     if (!$razorpayPaymentId) {
    //         return redirect()->route('cart.index')->with('error', 'Payment failed or was canceled.');
    //     }

    //     // Begin transaction
    //     $db = \Config\Database::connect();
    //     $db->transBegin();

    //     try {
    //         // Fetch order to validate
    //         $order = $this->orderModel->where('id', $orderId)->first();

    //         if (!$order || $order['order_status'] !== 'pending_payment') {
    //             throw new \Exception("Invalid order status.");
    //         }

    //         // Store Razorpay payment ID in the order
    //         $this->orderModel->update($orderId, [
    //             'payment_id' => $razorpayPaymentId,
    //             'order_status' => 'order_placed'
    //         ]);

    //         // Store order items
    //         $cartItems = $this->cartModel->getCartWithProductDetails($userId);

    //         foreach ($cartItems as $row) {
    //             $orderItemsData = [
    //                 'order_id' => $orderId,
    //                 'product_id' => $row['product_id'],
    //                 'qty' => $row['qty'],
    //                 'unit_price' => $row['price'],
    //                 'amount' => $row['qty'] * $row['price'],
    //                 'discount' => 0
    //             ];

    //             $this->orderItemModel->insert($orderItemsData);
    //         }

    //         // Clear the cart after successful order placement
    //         $this->cartModel->clearCart($userId);

    //         // Commit transaction
    //         $db->transCommit();

    //         return redirect()->to(route_to('order.confirmation', $orderId))
    //             ->with('success', 'Payment successful. Your order has been placed.');
    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         return redirect()->route('cart.index')->with('error', 'Payment failed. Please try again. Error: ' . $e->getMessage());
    //     }
    // }



    public function confirmation()
    {
        $session = session();
        $userId = $session->get('user')['id'];

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to view your orders.');
        }

        // Load the Order model
        $orderModel = new Order();

        // Fetch the most recent order for the logged-in user
        $order = $orderModel->where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'No orders found.');
        }

        // Fetch the related order items
        // $orderItems = $orderModel->getOrderItems($order['id']);

        // dd($orderItems);

        // Load the OrderItem model
        $orderItemModel = new OrderItem();

        // Fetch the related order items along with product information
        $orderItems = $orderItemModel->getOrderItemsWithProducts($order['id']);

        // Render the order confirmation view with order and order items
        return view('frontend/order_confirmation', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function order_history($id)
    {
        $history = $this->orderHistoryModel->where('order_id', $id)->findAll();

        return view('frontend/order_history', ['history' => $history]);
    }
}
