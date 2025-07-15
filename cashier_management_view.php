<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('head') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

    <h2 class="text-2xl font-bold mb-4 mt-4">Pending Cashier Accounts</h2>

<?php if (empty($pendingCashiers)): ?>
    <p class="text-muted">No pending cashier accounts.</p>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingCashiers as $cashier): ?>
                        <tr>
                            <td><?= esc($cashier['username']) ?></td>
                            <td>
                                <span class="badge bg-warning text-dark"><?= esc(ucfirst($cashier['status'])) ?></span>
                            </td>
                            <td><?= esc($cashier['created_at']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/approve-cashier/' . $cashier['id']) ?>"
                                   class="btn btn-success btn-sm me-1">
                                    Approve
                                </a>
                                <a href="<?= base_url('admin/reject-cashier/' . $cashier['id']) ?>"
                                   class="btn btn-danger btn-sm">
                                    Reject
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

    <h2 class="text-2xl font-bold mb-4 mt-4">Approved Cashier Accounts</h2>
<?php if (empty($approvedCashiers)): ?>
    <p class="text-muted">No approved cashier accounts.</p>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Approved On</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($approvedCashiers as $cashier): ?>
                        <tr>
                            <td><?= esc($cashier['username']) ?></td>
                            <td>
                                <span class="badge bg-success"><?= esc(ucfirst($cashier['status'])) ?></span>
                            </td>
                            <td><?= esc($cashier['updated_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>