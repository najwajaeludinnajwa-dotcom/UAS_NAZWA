<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary-dark fw-bold mb-0">Order Detail</h3>
            <p class="text-muted mb-0">Invoice: <?= $order->invoice_number ?></p>
        </div>
        <a href="<?= base_url('orders') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <!-- Order Info Card -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-white pb-0 border-bottom-0 pt-4">
                <h6 class="text-primary-dark fw-bold m-0"><i class="fas fa-info-circle me-2"></i>Order Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted" width="40%">Status</td>
                        <td>
                            <span class="badge badge-<?= strtolower($order->order_status) ?> px-3 py-2 rounded-pill">
                                <?= $order->order_status ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Date</td>
                        <td class="fw-medium"><?= date('d F Y', strtotime($order->order_date)) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Sales Person</td>
                        <td class="fw-medium"><?= $order->sales_name ?></td>
                    </tr>
                </table>

                <?php if($this->session->userdata('role') !== 'manager'): ?>
                    <?php if($order->order_status !== 'Completed' && $order->order_status !== 'Cancelled'): ?>
                        <hr>
                        <form action="<?= base_url('orders/update_status') ?>" method="post">
                            <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Update Status</label>
                                <select name="order_status" class="form-select mb-2" required>
                                    <option <?= $order->order_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option <?= $order->order_status == 'Processed' ? 'selected' : '' ?>>Processed</option>
                                    <option <?= $order->order_status == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option <?= $order->order_status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    <option <?= $order->order_status == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Update Status</button>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Customer Info Card -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-white pb-0 border-bottom-0 pt-4">
                <h6 class="text-primary-dark fw-bold m-0"><i class="fas fa-user me-2"></i>Customer Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Name</label>
                        <p class="mb-0 fw-medium fs-5 text-dark"><?= $order->member_name ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Phone Number</label>
                        <p class="mb-0 fw-medium text-dark"><?= $order->phone_number ?></p>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small fw-bold text-uppercase">Address</label>
                        <p class="mb-0 text-dark"><?= nl2br($order->address) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="text-primary-dark fw-bold m-0"><i class="fas fa-box me-2"></i>Order Items</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>Product Name</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $i): ?>
                                <tr>
                                    <td class="ps-4"><span class="badge bg-light text-dark border"><?= $i->product_code ?></span></td>
                                    <td class="fw-medium"><?= $i->product_name ?></td>
                                    <td class="text-end">Rp <?= number_format($i->unit_price, 0, ',', '.') ?></td>
                                    <td class="text-center"><?= $i->quantity ?></td>
                                    <td class="text-end fw-bold text-primary-dark pe-4">Rp <?= number_format($i->subtotal, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="4" class="text-end fw-bold text-uppercase py-3">Grand Total</td>
                                <td class="text-end fw-bold fs-5 text-primary-dark pe-4 py-3">
                                    Rp <?= number_format($order->grand_total, 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
