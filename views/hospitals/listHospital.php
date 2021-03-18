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
    <table class="mx-auto mt-5 table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th  class="p-1 text-center" colspan="7">Danh sách bệnh viện</th>
            </tr>
            <tr class="text-center">
                <th class="p-1">STT</th>
                <th class="p-1">Tên bệnh viện</th>
                <th class="p-1">Địa Chỉ</th>
                <th class="p-1">Số giường bệnh</th>
                <th class="p-1">Số giường trống</th>
                <th class="p-1">Số điện thoại</th>
                <th class="p-1"></th>
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
                <td class='p-1'>" . ($key + 1) . "</td>
                <td class='p-1'>$hospital->name</td>
                <td class='p-1'>$hospital->address</td>
                <td class='p-1'>$hospital->capacity</td>
                <td class='p-1'>" . $hospital->capacity - $hospital->used_bed . "</td>
                <td class='p-1'>$hospital->phone_number</td>
                <td class='p-1'>$content</td>
            </tr>
            ";
            }
            ?>
        </tbody>
    </table>
    <div class="text-center">
        <a type="button" class="btn-info m-3 p-3 rounded" href='?controller=hospitals&action=add'>
            Thêm thông tin bệnh viện mới
        </a>
    </div>

</body>

</html>