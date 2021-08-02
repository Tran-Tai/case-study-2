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
    <?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div class="text-center">
        <h1 class="text-center">Trang đăng ký tài khoản</h1>
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
        <form class="form-group needs-validation" method="POST">
            <legend class="text-center">
                Nhập thông tin
            </legend>
            <div class="form-group">
                <label for="user_name">Tên người dùng:</label>
                <input type="text" name="user_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="display_name">Tên hiển thị:</label>
                <input type="text" name="display_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="account">Tài khoản:</label>
                <input type="text" name="account" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" class="form-control" required></br>
            </div>
            <div class="form-group">
                <label for="confirm">Xác nhận lại mật khẩu:</label>
                <input type="password" name="confirm" class="form-control" required></br>
            </div>
            <input type="number" name="status" class="form-control" hidden value=2>
            <div class="text-center col-12">
                <button type="submit" class="btn btn-success">Đăng ký</button>
                <a class="btn btn-primary" type="button" href="?controller=users&action=login">Đăng nhập</a>
            </div>
        </form>
    </div>
</body>

</html>