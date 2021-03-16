<?php
include_once("models/person.php");
include_once("models/contact.php");
include_once("models/hospital.php");
include_once("models/site.php");

class PersonsController
{
    function list()
    {
        $personList = Person::getAll();
        $today = date("Y-m-d");
        foreach($personList as $person) {
            if($person->group > 0) {
                $date=date_create($person->monitor_day);
                date_add($date,date_interval_create_from_date_string("14days"));
                $end_day = date_format($date,"Y-m-d");
                if($today>$end_day) {
                    if($person->group==1) $new_comment = "Có thể ngừng cách ly";
                    else $new_comment = "Có thể ngừng theo dõi";
                    if($person->comment != $new_comment)
                    Person::updateColumn($person->identity_number, "comment", $new_comment);
                }
            }
        }
        $personList = Person::getAll();
        include_once("views/persons/listPerson.php");
    }

    function add()
    {
        $id = $_GET["id"] ?? NULL;
        if (isset($id)) {
            $contactPerson = Person::getInfo($id);
            $group = $contactPerson->group + 1;
        } else $group = 0;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $hospitalList = Hospital::getAll();
            $siteList = Site::getAll();
            include_once("views/persons/addPerson.php");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {            
            $addedId = $_POST["identity_number"];
            if ($addedId == $id) {return;}
            $idExistence = Person::checkExistedId($addedId);
            if ($group == 0) {
                if (isset($idExistence)) {
                    if($idExistence->group == 1) Person::removeQuarantinedPerson($addedId);
                    $this->inputPatientInfo($idExistence);
                    $this->reclassify($addedId, 0);
                }
                else {
                    $this->inputPersonInfo($group);
                }
            } else {
                if (isset($idExistence)) {
                    if (!Contact::checkContact($id, $addedId)) {
                        $this->addContact($id);
                        $addedPerson = Person::getInfo($addedId);
                        if ($contactPerson->group - $addedPerson->group > 1) {
                            $this->reclassify($contactPerson->identity_number, $addedPerson->group + 1);
                        } elseif ($addedPerson->group - $contactPerson->group > 1) {
                            $this->reclassify($addedPerson->identity_number, $contactPerson->group + 1);
                        }
                    }
                } else {
                    $this->inputPersonInfo($group);
                    $this->addContact($id);
                }
            }
            include_once("views/persons/addPerson.php");
        }
    }

    function remove() 
    {
        $id = $_GET["id"];
        $person = Person::getInfo($id);
        Contact::removeContact($id);
        $group = $person->group;
        switch($group) {
            case 0:
                $hospital = Hospital::getHospital($person->hospital_id);
                $hospital->changeNumber(-1);
                Person::removePatient($id);
                if($person->status == -1) {
                    Person::updateColumn($id, "status", -2);
                    Person::updateColumn($id, "comment", "Đã xuất viện");
                }
                if($person->status == 3) {
                    Person::updateColumn($id, "status", 4);
                    Person::updateColumn($id, "comment", "Đã xuất viện");
                }
                break;
            case 1:    
                $site = Site::getSite($person->site_id);
                $site->changeNumber(-1);
                Person::removeQuarantinedPerson($id);
                Person::removePerson($id);
                break;
            default:
                Person::removePerson($id);
                break;
        }
        header("location:?controller=persons&action=list");
    }

    function detail() 
    {
        $id = $_GET["id"];
        
        $person = Person::getInfo($id);
        $idList = Contact::getContactIdList($id);
        $contactPersonList = [];
        foreach ($idList as $contactId) {
            $contactPerson = Person::getInfo($contactId);
            $contactPersonList[] = $contactPerson;
        }
        include_once("views/persons/detailPerson.php");
    }

    function edit() 
    {
        $id = $_GET["id"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->updatePersonInfo();
            header("location:?controller=persons&action=detail&id=$id");
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $person = Person::getInfo($id);
            include_once("views/persons/editPerson.php");
        }
    }

