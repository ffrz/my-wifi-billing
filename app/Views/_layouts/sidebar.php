<?php

use App\Entities\Acl; ?>
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
        <?php if (current_user_can(Acl::VIEW_REPORTS)) : ?>
          <li class="nav-item <?= menu_open($this, 'report') ?>">
            <a href="#" class="nav-link <?= menu_active($this, 'report') ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('/reports/unpaid-bills') ?>" class="nav-link <?= nav_active($this, 'report/unpaid-bills') ?>">
                  <i class="nav-icon fas fa-file-contract"></i>
                  <p><small>Lap. Penagihan</small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/reports/paid-bills') ?>" class="nav-link <?= nav_active($this, 'report/paid-bills') ?>">
                  <i class="nav-icon fas fa-file-contract"></i>
                  <p><small>Lap. Pembayaran Tagihan</small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/reports/cost') ?>" class="nav-link <?= nav_active($this, 'report/cost') ?>">
                  <i class="nav-icon fas fa-file-contract"></i>
                  <p><small>Lap. Biaya Operasional</small></p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif ?>
        <?php if (current_user_can(Acl::VIEW_BILLS) || current_user_can(Acl::GENERATE_BILLS)) : ?>
          <li class="nav-item <?= menu_open($this, 'bill') ?>">
            <a href="#" class="nav-link <?= menu_active($this, 'bill') ?>">
              <i class="nav-icon fas fa-money-bills"></i>
              <p>
                Tagihan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if (current_user_can(Acl::VIEW_BILLS)) : ?>
                <li class="nav-item">
                  <a href="<?= base_url('/bills') ?>" class="nav-link <?= nav_active($this, 'bill') ?>">
                    <i class="nav-icon fas fa-money-bills"></i>
                    <p>Tagihan</p>
                  </a>
                </li>
              <?php endif ?>
              <?php if (current_user_can(Acl::GENERATE_BILLS)) : ?>
              <li class="nav-item">
                <a href="<?= base_url('/bills/generate') ?>" class="nav-link <?= nav_active($this, 'generate-bill') ?>">
                  <i class="nav-icon fas fa-bolt"></i>
                  <p>Generate</p>
                </a>
              </li>
              <?php endif ?>
            </ul>
          </li>
        <?php endif ?>
        <?php if (is_app_admin()) : ?>
        <li class="nav-item">
          <a href="<?= base_url('/companies') ?>" class="nav-link <?= nav_active($this, 'company') ?>">
            <i class="nav-icon fas fa-building"></i>
            <p>Perusahaan</p>
          </a>
        </li>
        <?php endif ?>
        <?php if (current_user_can(Acl::VIEW_CUSTOMERS)) : ?>
        <li class="nav-item">
          <a href="<?= base_url('/customers') ?>" class="nav-link <?= nav_active($this, 'customer') ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Pelanggan</p>
          </a>
        </li>
        <?php endif ?>
        <?php if (current_user_can(Acl::VIEW_PRODUCTS)) : ?>
        <li class="nav-item">
          <a href="<?= base_url('/products') ?>" class="nav-link <?= nav_active($this, 'product') ?>">
            <i class="nav-icon fas fa-satellite-dish"></i>
            <p>Produk</p>
          </a>
        </li>
        <?php endif ?>
        <?php if (current_user_can(Acl::VIEW_COSTS) || current_user_can(Acl::VIEW_COST_CATEGORIES)) : ?>
          <li class="nav-item <?= menu_open($this, 'cost') ?>">
            <a href="#" class="nav-link <?= menu_active($this, 'cost') ?>">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Biaya Operasional
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if (current_user_can(Acl::VIEW_COSTS)) : ?>
                <li class="nav-item">
                  <a href="<?= base_url('/costs') ?>" class="nav-link <?= nav_active($this, 'cost') ?>">
                    <i class="nav-icon fas fa-receipt"></i>
                    <p>Biaya Operasional</p>
                  </a>
                </li>
              <?php endif ?>
              <?php if (current_user_can(Acl::VIEW_COST_CATEGORIES)) : ?>
                <li class="nav-item">
                  <a href="<?= base_url('/cost-categories') ?>" class="nav-link <?= nav_active($this, 'cost-category') ?>">
                    <i class="nav-icon fas fa-folder-tree"></i>
                    <p>Kategori Biaya</p>
                  </a>
                </li>
              <?php endif ?>
            </ul>
          </li>
        <?php endif ?>
        <?php if (current_user_can(Acl::CHANGE_SYSTEM_SETTINGS)) : ?>
          <li class="nav-item <?= menu_open($this, 'system') ?>">
            <a href="#" class="nav-link <?= menu_active($this, 'system') ?>">
              <i class="nav-icon fas fa-gears"></i>
              <p>
                Sistem
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('/users') ?>" class="nav-link <?= nav_active($this, 'user') ?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/user-groups') ?>" class="nav-link <?= nav_active($this, 'user-group') ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Grup Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/system/settings') ?>" class="nav-link <?= nav_active($this, 'system-setting') ?>">
                  <i class="nav-icon fas fa-gear"></i>
                  <p>Pengaturan</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif ?>
        <li class="nav-item nav-separator">
          <hr>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('/users/profile/') ?>" class="nav-link <?= nav_active($this, 'profile') ?>">
            <i class="nav-icon fas fa-user"></i>
            <p><?= esc(current_user()->username) ?></p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-right-from-bracket"></i>
            <p>Keluar</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>