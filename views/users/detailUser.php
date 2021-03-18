<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
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

        .info {
            width: 40%;
            border: 2px solid black;
            border-radius: 5px;
            background-color: lightblue;
            padding: 10px;
            margin: 20px 20px 20px 260px;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            border: 2px solid black;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid grey;
        }
    </style>
</head>

<body>
<?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div>
        <h1>Trang thông tin người dùng</h1>
    </div>
    <?php
        if (isset($_SESSION["message"])) {
            echo '<div class="alert alert-success" role="alert">
                    ' . $_SESSION["message"] . '
              </div>';
            $_SESSION["message"] = NULL;
        }
        ?>
    <div>
        <div class='info'>
        <?php 
            switch ($user->status) {
                    case 0:
                        $status = "Administrator";;
                        break;
                    case 1:
                        $status = "Active";
                        break;
            }
        ?>
            <fieldset>
                <legend>Thông tin người dùng</legend>
                <label>Tên người dùng: </label>
                <p><?php echo $user->user_name ?></p></br>
                <label>Tên hiển thị: </label>
                <p><?php echo $user->display_name ?></p></br>
                <label>Tài khoản: </label>
                <p><?php echo $user->account ?></p></br>
                <label>Trạng thái: </label>
                <p><?php echo $status ?></p></br>

                <?php echo "<a href='?controller=users&action=edit&id=$user->id'>
                            <button>Đổi mật khẩu</button>
                        </a>";
                ?>
            </fieldset>
        </div>
    </div>
</body>

</html>