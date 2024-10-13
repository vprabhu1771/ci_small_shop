<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>Order Confirmation<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <h1 class="mb-4">Order Confirmation</h1>

    <div class="alert alert-success" role="alert">
        Your order has been placed successfully!
    </div>

    <h3>Order Details</h3>
    <ul class="list-unstyled">
        <li><strong>Order ID:</strong> <?= esc($order['id']) ?></li>
        <li><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></li>
        <li><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></li>
        <li><strong>Status:</strong> <?= esc(ucfirst($order['status'])) ?></li>
    </ul>

    <h3 class="mt-4">Order Items</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orderItems)): ?>
                <?php foreach ($orderItems as $row): ?>
                    <tr>
                        <td><?= esc($row['product_name']) ?></td>
                        <td><?= esc($row['qty']) ?></td>
                        <td>$<?= number_format($row['unit_price'], 2) ?></td>
                        <td>$<?= number_format($row['unit_price'] * $row['qty'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No items found for this order.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Optional: Link to go back to shop or order history -->
    <div class="mt-4">
        <a href="<?= route_to('home.index') ?>" class="btn btn-primary">Continue Shopping</a>
        
        
    </div>
</div>
<?= $this->endSection() ?>