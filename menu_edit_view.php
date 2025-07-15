<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3"><?= esc($page_title) ?></h3>
        <h6 class="op-7 mb-2">Update details of this menu item.</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="<?= base_url('menu') ?>" class="btn btn-secondary btn-round">
            <i class="fa fa-list me-2"></i> Back to Menu List
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Edit Menu Item Details</div>
    </div>
    <div class="card-body">
        <?= form_open_multipart(base_url('menu/update/' . $menuItem['id'])) ?>
        <div class="mb-3">
            <label for="name" class="form-label">Menu Item Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $menuItem['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Select a Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['id']) ?>"
                        <?= old('category_id', $menuItem['category_id']) == $category['id'] ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price', $menuItem['price']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $menuItem['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" id="status" name="status" required>
                <option value="available" <?= old('status', $menuItem['status']) == 'available' ? 'selected' : '' ?>>Available</option>
                <option value="unavailable" <?= old('status', $menuItem['status']) == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <?php if (!empty($menuItem['image'])): ?>
                <img src="<?= base_url('uploads/menu_images/' . $menuItem['image']) ?>" alt="<?= esc($menuItem['name']) ?>" class="img-thumbnail" style="max-width: 150px;">
            <?php else: ?>
                <span class="text-muted">No image uploaded.</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="item_image" class="form-label">Change Image</label>
            <input class="form-control" type="file" id="item_image" name="item_image" accept="image/*">
            <small class="form-text text-muted">Leave blank to keep current image. Max size: 1MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Menu Item</button>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
