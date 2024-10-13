<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\User;
use App\Libraries\Hash;

class AuthController extends BaseController
{
    public function login()
    {
        return view('frontend/auth/login');
    }

    public function authenticate()
    {
        $request = \Config\Services::request();

        // Validate inputs
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Return to login page with validation errors
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get email and password from request
        $email = $request->getPost('email');
        $password = $request->getPost('password');

        // Check if the user exists
        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Log the user in
            session()->set('user', $user);

            echo "working";

            // Redirect to dashboard or home page
            return redirect()->to('/');
        }

        // Return back with error
        return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Set flash data for the success message
        session()->setFlashdata('success', 'You have been logged out..');

        // Redirect to the login page or any page
        return redirect()->to('/')->with('error', 'You have been logged out.');
    }


    public function register()
    {
        return view('frontend/auth/register');
    }

    public function store()
    {
        // Load the User and Role models
        $user = new User();
      

        // Define validation rules
        $validationRules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'confirmPassword' => 'required|matches[password]',
            // 'phone' => 'required',
            // 'address' => 'required',
            // 'pincode' => 'required',
            // 'country' => 'required',
            // 'captcha' => 'required'
        ];

        // Validate the request
        if (!$this->validate($validationRules)) {
            // Validation failed, return errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            // Create a new user
            $data = [                
                'email' => $this->request->getPost('email'),
                // 'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT), // Hash the password
                'password' => Hash::make($this->request->getPost('password'))                
            ];

            // Insert user into the database
            $user->insert($data);
            $userId = $user->insertID(); // Get the last inserted ID

            // Assign the 'Customer' role to the user
        

            // Set success message
            session()->setFlashdata('success', 'User registered successfully');

            // Redirect or return response
            return redirect()->to('/frontend/auth/login')->with('success', 'Registration successful!');    
        } 
        catch (ValidationException $e) {
            // Validation failed, return errors
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }
}
