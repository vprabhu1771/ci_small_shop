<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
Register Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="<?= base_url('path/to/bootstrap.css') ?>"> <!-- Add your Bootstrap CSS -->
</head>
<body>

<div class="container">
    <h1>Register</h1>

    <!-- Display validation errors -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Display success message -->
    <?php if (session()->getFlashdata('success_message')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success_message')) ?>
        </div>
    <?php endif; ?>

    <form id="registrationForm" action="<?= site_url('store') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control">
            <div class="error" id="nameError"></div>
        </div>
        
        <div class="form-group">
            <label>Gender</label><br>
            <label><input type="radio" name="gender" value="male"> Male</label>
            <label><input type="radio" name="gender" value="female"> Female</label>
            <div class="error" id="genderError"></div>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
            <div class="error" id="emailError"></div>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
            <div class="error" id="passwordError"></div>
        </div>
        
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">
            <div class="error" id="confirmPasswordError"></div>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone No</label>
            <input type="text" id="phone" name="phone" class="form-control">
            <div class="error" id="phoneError"></div>
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control">
            <div class="error" id="addressError"></div>
        </div>
        
        <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" id="pincode" name="pincode" class="form-control">
            <div class="error" id="pincodeError"></div>
        </div>
        
        <div class="form-group">
            <label for="country">Country</label>
            <select id="country" name="country" class="form-control">
                <option value="">Select Country</option>
                <option value="In">India</option>
                <option value="us">United States</option>
                <option value="uk">United Kingdom</option>
                <option value="ca">Canada</option>
                <!-- Add more countries as needed -->
            </select>
            <div class="error" id="countryError"></div>
        </div>
        
        <div class="form-group">
            <label for="state">State</label>
            <select id="state" name="state" class="form-control">
                <option value="">Select state</option>
                <option value="Tn">Tamil Nadu</option>
                <option value="kr">Kerala</option>
                <option value="kn">Karnataka</option>
                <!-- Add more states as needed -->
            </select>
            <div class="error" id="stateError"></div>
        </div>
        
        <div class="form-group">
            <label for="captcha">Captcha</label>
            <div class="captcha">
                <input type="text" id="captcha" name="captcha" class="form-control">
                <img src="<?= base_url('path/to/captcha.jpg') ?>" alt="Captcha">
            </div>
            <div class="error" id="captchaError"></div>
        </div>
        
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    
    <a href="<?= site_url('login') ?>">Already have an account? Login</a>
</div>

<script src="<?= base_url('path/to/bootstrap.js') ?>"></script> <!-- Add your Bootstrap JS -->
</body>
</html>

<?= $this->endSection() ?>
