<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital List</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap-grid.css" />
    <style>
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

        .input_info {
            margin: 20px 100px;
            padding: 5px;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <table>
        <thead>
            <tr>
                <th class="text-center" colspan="7">Danh sách bệnh viện</th>
            </tr>
            <tr>
                <th>STT</th>
                <th>Tên bệnh viện</th>
                <th>Địa Chỉ</th>
                <th>Số giường bệnh</th>
                <th>Số giường trống</th>
                <th>Số điện thoại</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($hospitalList as $key => $hospital) {
                $content = "<a href='?controller=hospitals&action=detail&id=$hospital->id'>
                            <button>Chi tiết</button>
                        </a>";
                echo "
            <tr>
                <td>" . ($key + 1) . "</td>
                <td>$hospital->name</td>
                <td>$hospital->address</td>
                <td>$hospital->capacity</td>
                <td>" . $hospital->capacity - $hospital->used_bed . "</td>
                <td>$hospital->phone_number</td>
                <td>$content</td>
            </tr>
            ";
            }
            ?>
        </tbody>
    </table>
    <div class="text-center">
        <a href='?controller=hospitals&action=add'>
            <button class="input_info">Thêm thông tin bệnh viện mới</button>
        </a>
    </div>

</body>

</html>