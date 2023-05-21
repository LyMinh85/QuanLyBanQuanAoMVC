
<div class="d-flex flex-column">
    <?php if (isset($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col-auto">
            <p><?php echo $product->name ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>