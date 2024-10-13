<?php

namespace App\Controllers;

use App\Models\Product; // Ensure you create this model
use App\Models\Category; // Ensure you create this model
use App\Models\Brand; // Ensure you create this model
use CodeIgniter\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Load the models
        $categoryModel = new Category();
        $productModel = new Product();

        // Get all categories
        $categories = $categoryModel->findAll();

        // Get search and category filters from the request
        $category = $this->request->getGet('category');
        $searchTerm = $this->request->getGet('search');

        // Build the query
        $query = $productModel->asArray();

        // Apply filters based on the request
        if ($category && $category != 'All') {
            $query->where('category_id', $category);
        }

        if ($searchTerm) {
            $query->like('name', $searchTerm);
        }

        // Fetch products based on filters
        $products = $query->findAll();

        // Prepare data for the view
        $data = [
            'product' => $products,
            'categories' => $categories,
            'selectedCategory' => $category, // Pass the selected category to the view
            'searchTerm' => $searchTerm // Pass the search term to the view
        ];

        // Load the view with data
        return view('frontend/home', $data);
    }

    public function show($id)
    {
        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
        }

        // Load category and brand models
        $categoryModel = new Category();
        $brandModel = new Brand();

        // Fetch category and brand by their IDs
        $category = $categoryModel->find($product['category_id']);
        $brand = $brandModel->find($product['brand_id']);

        // Pass the product and its associated category and brand to the view
        return view('frontend/show', [
            'product' => $product,
            'category' => $category,
            'brand' => $brand,
        ]);
    }
}
