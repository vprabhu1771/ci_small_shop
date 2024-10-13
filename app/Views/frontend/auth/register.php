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
        
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    
    <a href="<?= site_url('login') ?>">Already have an account? Login</a>
</div>

<script src="<?= base_url('path/to/bootstrap.js') ?>"></script> <!-- Add your Bootstrap JS -->
</body>
</html>

<?= $this->endSection() ?>
