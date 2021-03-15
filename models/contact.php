<?php
class Contact {
    public $first_person_id;
    public $second_person_id;
    public $contact_day;
    public $contact_place;

    public function savecontact() 
    {
        $sql = "INSERT INTO contacts(first_person_id, second_person_id, contact_day, contact_place)
                            VALUES(:first_person_id, :second_person_id, :contact_day, :contact_place)";
        
        $stmt = DB::connect()->prepare($sql);

        $info = array(
            "first_person_id" => $this->first_person_id,
            "second_person_id" => $this->second_person_id,
            "contact_day" => $this->contact_day,
            "contact_place" => $this->contact_place
        );

        return $stmt->execute($info);
    }

    static function checkContact($id1, $id2) 
    {
        $sql = "SELECT * FROM contacts
                WHERE (first_person_id = $id1 and second_person_id = $id2)
                    OR (first_person_id = $id2 and second_person_id = $id1)";
        $stmt = DB::connect()->prepare($sql);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == []) return false;
        else return true;
    }

    static function getContactIdList($id)
    {
        $sql = "SELECT first_person_id AS contact_id FROM contacts
                WHERE second_person_id = $id
                UNION
                SELECT second_person_id AS contact_id FROM contacts
                WHERE  first_person_id = $id";

        $stmt = DB::connect()->prepare($sql);
        
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $idList = [];
        foreach($rawData as $row) {
            $idList[] = $row["contact_id"];
        }

        return $idList;
    }

    static function removeContact($id) {
        $sql = "DELETE FROM contacts
                WHERE (first_person_id = $id) OR (second_person_id = $id)";
        
        $stmt = DB::connect()->prepare($sql);
        
        $stmt->execute();
    }
}