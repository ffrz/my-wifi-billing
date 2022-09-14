
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk <?= APP_NAME ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center text-muted">
      <div>
         <span>Masuk <b><?= APP_NAME ?></b><sup><small> v<?= APP_VERSION_STR ?></sup></small></span>
      </div>
    </div>
    <div class="card-body">
      <?php if ($error): ?>
        <p class="login-box-msg text-danger"><?= $error ?></p>
      <?php else: ?>
        <p class="login-box-msg">Masuk untuk memulai sesi anda.</p>
      <?php endif ?>
      <form action="?" method="post">
        <?= csrf_field() ?>
        <div class="input-group mb-3">
          <input type="text" name="username" autofocus value="<?= esc($username) ?>" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" value="<?= esc($password) ?>" class="form-control" placeholder="Kata Sandi">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-right-to-bracket mr-2"></i> Masuk</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="mt-4 text-muted">&copy; Shift IT Solution 2022</div>
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
