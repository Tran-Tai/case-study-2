<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient Form</title>
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
            float: right;
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
            float: left;
            padding: 10px;
            margin: 20px;
        }
    </style>
</head>

<body>
<?php include_once("/Codegym/Module2/case_study/views/header.php") ?>
    <div>
        <h1 class="text-center">Trang nhập thông tin tiếp xúc</h1>
    </div>
    <div>
        <?php
        if (isset($contactPerson)) {
            echo "
        <div class='info'>
            <fieldset>       
                <legend>Thông tin " . (($contactPerson->group == 0) ? "bệnh nhân" : "người nghi nhiễm") .
                " (F$contactPerson->group)</legend>            
                <label>Họ và tên: </label>
                <p>$contactPerson->name</p></br>
                <label>Số CMND: </label>
                <p>$contactPerson->identity_number</p></br>
                <label>Ngày sinh: </label>
                <p>$contactPerson->birthday</p></br>
                <label>Giới tính: </label>
                <p>" . (($contactPerson->gender == 1) ? 'Nam' : 'Nữ') . "</p></br>
                <label>Số điện thoại: </label>
                <p>$contactPerson->phone</p></br>
                <label>Địa chỉ: </label>
                <p>$contactPerson->address</p></br>           
            </fieldset>
        </div>
    ";
        }
        ?>

        <form method="POST">
            <fieldset>
                <legend>
                    Nhập thông tin
                    <?php
                    switch ($group) {
                        case 0:
                            echo "bệnh nhân";
                            break;
                        default:
                            echo "người tiếp xúc";
                            break;
                    }
                    echo " (F$group)";
                    ?>
                </legend>
                <label for="name">Họ và tên:</label></br>
                <input type="text" name="name"></br>
                <label for="identity_number">Số CMND:</label></br>
                <input type="number" name="identity_number"></br>
                <label for="birthday">Ngày sinh:</label></br>
                <input type="date" name="birthday"></br>
                <label for="gender">Giới tính:</label></br>
                <input type="radio" id="male" name="gender" value="1">
                <label for="male">Nam</label><br>
                <input type="radio" id="female" name="gender" value="0">
                <label for="female">Nữ</label><br>
                <label for="phone">Số điện thoại:</label></br>
                <input type="number" name="phone"></br>
                <label for="address">Địa chỉ</label></br>
                <input type="text" name="address"></br>
                <label for="status">Tình trạng:</label></br>
                <input type="text" name="status" value="0" hidden>
                <input type="text" value="<?php echo ($group == 0) ? "Dương tính" : "Âm tính" ?>" readonly></br>
                <label for="comment">Ghi chú:</label></br>
                <input type="text" name="comment" value="<?php
                                                            switch($group) {
                                                                case 0:
                                                                    echo "Đang điều trị";
                                                                    break;
                                                                case 1:
                                                                    echo "Đang cách ly";
                                                                    break;
                                                                default:
                                                                    echo "Đang theo dõi";
                                                                    break;
                                                            }
                                                        ?>" readonly></br>
                <?php
                if ($group == 1) {
                    $date=date_create($contactPerson->symtoms_appeared_day);
                    date_sub($date,date_interval_create_from_date_string("3days"));
                    echo
               '<label for="contact_day">Thời điểm tiếp xúc: (từ '. (date_format($date,"Y-m-d")) .' đến '. $contactPerson->hospitalized_day .')</label></br>
                <input type="date" name="contact_day" min="'. (date_format($date,"Y-m-d")) .'" 
                                                      max="'. $contactPerson->hospitalized_day .'"></br>
                <label for="contact_place">Địa điểm tiếp xúc:</label></br>
                <input type="text" name="contact_place"></br>';
                }
                if ($group == 2) {
                    echo
               '<label for="contact_day">Thời điểm tiếp xúc: (từ '. $contactPerson->contact_day .' đến '. $contactPerson->quarantined_day .')</label></br>
                <input type="date" name="contact_day" min="'. $contactPerson->contact_day .'" 
                                                      max="'. $contactPerson->quarantined_day .'"></br>
                <label for="contact_place">Địa điểm tiếp xúc:</label></br>
                <input type="text" name="contact_place"></br>';
                }
                if ($group > 2) {
                    echo
               '<label for="contact_day">Thời điểm tiếp xúc: (từ '. $contactPerson->monitor_day .')</label></br>
                <input type="date" name="contact_day" min="'. $contactPerson->monitor_day .'" 
                                                      max="'. date("Y-m-d") .'"></br>
                <label for="contact_place">Địa điểm tiếp xúc:</label></br>
                <input type="text" name="contact_place"></br>';
                }
                if ($group == 0) {
                    $hospitalOptions = "";
                    foreach($hospitalList as $hospital) {
                        $hospitalOptions .= "<option value=".$hospital->id.">$hospital->name</option>";
                    }
                    echo
               '<label for="symtoms_appeared_day">Ngày khởi bệnh</label></br>
                <input type="date" name="symtoms_appeared_day"></br>
                <label for="hospitalized_day">Ngày nhập viện:</label></br>
                <input type="date" name="hospitalized_day"></br>
                <label for="hospital_id">Bệnh viện:</label></br>
                <select name="hospital_id">
                    '.$hospitalOptions.'
                </select></br>';
                }

                if ($group == 1) {
                    $siteOptions = "";
                    foreach($siteList as $site) {
                        $siteOptions .= "<option value=".$site->id.">$site->name</option>";
                    }
                    echo
                    '<label for="quarantined_day">Ngày cách ly:</label></br>
                <input type="date" name="quarantined_day"></br>
                <label for="site_id">Khu cách ly:</label></br>
                <select name="site_id">
                    '.$siteOptions.'
                </select></br>';
                }
                ?>
                <input type="submit" value="Nhập">
            </fieldset>
        </form>
    </div>
    <div>
    <a type="button" class="btn-info m-3 p-3 rounded" target="_blank" href="?controller=persons&action=list">
            Hoàn thành nhập thông tin
        </a>
    </div>
</body>

</html>