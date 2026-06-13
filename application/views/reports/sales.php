<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary-dark fw-bold mb-0">Sales Performance</h3>
            <p class="text-muted mb-0">View total transactions and revenue per sales person</p>
        </div>
        <div>
            <a href="<?= base_url('reports') ?>" class="btn btn-outline-secondary me-2">Back</a>
            <a href="<?= base_url('reports/sales?export=pdf') ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </a>
        </div>
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
                                <th>No</th>
                                <th>Sales Person</th>
                                <th class="text-center">Total Transactions</th>
                                <th class="text-end">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($report_data as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-medium"><?= $row->sales_name ?></td>
                                    <td class="text-center"><?= $row->total_transactions ?></td>
                                    <td class="text-end fw-bold text-primary-dark">Rp <?= number_format($row->total_revenue, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
