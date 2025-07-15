<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center pt-2 pb-4">
    <h3 class="fw-bold mb-0"><?= esc($page_title ?? 'Categories') ?></h3>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= esc($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= esc($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">Add New Category</div>
    <div class="card-body">
        <?= form_open('/categories/store') ?>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= old('name') ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <?= form_close() ?>
    </div>
</div>

<div class="card">
    <div class="card-header">Existing Categories</div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th style="width: 180px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $c): ?>
                    <tr>
                        <td><?= esc($c['name']) ?></td>
                        <td>
                            <a href="<?= base_url("categories/edit/{$c['id']}") ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url("categories/delete/{$c['id']}") ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">No categories yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
