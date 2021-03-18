<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient Form</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap-grid.css" />
</head>

<body>
    <?php 
        include_once("/Codegym/Module2/case_study/views/header.php"); 
        if (isset($_SESSION["login"])) {
            if (isset($_SESSION["admin"])) header("location:?controller=users&action=list");
            else {
                $id = $_SESSION["id"];
                header("location:?controller=users&action=detail&id=$id");
            }
        }
    ?>
    <div class="text-center">
        <h1 class="text-center">Trang đăng nhập</h1>
    </div>
    <div class="text-center container col-10">
        <?php
        if (isset($_SESSION["failmessage"])) {
            echo '<div class="alert alert-danger" role="alert">
                    ' . $_SESSION["failmessage"] . '
              </div>';
            $_SESSION["failmessage"] = NULL;
        }
        ?>
    </div>
    <div class="container col-4" style="background-color:lightblue; padding:20px; border: green 2px solid; border-radius:10px">
        <form class="form-group" method="POST">
            <legend class="text-center">
                Nhập thông tin
            </legend>
            <div class="form-group">
                <label for="account">Tài khoản:</label>
                <input type="text" name="account" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" class="form-control"></br>
            </div>
            <div class="text-center col-12">
                <button type="submit" class="btn btn-success">Đăng nhập</button>
                <a class="btn btn-primary" type="button" href="?controller=users&action=signup">Đăng ký</a>
            </div>
        </form>
    </div>
</body>

</html>