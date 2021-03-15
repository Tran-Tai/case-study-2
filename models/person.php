<?php

class Person {
    public $identity_number;
    public $name;
    public $birthday;
    public $gender;
    public $phone;
    public $address;
    public $status;
    public $comment;
    public $group;

    public $symtoms_appeared_day;
    public $hospitalized_day;
    public $hospital_id;

    public $contact_day;
    public $quarantined_day;
    public $site_id;

    static function getAll() {
        $sql = "SELECT * FROM persons
                ORDER BY `group`";

        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $person_list = [];

        foreach ($rawData as $row)
        {
            $person = new Person();
            $person->identity_number = $row["identity_number"];
            $person->name = $row["name"];
            $person->birthday = $row["birthday"];
            $person->gender = $row["gender"];
            $person->phone = $row["phone"];
            $person->address = $row["address"];
            $person->status = $row["status"];
            $person->comment = $row["comment"];
            $person->group = $row["group"];

            $person_list[] = $person;
        }

        return $person_list;
    }

    static function getColumn($id, $columnName) {
        $sql = "SELECT $columnName FROM persons
                WHERE identity_number = $id";

        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $rowData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $value = $rowData[$columnName];

        return $value;
    }

    static function removePerson($id) {
        $group = self::getColumn($id, "`group`");
        
        switch($group) {
            case 0:
                self::removePatient($id);
                break;
            case 1:
                self::removeQuarantinedPerson($id);
                break;
        }

        $sql = "DELETE FROM persons
                WHERE identity_number = $id";

        $stmt = DB::$connection->prepare($sql);

        $stmt->execute();
    }

    static function updateColumn($id, $columnName, $value) {
        $sql = "UPDATE persons
                SET $columnName = $value
                WHERE identity_number = $id";

        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();
        echo "update okay";
    }
    
    static function checkExistedId($id) 
    {
        $personList = self::getAll();
        foreach($personList as $person) 
        {
            if ($person->identity_number == $id) {
                return $person;
            }
        }
        return NULL;
    }

    static function getInfo($id) {
        $sql = "SELECT * FROM persons
                WHERE identity_number = $id";
        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $person = new Person();
            $person->identity_number = $row["identity_number"];
            $person->name = $row["name"];
            $person->birthday = $row["birthday"];
            $person->gender = $row["gender"];
            $person->phone = $row["phone"];
            $person->address = $row["address"];
            $person->status = $row["status"];
            $person->comment = $row["comment"];
            $person->group = $row["group"];
        switch($person->group) {
            case 0:
                $person = self::getPatientInfo($person);
                break;
            case 1:
                $person = self::getQuarantinedPersonInfo($person);
                break;
        }   
        return $person;
    }

    static function getPatientInfo($person) {
        $id = $person->identity_number;

        $sql = "SELECT * FROM patients
                WHERE identity_number = $id";
        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $person->symtoms_appeared_day = $row["symtoms_appeared_day"];
        $person->hospitalized_day = $row["hospitalized_day"];
        $person->hospital_id = $row["hospital_id"];

        return $person;
    }

    static function getQuarantinedPersonInfo($person) {
        $id = $person->identity_number;
        
        $sql = "SELECT * FROM quarantined_persons
                WHERE identity_number = $id";
        
        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $person->quarantined_day = $row["quarantined_day"];
        $person->site_id = $row["site_id"];

        return $person;
    }

