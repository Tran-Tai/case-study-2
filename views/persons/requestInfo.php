<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient Form</title>
    <link rel="stylesheet" href="/assets/styles/bootstrap.min.css" />
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
        <h1>Trang nhập thông tin cách ly</h1>
    </div>
    <div>
        <?php
            echo "
        <div class='info'>
            <fieldset>       
                <legend>Thông tin người tiếp xúc (F$person->group)</legend>            
                <label>Họ và tên: </label>
                <p>$person->name</p></br>
                <label>Số CMND: </label>
                <p>$person->identity_number</p></br>
                <label>Ngày sinh: </label>
                <p>$person->birthday</p></br>
                <label>Giới tính: </label>
                <p>" . (($person->gender == 1) ? 'Nam' : 'Nữ') . "</p></br>
                <label>Số điện thoại: </label>
                <p>$person->phone</p></br>
                <label>Địa chỉ: </label>
                <p>$person->address</p></br>           
            </fieldset>
        </div>
    ";
        ?>

        <form method="POST">
            <fieldset>
                <legend>
                    Nhập thông tin cách ly
                </legend>
                <?php $contact = Contact::getContact($person->identity_number, $id) ?>
                <label for="contact_day">Thời điểm tiếp xúc:</label></br>
                <input type="date" name="contact_day" value="<?php echo $contact->contact_day ?>" readonly></br>
                <label for="contact_place">Địa điểm tiếp xúc:</label></br>
                <input type="text" name="contact_place" value="<?php echo $contact->contact_place ?>" readonly></br>';
                <?php
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
                ?>
                <input type="submit" value="Nhập">
            </fieldset>
        </form>
    </div>
</body>

</html>