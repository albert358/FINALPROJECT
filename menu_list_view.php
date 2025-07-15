<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('head') ?>
<style>
    .menu-item-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .menu-item-card img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3"><?= esc($page_title) ?></h3>
        <h6 class="op-7 mb-2">Manage your restaurant's menu items here.</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="<?= base_url('menu/new') ?>" class="btn btn-primary btn-round">
            <i class="fa fa-plus me-2"></i> Add New Menu Item
        </a>
    </div>
</div>

<?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Filter Menu Items</div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('menu') ?>" method="get" class="row g-3 align-items-end mb-4">
            <div class="col-md-4">
                <label for="filterName" class="form-label">Menu Item Name</label>
                <input type="text" class="form-control" id="filterName" name="name" value="<?= esc($filterName ?? '') ?>" placeholder="Search by name...">
            </div>
            <div class="col-md-3">
                <label for="filterStatus" class="form-label">Status</label>
                <select class="form-select" id="filterStatus" name="status">
                    <option value="">All Statuses</option>
                    <option value="available" <?= ($filterStatus ?? '') === 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="unavailable" <?= ($filterStatus ?? '') === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filterCategory" class="form-label">Category</label>
                <select class="form-select" id="filterCategory" name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($allCategories as $category): ?>
                        <option value="<?= esc($category['id']) ?>"
                            <?= ($filterCategory ?? '') == $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fa fa-filter me-1"></i> Filter
                </button>
                <a href="<?= base_url('menu') ?>" class="btn btn-secondary">
                    <i class="fa fa-times me-1"></i> Clear
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($menuItems)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No menu items found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($menuItems as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= base_url('uploads/menu_images/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-thumbnail">
                                <?php else: ?>
                                    <img src="<?= base_url('assets/img/default-food-item.png') ?>" alt="No Image" class="img-thumbnail">
                                <?php endif; ?>
                            </td>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= esc($categoryMap[$item['category_id']] ?? 'N/A') ?></td>
                            <td><?= esc($item['description'] ?? 'N/A') ?></td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                            <td>
                                    <span class="badge <?= $item['status'] === 'available' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= esc(ucfirst($item['status'])) ?>
                                    </span>
                            </td>
                            <td>
                                <a href="<?= base_url('menu/edit/' . $item['id']) ?>" class="btn btn-info btn-sm me-1" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="<?= base_url('menu/delete/' . $item['id']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this item?')">
                                    <i class="fa fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
            paging: true,
            lengthChange: true,
            searching: false, // Disable client search since we have filters
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true
        });
    });
</script>
<?= $this->endSection() ?>
