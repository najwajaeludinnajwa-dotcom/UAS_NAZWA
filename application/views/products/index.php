<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary-dark fw-bold mb-0">Beauty Products</h3>
            <p class="text-muted mb-0">Manage your product catalog</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-2"></i>Add Product
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable w-100">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $p): ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark border"><?= $p->product_code ?></span></td>
                                    <td class="fw-medium"><?= $p->product_name ?></td>
                                    <td><?= $p->category ?></td>
                                    <td>Rp <?= number_format($p->price, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if($p->stock <= 5): ?>
                                            <span class="badge bg-danger"><?= $p->stock ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success"><?= $p->stock ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $p->product_id ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('products/delete/'.$p->product_id) ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editProductModal<?= $p->product_id ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title text-primary-dark fw-bold">Edit Product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('products/update') ?>" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="product_id" value="<?= $p->product_id ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Code</label>
                                                        <input type="text" class="form-control" name="product_code" value="<?= $p->product_code ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" class="form-control" name="product_name" value="<?= $p->product_name ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Category</label>
                                                        <select class="form-select" name="category" required>
                                                            <option <?= $p->category == 'Hair Tools' ? 'selected' : '' ?>>Hair Tools</option>
                                                            <option <?= $p->category == 'Face Care' ? 'selected' : '' ?>>Face Care</option>
                                                            <option <?= $p->category == 'Nail Care' ? 'selected' : '' ?>>Nail Care</option>
                                                            <option <?= $p->category == 'Skin Care' ? 'selected' : '' ?>>Skin Care</option>
                                                        </select>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Price (Rp)</label>
                                                            <input type="number" class="form-control" name="price" value="<?= $p->price ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Stock</label>
                                                            <input type="number" class="form-control" name="stock" value="<?= $p->stock ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title text-primary-dark fw-bold">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('products/store') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" class="form-control" name="product_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="">Select Category...</option>
                            <option>Hair Tools</option>
                            <option>Face Care</option>
                            <option>Nail Care</option>
                            <option>Skin Care</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Price (Rp)</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
