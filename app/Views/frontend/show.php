<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
    <?= esc($product['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .product-image {
        max-height: 500px;
        object-fit: cover;
    }
    .product-details {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
    }
</style>

<div class="container my-5">

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
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="<?= esc($product['image_path']) ?>" alt="<?= esc($product['name']) ?>" class="img-fluid product-image">
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3"><?= esc($product['name']) ?></h1>
            <p class="lead"><?= esc($product['description'] ?? 'No description available.') ?></p>
            <h4 class="text-success mb-3">$<?= number_format($product['price'], 2) ?></h4>

            <!-- Add to Cart Form -->
            <form action="<?= route_to('cart.add_to_cart') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                <div class="d-flex align-items-center mb-3">
                    <input type="number" name="qty" class="form-control w-25" value="1" min="1">
                    <button type="submit" class="btn btn-primary ms-3">Add to Cart</button>
                </div>
            </form>

            <p><strong>Category:</strong> <?= esc($category['name']) ?></p>
            <p><strong>Brand:</strong> <?= esc($brand['name']) ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
