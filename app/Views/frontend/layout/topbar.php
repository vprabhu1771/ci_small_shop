<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Small Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('/') ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            
            <?php if (!session()->get('isLoggedIn')) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('login') ?>">Login / Register</a>
                </li>
            <?php endif; ?>
            
            <?php if (session()->get('isLoggedIn')) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= session()->get('user_name') ?> <!-- Display the user's name -->
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= site_url('cart') ?>">Cart</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('order') ?>">Order</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('profile') ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
