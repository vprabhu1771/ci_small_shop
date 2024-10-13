<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
Login Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success">
        <?php echo session('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger">
        <?php echo session('error'); ?>
    </div>
<?php endif; ?>
<div class="login-container">
    <h1>Welcome To Login Page</h1>
    <form action="<?= site_url('authenticate') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="text" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="<?= site_url('register') ?>" class="signup-link">Don't have an account? Sign up</a>
</div>
<?= $this->endSection() ?>
