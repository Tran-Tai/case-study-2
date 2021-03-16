<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site List</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
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
                <th class="text-center" colspan="7">Danh sách cơ sở cách ly</th>
            </tr>
            <tr>
                <th>STT</th>
                <th>Tên cơ sở cách ly</th>
                <th>Địa Chỉ</th>
                <th>Tổng số giường</th>
                <th>Số giường trống</th>
                <th>Số điện thoại</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($siteList as $key => $site) {
                $content = "<a href='?controller=sites&action=detail&id=$site->id'>
                            <button>Chi tiết</button>
                        </a>";
                echo "
            <tr>
                <td>" . ($key + 1) . "</td>
                <td>$site->name</td>
                <td>$site->address</td>
                <td>$site->capacity</td>
                <td>" . $site->capacity - $site->used_bed . "</td>
                <td>$site->phone_number</td>
                <td>$content</td>
            </tr>
            ";
            }
            ?>
        </tbody>
    </table>
    <div class="text-center">
        <a href='?controller=sites&action=add'>
            <button class="input_info">Thêm thông tin cơ sở cách ly mới</button>
        </a>
    </div>

</body>

</html>