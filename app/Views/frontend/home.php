<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <!-- Error and Success Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Search and Filter Form -->
    <form method="GET" action="<?= site_url('home/index') ?>" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= esc($searchTerm) ?>">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="All" <?= ($selectedCategory == 'All') ? 'selected' : '' ?>>All Categories</option>
                    <?php foreach ($categories as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($selectedCategory == $row['id']) ? 'selected' : '' ?>>
                            <?= esc($row['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php foreach ($product as $item): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= site_url('products/' . $item['id']) ?>">
                    <div class="card">
                        <img src="<?= esc($item['image_path']) ?>" class="card-img-top" alt="<?= esc($item['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($item['name']) ?></h5>                            
                            <p class="card-text"><strong>$<?= esc($item['price']) ?></strong></p>
                            
                        </div>
                        <!-- Add to Cart Form -->
                        <form action="<?= route_to('cart.add_to_cart') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= esc($item['id']) ?>">
                            <div class="d-flex align-items-center mb-3">
                                <input type="number" name="qty" class="form-control w-25" value="1" min="1">
                                <button type="submit" class="btn btn-primary ms-3">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </a>                
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?= $this->endSection() ?>
