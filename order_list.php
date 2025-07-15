<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center pt-2 pb-4">
    <h3 class="fw-bold mb-0"><?= esc($page_title ?? 'Order List') ?></h3>
</div>

<div class="card">
    <div class="card-header">Recent Orders</div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total (₱)</th>
                <th>Status</th>
                <th>Date/Time</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order['order_number']) ?></td>
                        <td><?= esc($order['customer']) ?></td>
                        <td><?= esc($order['items']) ?></td>
                        <td>₱<?= number_format($order['total'], 2) ?></td>
                        <td>
                            <?php if ($order['status'] === 'Completed'): ?>
                                <span class="badge bg-success"><?= esc($order['status']) ?></span>
                            <?php elseif ($order['status'] === 'Pending'): ?>
                                <span class="badge bg-warning text-dark"><?= esc($order['status']) ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= esc($order['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($order['date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No orders found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