    function change()
    {
        $id = $_GET["id"];
        $act = $_GET["change"];
        switch($act) {
            case "dead":
                Person::updateColumn($id, "status", -1);
                Person::updateColumn($id, "comment", "Có thể xuất viện");
                break;
            case "positive":
                
                break;
            case "negative":
                break;
        }
        header("location:?controller=persons&action=detail&id=$id");
    }

    function updatePersonInfo()
    {
        $identity_number = $_POST["identity_number"];
        $name = $_POST["name"];
        $birthday = $_POST["birthday"];
        $gender = $_POST["gender"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $status = $_POST["status"];
        $comment = $_POST["comment"];


        $patient = new Person();
        $patient->identity_number = $identity_number;
        $patient->name = $name;
        $patient->birthday = $birthday;
        $patient->gender = $gender;
        $patient->phone = $phone;
        $patient->address = $address;
        $patient->status = $status;
        $patient->comment = $comment;

        $patient->updateInfo();
    }

    protected function reclassify($id, $group)
    {
        //echo "run function";
        $person = Person::getInfo($id);
        $traceLimit = 5;
        $trace = ($person->group < $traceLimit) ? true : false;
        Person::updateColumn($id, "`group`", $group);
        if ($trace) {
            $idList = Contact::getContactIdList($id);
            //var_dump($idList);
            foreach ($idList as $contactId) {
                //var_dump($contactId);
                //echo "<br/>";
                $contactPerson = Person::getInfo($contactId);
                //echo $contactPerson->group - $group . "<br/>";
                if ($contactPerson->group - $group > 1) {
                    $this->reclassify($contactId, $group + 1);
                }
            }
        }
    }

    protected function inputPersonInfo($group)
    {
        $identity_number = $_POST["identity_number"];
        $name = $_POST["name"];
        $birthday = $_POST["birthday"];
        $gender = $_POST["gender"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $status = $_POST["status"];
        $comment = $_POST["comment"];
        switch($group) {
            case 0:
                $monitor_day = $_POST["hospitalized_day"];
                break;
            case 1:
                $monitor_day = $_POST["quarantined_day"];
                break;
            default:
                $monitor_day = $_POST["contact_day"];
                break;
        }


        $patient = new Person();
        $patient->identity_number = $identity_number;
        $patient->name = $name;
        $patient->birthday = $birthday;
        $patient->gender = $gender;
        $patient->phone = $phone;
        $patient->address = $address;
        $patient->status = $status;
        $patient->comment = $comment;
        $patient->group = $group;
        $patient->monitor_day = $monitor_day;

        $patient->saveInfo();

        if ($group == 0) {
            $this->inputPatientInfo($patient);
        }

        if ($group == 1) {
            $this->inputQuanrantinedPersonInfo($patient);
        }
    }

    protected function inputPatientInfo($patient)
    {
        $symtoms_appeared_day = $_POST["symtoms_appeared_day"];
        $hospitalized_day = $_POST["hospitalized_day"];
        $hospital_id = $_POST["hospital_id"];

        $patient->symtoms_appeared_day = $symtoms_appeared_day;
        $patient->hospitalized_day = $hospitalized_day;
        $patient->hospital_id = $hospital_id;

        $hospital = Hospital::getHospital($hospital_id);
        $hospital->changeNumber(1);
        $patient->savePatientInfo();
    }

    protected function inputQuanrantinedPersonInfo($patient)
    {
        $quarantined_day = $_POST["quarantined_day"];
        $site_id = $_POST["site_id"];
        $contact_day = $_POST["contact_day"];

        $patient->quarantined_day = $quarantined_day;
        $patient->site_id = $site_id;
        $patient->contact_day = $contact_day;

        $site = Site::getSite($site_id);
        $site->changeNumber(1);
        $patient->saveQuarantinedPersonInfo();
    }

    protected function addContact($id)
    {
        $contact = new Contact();
        $first_person_id = $id;
        $second_person_id = $_POST["identity_number"];
        $contact_day = $_POST["contact_day"];
        $contact_place = $_POST["contact_place"];

        $contact->first_person_id = $first_person_id;
        $contact->second_person_id = $second_person_id;
        $contact->contact_day = $contact_day;
        $contact->contact_place = $contact_place;

        $contact->savecontact();
    }
}
