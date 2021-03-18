<?php

class User
{
    public $id;
    public $user_name;
    public $display_name;
    public $account;
    public $password;
    public $status;

    static function getAll()
    {
        $sql = "SELECT * FROM users";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user_list = [];

        foreach ($rawData as $row) {
            $user = new User();

            $user->id = $row["id"];
            $user->user_name = $row["user_name"];
            $user->display_name = $row["display_name"];
            $user->account = $row["account"];
            $user->password = $row["password"];
            $user->status = $row["status"];

            $user_list[] = $user;
        }
        return $user_list;
    }

    static function getUser($id)
    {
        $sql = "SELECT * FROM users
                WHERE id = $id";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $user = new User();

            $user->id = $row["id"];
            $user->user_name = $row["user_name"];
            $user->display_name = $row["display_name"];
            $user->account = $row["account"];
            $user->password = $row["password"];
            $user->status = $row["status"];

        return $user;
    }

    static function checkUser($account, $password)
    {
        $sql = "SELECT * FROM users
                WHERE (account = '$account')
                AND (`password` = '$password')";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row == []) return NULL;
            $user = new User();

            $user->id = $row["id"];
            $user->user_name = $row["user_name"];
            $user->address = $row["display_name"];
            $user->account = $row["account"];
            $user->password = $row["password"];
            $user->status = $row["status"];

        return $user;
    }

    function saveInfo()
    {
        $sql = "INSERT INTO users(`user_name`, display_name, account, password, status)
                            VALUES (:user_name, :display_name, :account, :password, :status)";
        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "user_name" => $this->user_name,
            "display_name" => $this->display_name,
            "account" => $this->account,
            "password" => $this->password,
            "status" => $this->status
        );

        return $stmt->execute($info);
    }

    function updatePassword()
    {
        $id = $this->id;
        $sql = "UPDATE users
                SET password = :password
                WHERE id = $id";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "password" => $this->password
        );

        return $stmt->execute($info);
    }

    function updateStatus($newStatus)
    {
        $id = $this->id;
        $sql = "UPDATE users
                SET status = :status
                WHERE id = $id";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "status" => $newStatus
        );

        return $stmt->execute($info);
    }
}