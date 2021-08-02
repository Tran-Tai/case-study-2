<?php

class Site
{
    public $id;
    public $name;
    public $address;
    public $capacity;
    public $used_bed;
    public $phone_number;

    static function getAll()
    {
        $sql = "SELECT * FROM sites";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $site_list = [];

        foreach ($rawData as $row) {
            $site = new Site();

            $site->id = $row["id"];
            $site->name = $row["name"];
            $site->address = $row["address"];
            $site->capacity = $row["capacity"];
            $site->used_bed = $row["used_bed"];
            $site->phone_number = $row["phone_number"];

            $site_list[] = $site;
        }
        return $site_list;
    }

    static function getSite($id)
    {
        $sql = "SELECT * FROM sites
                WHERE id = $id";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $site = new Site();

            $site->id = $row["id"];
            $site->name = $row["name"];
            $site->address = $row["address"];
            $site->capacity = $row["capacity"];
            $site->used_bed = $row["used_bed"];
            $site->phone_number = $row["phone_number"];

        return $site;
    }

    function saveInfo()
    {
        $sql = "INSERT INTO sites(name, address, capacity, used_bed, phone_number)
                            VALUES (:name, :address, :capacity, :used_bed, :phone_number)";
        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "name" => $this->name,
            "address" => $this->address,
            "capacity" => $this->capacity,
            "used_bed" => $this->used_bed,
            "phone_number" => $this->phone_number
        );

        return $stmt->execute($info);
    }

    function updateInfo($id)
    {

        $sql = "UPDATE sites
                SET name = :name,
                address = :address,
                capacity = :capacity,
                phone_number = :phone_number
                WHERE id = $id";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "name" => $this->name,
            "address" => $this->address,
            "capacity" => $this->capacity,
            "phone_number" => $this->phone_number
        );

        return $stmt->execute($info);
    }

    function changeNumber($num)
    {
        $number = $this->used_bed;
        $newNumber = $number + $num;
        if ($newNumber > $this->capacity) return false;
        $id = $this->id;

        $sql = "UPDATE sites
                SET used_bed = :used_bed
                WHERE id = $id";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
        "used_bed" => $newNumber
        );

        return $stmt->execute($info);
    }
}
