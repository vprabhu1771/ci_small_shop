<?= $this->extend('frontend/layout/app') ?>

<?= $this->section('title') ?>
    Your Cart
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <h1 class="mb-4">Your Cart</h1>

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

    <?php if (empty($carts)): ?>
        <div class="alert alert-info" role="alert">
            Your cart is empty.
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carts as $cart): ?>
                    <tr>
                        <td><?= esc($cart['product_name']) ?></td>
                        <td>$<?= number_format($cart['price'], 2) ?></td>
                        <td>
                            <form action="<?= route_to('cart.decrease', $cart['id']) ?>" method="POST" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm">-</button>
                            </form>

                            <?= $cart['qty'] ?>

                            <form action="<?= route_to('cart.increase', $cart['id']) ?>" method="POST" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-success btn-sm">+</button>
                            </form>
                        </td>
                        <td>$<?= number_format($cart['price'] * $cart['qty'], 2) ?></td>
                        <td>
                            <form action="<?= route_to('cart.remove', $cart['id']) ?>" method="POST" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE"> <!-- Simulating DELETE method -->
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Cart Summary -->
        <div class="d-flex justify-content-between mt-4">
            <h4>Total Amount:</h4>
            <h4>$<?= number_format(array_reduce($carts, function ($carry, $cart) {
                return $carry + ($cart['price'] * $cart['qty']);
            }, 0), 2) ?></h4>
        </div>

        <!-- Clear Cart Button -->
        <form action="<?= route_to('cart.clear') ?>" method="POST" class="mt-4">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Clear Cart</button>
        </form>

        <!-- Checkout Button -->
        <div class="mt-4">
            <form action="<?= route_to('checkout') ?>" method="POST" class="mt-4">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
            </form>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
