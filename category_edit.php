<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3"><?= esc($page_title) ?></h3>

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

<?= form_open("/categories/update/{$category['id']}") ?>
<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="<?= old('name', $category['name']) ?>" class="form-control" required>
</div>
<button type="submit" class="btn btn-primary">Update</button>
<a href="<?= base_url('categories') ?>" class="btn btn-secondary ms-2">Cancel</a>
<?= form_close() ?>

<?= $this->endSection() ?>
