<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quarantine user Form</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap-grid.css" />
    <style>
        form {
            width: 50%;
            padding: 10px;
            margin: 20px;
            border: 2px solid black;
            background-color: lightblue;
            border-radius: 5px;
        }

        fieldset {
            padding: 20px;
            background-color: lightcyan;
        }

        legend {
            border: 1px solid black;
            border-radius: 2px;
            background-color: white;
            padding: 3px 10px;
            font-size: 20px;
        }

        button {
            margin: 20px;
            border: 1px solid black;
            border-radius: 3px;
            background-color: lightgrey;
            text-align: center;
            padding: 5px;
            font-size: 20px;
        }

        label {
            text-align: left;
            font-weight: bold;
        }

        input,
        p {
            padding: 2px;
            margin: 3px;
        }

        input[type="text"] {
            width: 90%;
        }
    </style>
</head>

<body>
<?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div>
        <h1 class="text-center">Trang đổi mật khẩu</h1>
    </div>
    <?php
        if (isset($_SESSION["failmessage"])) {
            echo '<div class="alert alert-danger" role="alert">
                    ' . $_SESSION["failmessage"] . '
              </div>';
            $_SESSION["failmessage"] = NULL;
        }
        ?>
    <div>
        <form class="mx-auto" method="POST">
            <fieldset>
                <legend>
                    Yêu cầu nhập mật khẩu cũ và mới:
                </legend>
                <label for="password">Mật khẩu cũ</label></br>
                <input type="password" name="oldPassword"></br>
                <label for="password">Mật khẩu mới</label></br>
                <input type="password" name="password"></br>
                <label for="confirm">Xác nhận lại mật khẩu</label></br>
                <input type="password" name="confirm"></br>
                <input type="submit" value="Chỉnh sửa">
            </fieldset>
        </form>
    </div>
</body>

</html>