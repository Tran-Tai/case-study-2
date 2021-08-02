<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user List</title>
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
    <div class="container col-8 my-1 p-1">
        <table class="table table-sm table-bordered table-striped table-hover">
            <thead class="thead-light text-center">
                <tr>
                    <th class="text-center" colspan="6">Danh sách người dùng</th>
                </tr>
                <tr>
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Tên hiển thị</th>
                    <th>Tài khoản</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($userList as $key => $user) {
                    $status = "";
                    switch ($user->status) {
                        case 0:
                            $status = "Administrator";
                            $content = "<a type='button' class='btn btn-primary' href='?controller=users&action=detail&id=$user->id'>
                            Chi tiết
                        </a>";
                            break;
                        case 1:
                            $status = "Active";
                            $content = "<a type='button' class='btn btn-danger' href='?controller=users&action=change&act=deactive&id=$user->id'>
                            Deactive
                        </a>";
                            break;
                        case 2:
                            $status = "Registed";
                            $content = "<a type='button' class='btn btn-success' href='?controller=users&action=change&act=active&id=$user->id'>
                            Active
                        </a>";
                            break;
                        case 3:
                            $status = "Deactive";
                            $content = "<a type='button' class='btn btn-success' href='?controller=users&action=change&act=active&id=$user->id'>
                            Active
                        </a>";
                            break;
                    }
                    echo "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>$user->user_name</td>
                            <td>$user->display_name</td>
                            <td>$user->account</td>
                            <td>$status</td>
                            <td class='text-center'>$content</td>
                        </tr>
                        ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>