    public function saveInfo() {
        $sql = "INSERT INTO persons(name, birthday, gender, identity_number, phone, address, status, comment, `group`)
                            VALUES(:name, :birthday, :gender, :identity_number, :phone, :address, :status, :comment, :group)";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
                    "name" => $this->name, 
                    "birthday" => $this->birthday, 
                    "gender" => $this->gender, 
                    "identity_number" => $this->identity_number, 
                    "phone" => $this->phone, 
                    "address" => $this->address, 
                    "status" => $this->status, 
                    "comment" => $this->comment, 
                    "group" => $this->group
        );
        return $stmt->execute($info);
    }

    public function updateInfo() {
        $sql = "UPDATE persons
                SET name = :name,
                birthday = :birthday,
                gender = :gender,
                phone = :phone,
                address = :address,
                status = :status,
                comment = :comment
                WHERE identity_number = :identity_number";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
                    "name" => $this->name, 
                    "birthday" => $this->birthday, 
                    "gender" => $this->gender, 
                    "phone" => $this->phone, 
                    "address" => $this->address, 
                    "status" => $this->status, 
                    "comment" => $this->comment, 
                    "identity_number" => $this->identity_number
        );
        return $stmt->execute($info);
    }

    public function savePatientInfo() {
        $sql = "INSERT INTO patients(identity_number, symtoms_appeared_day, hospitalized_day, hospital_id)
                            VALUES(:identity_number, :symtoms_appeared_day, :hospitalized_day, :hospital_id)";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "identity_number" => $this->identity_number, 
            "symtoms_appeared_day" => $this->symtoms_appeared_day, 
            "hospitalized_day" => $this->hospitalized_day, 
            "hospital_id" => $this->hospital_id, 
        );
        
        return $stmt->execute($info);
    }

    static function removePatient($id) {
        $sql = "DELETE FROM patients
                WHERE  identity_number = $id";
        $stmt = DB::connect()->prepare($sql);
        return $stmt->execute();
    }

    public function saveQuarantinedPersonInfo() {
        $sql = "INSERT INTO quarantined_persons(identity_number, quarantined_day, site_id, contact_day)
                            VALUES(:identity_number, :quarantined_day, :site_id, :contact_day)";

        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "identity_number" => $this->identity_number, 
            "quarantined_day" => $this->quarantined_day, 
            "site_id" => $this->site_id, 
            "contact_day" => $this->contact_day, 
        );

        return $stmt->execute($info);
    }

    static function removeQuarantinedPerson($id) {
        $sql = "DELETE FROM quarantined_persons
                WHERE  identity_number = $id";
        $stmt = DB::connect()->prepare($sql);
        return $stmt->execute();
    }

    static function getHospitalList($hospitalId) {
        $sql = "SELECT persons.identity_number, 
                        persons.name,
                        persons.gender,
                        persons.birthday,                        
                        persons.phone,
                        persons.address,
                        persons.status,
                        patients.symtoms_appeared_day, 
                        patients.hospitalized_day 
                FROM persons
                LEFT JOIN patients 
                ON persons.identity_number = patients.identity_number
                WHERE patients.hospital_id = $hospitalId
                ";

        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $person_list = [];

        foreach ($rawData as $row)
        {
            $person = new Person();
            $person->identity_number = $row["identity_number"];
            $person->name = $row["name"];
            $person->birthday = $row["birthday"];
            $person->gender = $row["gender"];
            $person->phone = $row["phone"];
            $person->address = $row["address"];
            $person->status = $row["status"];
            $person->symtoms_appeared_day = $row["symtoms_appeared_day"];
            $person->hospitalized_day = $row["hospitalized_day"];

            $person_list[] = $person;
        }

        return $person_list;
    }

    static function getSiteList($siteId) {
        $sql = "SELECT persons.identity_number, 
                        persons.name,
                        persons.gender,
                        persons.birthday,                        
                        persons.phone,
                        persons.address,
                        persons.status,
                        quarantined_persons.contact_day,
                        quarantined_persons.quarantined_day 
                FROM persons
                LEFT JOIN quarantined_persons 
                ON persons.identity_number = quarantined_persons.identity_number
                WHERE quarantined_persons.site_id = $siteId
                ";

        $stmt = DB::connect()->prepare($sql);
 
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $person_list = [];

        foreach ($rawData as $row)
        {
            $person = new Person();
            $person->identity_number = $row["identity_number"];
            $person->name = $row["name"];
            $person->birthday = $row["birthday"];
            $person->gender = $row["gender"];
            $person->phone = $row["phone"];
            $person->address = $row["address"];
            $person->status = $row["status"];
            $person->contact_day = $row["contact_day"];
            $person->quarantined_day = $row["quarantined_day"];

            $person_list[] = $person;
        }

        return $person_list;
    }
}

