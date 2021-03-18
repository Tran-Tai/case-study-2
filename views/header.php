<?php
$action = $_GET["action"] ?? NULL;
if (!isset($_SESSION["login"]) || (!$_SESSION["login"])) {
  if ($action != "login") {
    if (!isset($_SESSION["failmessage"]))
    $_SESSION["failmessage"] = "Bạn không có quyền truy cập trang này, vui lòng đăng nhập";
    header("location:?controller=users&action=login");
  }
}
?>
<nav class="navbar navbar-dark bg-light">
  <ul class=" mx-auto nav nav-pills">

  <?php
  if (isset($_SESSION["admin"]) && ($_SESSION["admin"])) {
    echo "
    <li class='nav-item'>
      <a class='nav-link "; 
    insertActive("users"); 
    echo "' + href='?controller=users&action=list'> Users </a>
    </li>
    ";
  }
  elseif (isset($_SESSION["login"]) && ($_SESSION["login"])) {
    if (isset($_SESSION["id"])) {
      $id = $_SESSION["id"];
      echo "
        <li class='nav-item'>
        <a class='nav-link "; 
      insertActive("users"); 
      echo "' + href='?controller=users&action=detail&id=$id'> Account </a>
      </li>
    ";
    }
  }
  ?>

    <li class="nav-item">
      <a class="nav-link <?php insertActive("persons") ?>" + href="?controller=persons&action=list"> Persons </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php insertActive("hospitals") ?>" + href="?controller=hospitals&action=list"> Hopitals </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php insertActive("sites") ?>" + href="?controller=sites&action=list"> Sites </a>
    </li>

  </ul>
  <?php
      if (isset($_SESSION["login"]) && ($_SESSION["login"])) {
        echo "
        <div class='nav-item'>
        <a class='float-right nav-link' + href='?controller=users&action=logout'> Logout </a>
        </div>
        ";
      }
    ?>
</nav>