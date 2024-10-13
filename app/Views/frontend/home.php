<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">

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
                            <a href="<?= site_url('cart') ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?= $this->endSection() ?>
