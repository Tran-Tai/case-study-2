<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Detail Form</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
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
        <h1>Trang thông tin bệnh viện</h1>
    </div>
    <div>
        <div class='info'>
            <fieldset>
                <legend>Thông tin bệnh viện</legend>
                <label>Tên bệnh viện: </label>
                <p><?php echo $hospital->name ?></p></br>
                <label>Địa chỉ: </label>
                <p><?php echo $hospital->address ?></p></br>
                <label>Số điện thoại: </label>
                <p><?php echo $hospital->phone_number ?></p></br>
                <label>Số giường: </label>
                <p><?php echo $hospital->capacity ?></p></br>
                <label>Số giường trống: </label>
                <p><?php echo ($hospital->capacity - $hospital->used_bed) ?></p></br>

                <?php echo "<a href='?controller=hospitals&action=edit&id=$hospital->id'>
                            <button>Chỉnh sửa thông tin</button>
                        </a>";
                ?>
            </fieldset>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th colspan="10"> Danh sách bệnh nhân</th>
                </tr>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Số CMND</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tình trạng</th>
                    <th>Ngày khởi bệnh</th>
                    <th>Ngày nhập viện</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($personList as $key => $person) {
                    echo '
            <tr>
                <td>' . ($key + 1) . '</td>
                <td>' . $person->name . '</td>
                <td>' . $person->identity_number . '</td>
                <td>' . $person->birthday . '</td>
                <td>' . (($person->gender == 1) ? "Nam" : "Nữ") . '</td>
                <td>' . $person->phone . '</td>
                <td>' . $person->address . '</td>
                <td>' . $person->status . '</td>
                <td>' . $person->symtoms_appeared_day . '</td>
                <td>' . $person->hospitalized_day . '</td>
            </tr>
            ';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>