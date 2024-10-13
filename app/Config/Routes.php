<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index', ['as' => 'home.index']);
$routes->get('home/index', 'HomeController::index');

// Product detail page
$routes->get('/products/(:num)', 'HomeController::show/$1');


$routes->get('/login', 'AuthController::login');

$routes->post('/authenticate', 'AuthController::authenticate');

$routes->get('/register', 'AuthController::register');

$routes->post('/store', 'AuthController::store');

$routes->get('/logout', 'AuthController::logout');



// Cart functionalities
$routes->group('cart', function($routes) {
    $routes->get('', 'CartController::index', ['as' => 'cart.index']);               // View cart
    $routes->post('add', 'CartController::addToCart', ['as' => 'cart.add_to_cart']);  // Add to cart
    $routes->post('increase/(:num)', 'CartController::increaseQuantity/$1', ['as' => 'cart.increase']);  // Increase quantity
    $routes->post('decrease/(:num)', 'CartController::decreaseQuantity/$1', ['as' => 'cart.decrease']);  // Decrease quantity
    $routes->delete('remove/(:num)', 'CartController::removeFromCart/$1', ['as' => 'cart.remove']); // Remove from cart
    $routes->post('clear', 'CartController::clearCart', ['as' => 'cart.clear']); // Clear cart
});

// Orders routes
$routes->group('orders', function($routes) {
    $routes->get('', 'OrderController::index', ['as' => 'order.index']); // List orders
    $routes->get('show/(:num)', 'OrderController::show', ['as' => 'order.show']); // Show order details
    $routes->post('checkout', 'OrderController::checkout', ['as' => 'order.checkout']); // Checkout
    $routes->get('confirmation', 'OrderController::confirmation', ['as' => 'order.confirmation']); // Order confirmation
    $routes->get('history/(:num)', 'OrderController::order_history', ['as' => 'order.history']); // Order history

    // $routes->get('checkout', 'OrderController::checkout');
    $routes->post('payment-success', 'OrderController::paymentSuccess');

});

// API V2
$routes->group('api/v2', ['namespace' => 'App\Controllers\Api\V2'], function($routes) {
    // Define a route for the CategoryController index method
    $routes->get('brands', 'BrandController::index');    
});