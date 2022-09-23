<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->title  ?> - <?= APP_NAME ?></title>
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app.css?v=202209151147') ?>"> -->
  <style>
    * {
      font-size: 12px;
      font-family: 'Times New Roman';
    }
    html, body {margin:0;padding:0;}
    body{width:50mm;margin:0;padding:0;}
  </style>
</head>

<body>
  <div class="wrapper">
    <?= $this->renderSection('content') ?>
  </div>
</body>

</html>