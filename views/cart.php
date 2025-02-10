<?php
$page_title = "Cart";
require_once 'header.php';
?>

<div class='container cart'>
    <div class='row'>
        <div class='col-12'>
            <h1 class="display-5 mb-4">Shopping Cart</h1>
            <form action='<?= $self_url; ?>' method='POST'>
                <table class='table'>
                    <thead>
                    <tr>
                        <th scope='col' colspan='2'>Book</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Quantity</th>
                        <th scope='col'>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cart_books)): ?>
                      <?php foreach ($cart_books as $book): ?>
                            <tr>
                                <th scope='row' colspan='2'>
                                    <a href='/book/<?= create_url_string($book['Boo_Title']); ?>'
                                       title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a>
                                    <a href="<?= $self_url; ?>?remove=<?= $book['Boo_ISBN'] ?>" type='button' class='btn btn-sm btn-close'
                                       aria-label='Remove'></a>

                                </th>
                                <td>&euro;<?= $book['Boo_Price']; ?></td>
                                <td class="quantity">
                                    <label>
                                        <input type="number" class='form-control form-control-sm' name="quantity-<?= $book['Boo_ISBN'] ?>"
                                               value="<?= $products_in_cart[$book['Boo_ISBN']] ?>" min="1"
                                               max="<?= $book['Boo_QOH'] ?? 0 ?>" placeholder="Quantity" required>
                                    </label>
                                </td>
                                <td class="price">&euro;<?= $book['Boo_Price'] * $products_in_cart[$book['Boo_ISBN']] ?></td>
                            </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan='5' class="text-center">You don't have books added in your Shopping Cart!</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <h4 class="pb-3">Subtotal: &euro;<?= $subtotal ?></h4>
                    <input type="submit" class='btn btn-outline-secondary' value="Update Cart" name="update">
                    <a href="../checkout" class="btn btn-success mb-3" title="">Go to Checkout</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>