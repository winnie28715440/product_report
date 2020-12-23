<?php
if (!isset($pageName)) $pageName = '';
?>

<style>
  .container {
    position: relative;
  }

  body {
    background-image: url("imgs/test.png");
    background-repeat: no-repeat;
    background-position: -60% 50%;
    background-attachment: fixed;
  }

  .navbar .nav-item.active {
    background-color: #cef1eca1;
    border-radius: 5px;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= WEB_ROOT ?>index_.php">うつわ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?= $pageName == 'ab-list' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= WEB_ROOT ?>ab-list.php">商品列表 <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?= $pageName == 'ab-insert' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= WEB_ROOT ?>ab-insert.php">商品列表追加 <span class="sr-only">(current)</span></a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <?php if (isset($_SESSION['admin'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= WEB_ROOT ?>ab-list.php"><?= $_SESSION['admin']['account'] ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= WEB_ROOT ?>logout.php">登出</a>
          </li>
        <?php else : ?>
          <li class="nav-item <?= $pageName == 'login' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= WEB_ROOT ?>login.php">登入</a>
          </li>
        <?php endif ?>
      </ul>

    </div>

  </div>

</nav>