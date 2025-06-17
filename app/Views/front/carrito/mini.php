<?php if (empty($cart)): ?> <!-- Verificación si el carrito está vacío -->
    <!-- Mensaje y botón para carrito vacío -->
    <div class="empty-cart-message">
        <i class="bi bi-cart-x fs-1 d-block mb-3 text-muted"></i> <!-- Icono de carrito vacío -->
        <p>Tu carrito está vacío</p>
        <a href="<?= base_url('productos') ?>" class="btn btn-sm btn-info mt-2">Ver productos</a> <!-- Enlace para ver productos -->
    </div>
<?php else: ?> <!-- Si el carrito tiene productos -->
    <div class="cart-items">
        <?php foreach ($cart as $item): ?> <!-- Iteración sobre cada producto en el carrito -->
            <!-- Contenedor de cada ítem del carrito -->
            <div class="cart-item">
                <!-- Imagen del producto con escape para el atributo alt por seguridad -->
                <img src="<?= base_url('public/' . $item['imagen']) ?>" class="cart-item-image" alt="<?= esc($item['name']) ?>">
                <div class="cart-item-details">
                    <!-- Nombre del producto con escape para prevenir XSS -->
                    <div class="cart-item-name"><?= esc($item['name']) ?></div>
                    <!-- Precio formateado con separadores de miles y decimales -->
                    <div class="cart-item-price">$ <?= number_format($item['price'], 2, ',', '.') ?></div>
                    <!-- Controles de cantidad con botones para aumentar, disminuir y eliminar -->
                    <div class="cart-item-quantity">
                        <div class="d-flex align-items-center">
                            <!-- Botón para disminuir cantidad con atributo data para identificar el ítem -->
                            <button class="btn btn-sm btn-outline-info me-2 btn-cart-resta" data-rowid="<?= $item['rowid'] ?>"><i class="fas fa-minus"></i></button>
                            <!-- Cantidad actual del producto -->
                            <span class="mx-2"><?= $item['qty'] ?></span>
                            <!-- Botón para aumentar cantidad -->
                            <button class="btn btn-sm btn-info ms-2 btn-cart-suma" data-rowid="<?= $item['rowid'] ?>"><i class="fas fa-plus"></i></button>
                            <!-- Botón para eliminar el producto del carrito -->
                            <button class="btn btn-sm btn-danger ms-3 btn-cart-remove" data-rowid="<?= $item['rowid'] ?>" title="Eliminar"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <!-- Sección para mostrar el total del carrito -->
        <div class="cart-total">
            <span class="cart-total-label">Total: <span class="cart-total-amount">$ <?= number_format($total, 2, ',', '.') ?></span></span>
            <span></span> <!-- Elemento vacío para mantener el justify-content-between en el diseño -->
        </div>
        
        <!-- Los botones se han movido al footer del modal -->
    </div>
<?php endif; ?>