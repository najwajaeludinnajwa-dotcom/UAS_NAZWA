<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
        <span>Menu</span>
    </h6>
    <ul class="nav flex-column">
        
        <?php $role = $this->session->userdata('role'); ?>
        <?php $current_uri = $this->uri->segment(1); ?>

        <li class="nav-item">
            <a class="nav-link <?= ($current_uri == 'dashboard' || $current_uri == '') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-home fa-fw me-2"></i> Dashboard
            </a>
        </li>

        <?php if($role == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($current_uri == 'products') ? 'active' : '' ?>" href="<?= base_url('products') ?>">
                <i class="fas fa-box fa-fw me-2"></i> Beauty Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_uri == 'members') ? 'active' : '' ?>" href="<?= base_url('members') ?>">
                <i class="fas fa-users fa-fw me-2"></i> Members
            </a>
        </li>
        <?php endif; ?>

        <?php if($role == 'admin' || $role == 'sales'): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($current_uri == 'orders') ? 'active' : '' ?>" href="<?= base_url('orders') ?>">
                <i class="fas fa-shopping-cart fa-fw me-2"></i> Sales Orders
            </a>
        </li>
        <?php endif; ?>

        <?php if($role == 'admin' || $role == 'manager'): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($current_uri == 'reports') ? 'active' : '' ?>" href="<?= base_url('reports') ?>">
                <i class="fas fa-chart-bar fa-fw me-2"></i> Reports
            </a>
        </li>
        <?php endif; ?>

        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
            <span>Account</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
            </a>
        </li>
    </ul>
</nav>
