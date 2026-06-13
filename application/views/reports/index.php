<div class="row mb-4">
    <div class="col-12">
        <h3 class="text-primary-dark fw-bold mb-0">Reports</h3>
        <p class="text-muted mb-0">Select a report to view or export</p>
    </div>
</div>

<div class="row">
    <!-- Sales Performance -->
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 border-0 text-center text-decoration-none">
            <div class="card-body py-5">
                <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-primary-dark">Sales Performance</h5>
                <p class="text-muted small">View total transactions and revenue per sales person.</p>
                <a href="<?= base_url('reports/sales') ?>" class="btn btn-outline-primary mt-3">View Report</a>
            </div>
        </div>
    </div>

    <!-- Product Sales -->
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 border-0 text-center">
            <div class="card-body py-5">
                <i class="fas fa-box-open fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-primary-dark">Product Sales</h5>
                <p class="text-muted small">View total items sold and revenue per product.</p>
                <a href="<?= base_url('reports/products') ?>" class="btn btn-outline-primary mt-3">View Report</a>
            </div>
        </div>
    </div>

    <!-- Report by Period -->
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 border-0 text-center">
            <div class="card-body py-5">
                <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold text-primary-dark">Report By Period</h5>
                <p class="text-muted small">View transactions within a specific date range.</p>
                <a href="<?= base_url('reports/period') ?>" class="btn btn-outline-primary mt-3">View Report</a>
            </div>
        </div>
    </div>
</div>
