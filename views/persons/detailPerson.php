<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Patient Form</title>
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
            margin: 20px;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            border: 2px solid black;
        }

        th, td {
            padding: 5px;
            border: 1px solid grey;
        }

        .input_patient_info {
            margin: 20px 120px;
            padding: 10px;
            text-align: center;
            font-size: 20px;
        }
    </style>
</head>

<body>
<?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div>
        <h1>Thông tin chi tiết bệnh nhân</h1>
    </div>
    <div>
        <div class='info'>
            <fieldset>       
                <legend>Thông tin <?php echo (($person->group == 0) ? "bệnh nhân" : "người nghi nhiễm")?> 
                (F<?php echo $person->group?>)</legend>            
                <label>Họ và tên: </label>
                <p><?php echo $person->name?></p></br>
                <label>Số CMND: </label>
                <p><?php echo $person->identity_number?></p></br>
                <label>Ngày sinh: </label>
                <p><?php echo $person->birthday?></p></br>
                <label>Giới tính: </label>
                <p><?php echo (($person->gender == 1) ? "Nam" : "Nữ") ?></p></br>
                <label>Số điện thoại: </label>
                <p><?php echo $person->phone?></p></br>
                <label>Địa chỉ: </label>
                <p><?php echo $person->address?></p></br> 
                <?php   
                    switch($person->group){
                        case 0:
                            $hospital = Hospital::getHospital($person->hospital_id);
                            echo "
                                <label>Bệnh viện: </label>
                                <p>$hospital->name</p></br>
                                <label>Ngày nhập viện: </label>
                                <p>$person->hospitalized_day</p></br>
                            ";
                            break;
                        case 1:
                            $site = Site::getSite($person->site_id);
                            echo "
                                <label>Khu cách ly: </label>
                                <p>$site->name</p></br>
                                <label>Ngày cách ly: </label>
                                <p>$person->quarantined_day</p></br>
                            ";
                            break;
                    }
                    $traceGroup = $person->group + 1;
                    $content = "";
                    if ($person->group < 5) {
                    echo "<a target='_blank' href='?controller=persons&action=add&id=$person->identity_number'>
                                        <button>Điền thông tin người tiếp xúc (F$traceGroup)</button>
                                    </a></br></br>";
                    }

                    echo "<a href='?controller=persons&action=edit&id=$person->identity_number'>
                            <button>Chỉnh sửa thông tin</button>
                        </a>";
                ?>      
            </fieldset>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th colspan="9"> Danh sách người tiếp xúc</th>
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
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($contactPersonList as $key=>$contactPerson) {
                $status = "";
                switch($person->group) {
                    case 0:
                        switch($person->status) {
                            case -1:
                                $status = "Tử vong";
                                break;
                            case 0:
                                $status = "Dương tính";
                                break;
                            default:
                                $status = "Âm tính $person->status lần";
                        }
                        break;
                    default:
                        switch($person->status) {
                            case -1:
                                $status = "Tử vong";
                                break;
                            case 0:
                                $status = "Âm tính";
                                break;
                        }
                        break;
                }
            echo '
            <tr>
                <td>'. ($key + 1).'</td>
                <td>'. $contactPerson->name .'</td>
                <td>'. $contactPerson->identity_number .'</td>
                <td>'. $contactPerson->birthday .'</td>
                <td>'. (($contactPerson->gender == 1) ? "Nam" : "Nữ").'</td>
                <td>'. $contactPerson->phone .'</td>
                <td>'. $contactPerson->address .'</td>
                <td>'. $status .'</td>
                <td>F'. $contactPerson->group .'</td>
            </tr>
            ';
            }
        ?>
        </tbody>
    </table>
</body>

</html>