<?php

class Hospital
{
    public $id;
    public $name;
    public $address;
    public $capacity;
    public $used_bed;
    public $phone_number;

    static function getAll()
    {
        $sql = "SELECT * FROM hospitals";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hospital_list = [];

        foreach ($rawData as $row) {
            $hospital = new Hospital();

            $hospital->id = $row["id"];
            $hospital->name = $row["name"];
            $hospital->address = $row["address"];
            $hospital->capacity = $row["capacity"];
            $hospital->used_bed = $row["used_bed"];
            $hospital->phone_number = $row["phone_number"];

            $hospital_list[] = $hospital;
        }
        return $hospital_list;
    }

    static function getHospital($id)
    {
        $sql = "SELECT * FROM hospitals
                WHERE id = $id";
        $stmt = DB::connect()->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $hospital = new Hospital();

            $hospital->id = $row["id"];
            $hospital->name = $row["name"];
            $hospital->address = $row["address"];
            $hospital->capacity = $row["capacity"];
            $hospital->used_bed = $row["used_bed"];
            $hospital->phone_number = $row["phone_number"];

        return $hospital;
    }

    function saveInfo()
    {
        $sql = "INSERT INTO hospitals(name, address, capacity, used_bed, phone_number)
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

        $sql = "UPDATE hospitals
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

        $sql = "UPDATE hospitals
                SET used_bed = :used_bed
                WHERE id = $id";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
        "used_bed" => $newNumber
        );

        return $stmt->execute($info);
    }
}
