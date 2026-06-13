<div class="row mb-4">
    <div class="col-12">
        <h3 class="text-primary-dark fw-bold">Dashboard</h3>
        <p class="text-muted">Welcome to Glow Beauty Sales Order System.</p>
    </div>
</div>

<div class="row">
    <!-- Total Products -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card widget-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary-dark text-uppercase mb-1">
                            Total Products</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_products) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box widget-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Members -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card widget-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary-dark text-uppercase mb-1">
                            Total Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_members) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users widget-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card widget-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary-dark text-uppercase mb-1">
                            Total Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_orders) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart widget-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card widget-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary-dark text-uppercase mb-1">
                            Total Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign widget-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Transactions -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary-dark">Latest Transactions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Member</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($latest_transactions)): ?>
                                <?php foreach($latest_transactions as $row): ?>
                                    <tr>
                                        <td><?= $row->invoice_number ?></td>
                                        <td><?= date('d M Y', strtotime($row->order_date)) ?></td>
                                        <td><?= $row->member_name ?></td>
                                        <td>Rp <?= number_format($row->grand_total, 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge badge-<?= strtolower($row->order_status) ?> py-2 px-3 rounded-pill">
                                                <?= $row->order_status ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No transactions found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
