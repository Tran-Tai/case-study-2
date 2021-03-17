<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person List</title>
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
            max-width: 300px;
        }

        .input_patient_info {
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
                <th class="text-center" colspan="11"> Danh sách bệnh nhân</th>
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
                <th>Diện tiếp xúc</th>
                <th>Ghi chú</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($personList as $key => $person) {
                $status = "";
                switch ($person->group) {
                    case 0:
                        switch ($person->status) {
                            case -2:
                                $status = "Đã bàn giao";
                                break;
                            case -1:
                                $status = "Tử vong";
                                break;
                            case 0:
                                $status = "Dương tính";
                                break;
                            case 4:
                                $status = "Đã bình phục";
                                break;
                            default:
                                $status = "Âm tính lần $person->status";
                        }
                        break;
                    default:
                        $status = "Âm tính";
                        break;
                }
                $traceGroup = $person->group + 1;
                if ($person->status >= 0 && $person->status < 4) {
                $content = "<a target='_blank' href='?controller=persons&action=detail&id=$person->identity_number'>
                                <button>Thông tin chi tiết</button>
                            </a>";
                } else $content ="";
                if ($person->status >= 0 && $person->status < 4)
                echo '
            <tr>
                <td>' . ($key + 1) . '</td>
                <td>' . $person->name . '</td>
                <td>' . $person->identity_number . '</td>
                <td>' . $person->birthday . '</td>
                <td>' . (($person->gender == 1) ? "Nam" : "Nữ") . '</td>
                <td>' . $person->phone . '</td>
                <td>' . $person->address . '</td>
                <td>' . $status . '</td>
                <td>F' . $person->group . '</td>
                <td>' . $person->comment . '</td>
                <td>' . $content . '</td>
            </tr>
            ';
            }
            ?>
        </tbody>
    </table>
    <div class="text-center">
        <a target="_blank" href="?controller=persons&action=add">
            <button class="input_patient_info">Nhập thông tin người bệnh mới</button>
        </a>
    </div>
</body>

</html>