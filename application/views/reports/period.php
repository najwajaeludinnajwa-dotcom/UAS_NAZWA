<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary-dark fw-bold mb-0">Report By Period</h3>
            <p class="text-muted mb-0">View transactions within a specific date range</p>
        </div>
        <div>
            <a href="<?= base_url('reports') ?>" class="btn btn-outline-secondary me-2">Back</a>
            <a href="<?= base_url('reports/period?start_date='.$start_date.'&end_date='.$end_date.'&export=pdf') ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <form action="<?= base_url('reports/period') ?>" method="get" class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="<?= $start_date ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="<?= $end_date ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter</button>
                    </div>
                </form>
            </div>
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
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Member</th>
                                <th>Sales Person</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            foreach($report_data as $row): 
                                $grand_total += $row->grand_total;
                            ?>
                                <tr>
                                    <td class="fw-bold"><?= $row->invoice_number ?></td>
                                    <td><?= date('d M Y', strtotime($row->order_date)) ?></td>
                                    <td><?= $row->member_name ?></td>
                                    <td><?= $row->sales_name ?></td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($row->order_status) ?> py-2 px-3 rounded-pill">
                                            <?= $row->order_status ?>
                                        </span>
                                    </td>
                                    <td class="text-end">Rp <?= number_format($row->grand_total, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold text-uppercase">Total Revenue</td>
                                <td class="text-end fw-bold fs-5 text-primary-dark">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
