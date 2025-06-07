<?php if (empty($cart)): ?>
    <div class="empty-cart-message">
        <i class="bi bi-cart-x fs-1 d-block mb-3 text-muted"></i>
        <p>Tu carrito está vacío</p>
        <a href="<?= base_url('productos') ?>" class="btn btn-sm btn-info mt-2">Ver productos</a>
    </div>
<?php else: ?>
    <div class="cart-items">
        <?php foreach ($cart as $item): ?>
            <div class="cart-item">
                <img src="<?= base_url('public/' . $item['imagen']) ?>" class="cart-item-image" alt="<?= esc($item['name']) ?>">
                <div class="cart-item-details">
                    <div class="cart-item-name"><?= esc($item['name']) ?></div>
                    <div class="cart-item-price">$ <?= number_format($item['price'], 2) ?></div>
                    <div class="cart-item-quantity">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-info me-2 btn-cart-resta" data-rowid="<?= $item['rowid'] ?>"><i class="fas fa-minus"></i></button>
                            <span class="mx-2"><?= $item['qty'] ?></span>
                            <button class="btn btn-sm btn-info ms-2 btn-cart-suma" data-rowid="<?= $item['rowid'] ?>"><i class="fas fa-plus"></i></button>
                            <button class="btn btn-sm btn-danger ms-3 btn-cart-remove" data-rowid="<?= $item['rowid'] ?>" title="Eliminar"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="cart-total">
            <span class="cart-total-label">Total: <span class="cart-total-amount">$ <?= number_format($total, 2) ?></span></span>
            <span></span> <!-- Elemento vacío para mantener el justify-content-between -->
        </div>
        
        <div class="cart-actions mt-3 d-flex justify-content-between">
            <button class="btn btn-outline-danger btn-sm btn-cart-clear"><i class="fas fa-trash me-1"></i>Vaciar carrito</button>
            <button class="btn btn-info btn-sm btn-cart-checkout"><i class="fas fa-shopping-cart me-1"></i>Finalizar compra</button>
        </div>
    </div>
<?php endif; ?>