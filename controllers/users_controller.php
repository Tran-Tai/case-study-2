<?php
include_once("models/user.php");

class UsersController
{
    function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $account = $_POST["account"];
            $password = $_POST["password"];
                $user = User::checkUser($account, $password);
                if (isset($user)) {
                    switch ($user->status) {
                        case 0:
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $id = $user->id;
                            $_SESSION["admin"] = true;
                            header("location:?controller=users&action=list");
                            break;
                        case 1:
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $user->id;
                            $id = $_SESSION["id"];
                            header("location:?controller=users&action=detail&id=$id");
                            break;
                        case 2:
                            $_SESSION["login"] = NULL;
                            $_SESSION["failmessage"] = "Tài khoản của bạn chưa được cấp quyền truy cập";
                            include_once("views/users/login.php");
                            break;
                        case 3:
                            $_SESSION["login"] = NULL;
                            $_SESSION["failmessage"] = "Tài khoản của bạn đã bị truất quyền truy cập, vui lòng liên hệ với quản trị viên";
                            include_once("views/users/login.php");
                            break;
                    }
                } 
                else {
                    $_SESSION["login"] = NULL;
                    $_SESSION["failmessage"] = "Tài khoản hoặc mật khẩu không đúng, vui lòng thử lại hoặc đăng ký tài khoản"; 
                    include_once("views/users/login.php");
                }
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            include_once("views/users/login.php");
        }
    }

    function signup() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_name = $_POST["user_name"];
            $display_name = $_POST["display_name"];
            $account = $_POST["account"];
            $password = $_POST["password"];
            $confirm = $_POST["confirm"];
            $status = $_POST["status"];
            if ($password != $confirm) {
                $_SESSION["failmessage"] = "Xác nhận mật khẩu không đúng, vui lòng nhập lại";
                include_once("views/users/signup.php");
                return;
            }
            $user = new User();

            $user->user_name = $user_name;
            $user->display_name = $display_name;
            $user->account = $account;
            $user->password = $password;
            $user->confirm = $confirm;
            $user->status = $status;
            var_dump($user);

            try {
                $storeSuccessful = $user->saveInfo();
                    if ($storeSuccessful) {
                        $_SESSION["message"] = "Đã đăng ký thành công, vui lòng chờ phê duyệt";
                    }
                    header("location:?controller=users&action=login");
                }
            catch(Exception $e) {
                $_SESSION["failmessage"] = "Đã có lỗi khi đăng ký, vui lòng xem lại thông tin đã nhập hoặc thử lại";
                include_once("views/users/signup.php");
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            include_once("views/users/signup.php");
        }
    }

    function list() {
            $userList = User::getAll();
            include_once("views/users/listUser.php");
    }

    function detail() {
        $id = $_GET["id"];
            $user = User::getUser($id);
            include_once("views/users/detailUser.php");
    }

    function edit() {
        $id = $_GET["id"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = User::getUser($id);
            $oldPassword = $_POST["oldPassword"];
            if ($oldPassword != $user->password) {
                $_SESSION["failmessage"] = "Mật khẩu cũ không đúng";
                include_once("views/users/editUser.php");
                return;
            }
            $password = $_POST["password"]; 
            $confirm = $_POST["confirm"]; 
            if ($password != $confirm) {
                $_SESSION["failmessage"] = "Xác nhận lại không trùng với mật khẩu nhập vào";
                include_once("views/users/editUser.php");
                return;
            }
            $user->password = $password;
            $user->updatePassword();
            $_SESSION["message"] = "Đổi mật khẩu thành công";
            include_once("views/users/detailUser.php");
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            include_once("views/users/editUser.php");
        }
    }

    function logout() {
        $_SESSION["admin"] = NULL;
        $_SESSION["id"] = NULL;
        $_SESSION["login"] = NULL;
        header("location:?controller=users&action=login");
    }

    function change() {
        $id = $_GET["id"];
        $act = $_GET["act"];
        switch ($act) {
            case "active":
                $user = User::getUser($id);
                $user->updateStatus(1);
                break;
            case "deactive":
                $user = User::getUser($id);
                $user->updateStatus(3);
                break;
        }
        header("location:?controller=users&action=list");
    }
}
