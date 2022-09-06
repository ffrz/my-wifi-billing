<?php use App\Entities\Acl; ?>
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <a href="<?= base_url('/') ?>" class="brand-link">
    <img src="<?= base_url('dist/img/logo.png') ?>" alt="App Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= APP_NAME ?></span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-flat nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">    
        <li class="nav-item">
          <a href="<?= base_url() ?>" class="nav-link <?= nav_active($this, 'dashboard') ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        
        <?php if (current_user_can(Acl::VIEW_REPORTS)): ?>
        <li class="nav-item <?= menu_open($this, 'report') ?>">
          <a href="#" class="nav-link <?= menu_active($this, 'report') ?>">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Laporan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <?php /*
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('/reports/income-statement') ?>" class="nav-link <?= nav_active($this, 'income-statement-report') ?>">
                <i class="nav-icon fas fa-file-contract"></i>
                <p>Lap. Laba Rugi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('/reports/sales-by-category') ?>" class="nav-link <?= nav_active($this, 'sales-by-category') ?>">
                <i class="nav-icon fas fa-file-contract"></i>
                <p><small>Lap. Penjualan per Kategori</small></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('/reports/stock-assets') ?>" class="nav-link <?= nav_active($this, 'stock-report') ?>">
                <i class="nav-icon fas fa-file-contract"></i>
                <p>Lap. Stok</p>
              </a>
            </li>
          </ul>
          <?php */ ?>
        </li>
        <?php endif ?>
        <li class="nav-item">
          <a href="<?= base_url('/bills') ?>" class="nav-link <?= nav_active($this, 'bill') ?>">
            <i class="nav-icon fas fa-money-bills"></i>
            <p>Tagihan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('/customers') ?>" class="nav-link <?= nav_active($this, 'customer') ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Pelanggan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('/products') ?>" class="nav-link <?= nav_active($this, 'product') ?>">
            <i class="nav-icon fas fa-satellite-dish"></i>
            <p>Produk</p>
          </a>
        </li>
        <?php if (current_user_can(Acl::CHANGE_SYSTEM_SETTINGS)): ?>
        <li class="nav-item <?= menu_open($this, 'system') ?>">
          <a href="#" class="nav-link <?= menu_active($this, 'system') ?>">
            <i class="nav-icon fas fa-gears"></i>
            <p>
              Sistem
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if (current_user_can(Acl::VIEW_USERS)): ?>
            <li class="nav-item">
              <a href="<?= base_url('/users') ?>" class="nav-link <?= nav_active($this, 'users') ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Pengguna</p>
              </a>
            </li>
            <?php endif ?>
            <?php if (current_user_can(Acl::VIEW_USER_GROUPS)): ?>
            <li class="nav-item">
              <a href="<?= base_url('/user-groups') ?>" class="nav-link <?= nav_active($this, 'user-groups') ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Grup Pengguna</p>
              </a>
            </li>
            <?php endif ?>
            <?php if (current_user_can(Acl::CHANGE_SYSTEM_SETTINGS)): ?>
            <li class="nav-item">
              <a href="<?= base_url('/system/settings') ?>" class="nav-link <?= nav_active($this, 'system-settings') ?>">
                <i class="nav-icon fas fa-gear"></i>
                <p>Pengaturan</p>
              </a>
            </li>
            <?php endif ?>
          </ul>
        </li>
        <?php endif ?>
        <li class="nav-item"><hr></li>
        <li class="nav-item">
          <a href="<?= base_url('/users/profile/') ?>" class="nav-link <?= nav_active($this, 'profile') ?>">
            <i class="nav-icon fas fa-user"></i>
            <p><?= esc(current_user()->username) ?></p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('auth/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-right-from-bracket"></i>
              <p>Keluar</p>
            </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>