<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary-dark fw-bold mb-0">Sales Orders</h3>
            <p class="text-muted mb-0">Manage customer orders and transactions</p>
        </div>
        <?php if($this->session->userdata('role') !== 'manager'): ?>
        <a href="<?= base_url('orders/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Order
        </a>
        <?php endif; ?>
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
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Member</th>
                                <?php if($this->session->userdata('role') !== 'sales'): ?>
                                <th>Sales Person</th>
                                <?php endif; ?>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $o): ?>
                                <tr>
                                    <td class="fw-bold text-primary-dark"><?= $o->invoice_number ?></td>
                                    <td><?= date('d M Y', strtotime($o->order_date)) ?></td>
                                    <td><?= $o->member_name ?></td>
                                    <?php if($this->session->userdata('role') !== 'sales'): ?>
                                    <td><?= $o->sales_name ?></td>
                                    <?php endif; ?>
                                    <td>Rp <?= number_format($o->grand_total, 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($o->order_status) ?> py-2 px-3 rounded-pill">
                                            <?= $o->order_status ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('orders/detail/'.$o->order_id) ?>" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
