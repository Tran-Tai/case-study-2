<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site List</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap.css" />
    <link rel="stylesheet" href="/assets/styles/bootstrap-grid.css" />
    <style>
        /* table {
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
        } */
    </style>
</head>

<body>
    <?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div class="container col-8 my-1 p-1">
    <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="thead-light text-center">
            <tr>
                <th  class="p-1 text-center" colspan="7">Danh sách cơ sở cách ly</th>
            </tr>
            <tr class="text-center">
                <th class="p-1">STT</th>
                <th class="p-1">Tên cơ sở cách ly</th>
                <th class="p-1">Địa Chỉ</th>
                <th class="p-1">Tổng số giường</th>
                <th class="p-1">Số giường trống</th>
                <th class="p-1">Số điện thoại</th>
                <th class="p-1"></th>
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
                <td class='p-1'>" . ($key + 1) . "</td>
                <td class='p-1'>$site->name</td>
                <td class='p-1'>$site->address</td>
                <td class='p-1'>$site->capacity</td>
                <td class='p-1'>" . $site->capacity - $site->used_bed . "</td>
                <td class='p-1'>$site->phone_number</td>
                <td class='p-1'>$content</td>
            </tr>
            ";
            }
            ?>
        </tbody>
    </table>
    </div>
    <div class="text-center">
        <a type="button" class="btn-info m-3 p-3 rounded" href='?controller=sites&action=add'>
            Thêm thông tin cơ sở cách ly mới
        </a>
    </div>

</body>

</html>