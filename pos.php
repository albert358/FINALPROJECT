<?= $this->extend('layouts/cashier_layout') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h3 class="mb-4">POS (Point of Sale)</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('cashier/pos/process') ?>" method="post" class="card p-4">

        <div class="mb-3">
            <label for="product" class="form-label">Product</label>
            <select name="product" id="product" class="form-control" required onchange="updatePrice()">
                <option value="">-- Select --</option>
                <option value="Burger|Fastfood|99">Burger - Fastfood (₱99.00)</option>
                <option value="Pizza Slice|Fastfood|120">Pizza Slice - Fastfood (₱120.00)</option>
                <option value="Softdrink|Beverage|30">Softdrink - Beverage (₱30.00)</option>
                <option value="Fries|Snacks|45">Fries - Snacks (₱45.00)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Price (₱)</label>
            <input type="text" id="price" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required onchange="calculateTotal()">
        </div>

        <div class="mb-3">
            <label>Total (₱)</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Cash Amount (₱)</label>
            <input type="number" name="cash" id="cash" class="form-control" required onchange="calculateChange()">
        </div>

        <div class="mb-3">
            <label>Change (₱)</label>
            <input type="text" id="change" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<script>
    function updatePrice() {
        const productInfo = document.getElementById('product').value.split('|');
        const price = productInfo[2] || 0;
        document.getElementById('price').value = parseFloat(price).toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        const price = parseFloat(document.getElementById('price').value || 0);
        const quantity = parseInt(document.getElementById('quantity').value || 1);
        const total = price * quantity;
        document.getElementById('total').value = total.toFixed(2);
        calculateChange();
    }

    function calculateChange() {
        const total = parseFloat(document.getElementById('total').value || 0);
        const cash = parseFloat(document.getElementById('cash').value || 0);
        const change = cash - total;
        document.getElementById('change').value = change >= 0 ? change.toFixed(2) : '0.00';
    }
</script>
<?= $this->endSection() ?>
