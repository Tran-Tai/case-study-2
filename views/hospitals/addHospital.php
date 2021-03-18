<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital Form</title>
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
        <h1 class="text-center">Trang nhập thông tin bệnh viện</h1>
    </div>
    <div>
        <form  class="mx-auto" method="POST">
            <fieldset>
                <legend>
                    Nhập thông tin bệnh viện
                </legend>
                <label for="name">Tên bệnh viện</label></br>
                <input type="text" name="name"></br>
                <label for="address">Địa chỉ</label></br>
                <input type="text" name="address"></br>
                <label for="capacity">Số giường:</label></br>
                <input type="number" name="capacity" value=""></br>
                <label for="phone_number">Số điện thoại:</label></br>
                <input type="number" name="phone_number"></br>
                <input type="submit" value="Nhập">
            </fieldset>
        </form>
    </div>
</body>

</html>