<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person List</title>
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
            max-width: 300px;
        }

        .input_patient_info {
            margin: 20px 100px;
            padding: 5px;
            text-align: center;
            font-size: 18px;
        } */
    </style>
</head>

<body>
    <?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <form class="form-group" method="POST">
      <div class="container input-group col-7">
        <select name="category">
            <option disabled selected>Tìm kiếm theo</option>
            <option value="name">Họ và tên</option>
            <option value="identity_number">Số CMND</option>
            <option value="birthday">Ngày sinh</option>
            <option value="gender">Giới tính</option>
            <option value="phone">Số điện thoại</option>
            <option value="address">Địa chỉ</option>
            <option value="`group`">Diện tiếp xúc</option>
            <option value="comment">Ghi chú</option>
        </select>
        <input type="search" class="form-control" name="search" placeholder="Nhập từ khóa">
        <select name="type">
            <option disabled selected>Tình trạng</option>
            <option value="1">Đang theo dõi</option>
            <option value="2">Đã hồi phục</option>
            <option value="3">Tử vong</option>
            <option value="4">Tất cả</option>
        </select>
        <input class="btn btn-success" type="submit" value="Tìm kiếm">
        <a class="btn btn-primary ml-1" <?php if ($_SERVER["REQUEST_METHOD"] != "POST") {echo "hidden";}?> type="button" href="?controller=persons&action=list">Danh sách</a>
      </div>
    </form>
    <div class="container col-8 my-1 p-1">
    <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="thead-light text-center">
            <tr>
                <th class="p-1 text-center" colspan="11"> Danh sách bệnh nhân</th>
            </tr>
            <tr class="text-center">
                <th class="p-1">STT</th>
                <th class="p-1">Họ và tên</th>
                <th class="p-1">Số CMND</th>
                <th class="p-1">Ngày sinh</th>
                <th class="p-1">Giới tính</th>
                <th class="p-1">Số điện thoại</th>
                <th class="p-1">Địa chỉ</th>
                <th class="p-1">Tình trạng</th>
                <th class="p-1">Diện tiếp xúc</th>
                <th class="p-1">Ghi chú</th>
                <th class="p-1"></th>
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
                                $status = "Tử vong";
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
                if ((($person->status >= 0 && $person->status < 4) && ($_SERVER["REQUEST_METHOD"] != "POST")) 
                    || ($_SERVER["REQUEST_METHOD"] == "POST"))
                echo '
            <tr>
                <td class="p-1">' . ($key + 1) . '</td>
                <td class="p-1">' . $person->name . '</td>
                <td class="p-1">' . $person->identity_number . '</td>
                <td class="p-1">' . $person->birthday . '</td>
                <td class="p-1">' . (($person->gender == 1) ? "Nam" : "Nữ") . '</td>
                <td class="p-1">' . $person->phone . '</td>
                <td class="p-1">' . $person->address . '</td>
                <td class="p-1">' . $status . '</td>
                <td class="p-1">F' . $person->group . '</td>
                <td class="p-1">' . $person->comment . '</td>
                <td class="p-1">' . $content . '</td>
            </tr>
            ';
            }
            ?>
        </tbody>
    </table>
    </div>
    <div class="text-center">
        <a type="button" class="btn-info m-3 p-3 rounded" target="_blank" href="?controller=persons&action=add">
            Nhập thông tin người bệnh mới
        </a>
    </div>
</body>

</html>