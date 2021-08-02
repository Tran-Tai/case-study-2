<?php
include_once("models/hospital.php");

class HospitalsController {
    function list() {
        $hospitalList = Hospital::getAll();
        include_once("views/hospitals/listHospital.php");
    }

    function add() {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            include_once("views/hospitals/addHospital.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->inputHospitalInfo();
        }
    }

    function inputHospitalInfo() {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $capacity = $_POST["capacity"];
        $used_bed = 0;
        $phone_number = $_POST["phone_number"];

        $hospital = new Hospital();
        
        $hospital->name = $name;
        $hospital->address = $address;
        $hospital->capacity = $capacity;
        $hospital->used_bed = $used_bed;
        $hospital->phone_number = $phone_number;

        $hospital->saveInfo();

        header("location:?controller=hospitals&action=list");
    }

    function edit() {
        $id = $_GET["id"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->updateHospitalInfo($id);
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            $hospital = Hospital::getHospital($id);
            include_once("views/hospitals/editHospital.php");
    }

    function updateHospitalInfo($id) {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $capacity = $_POST["capacity"];
        $phone_number = $_POST["phone_number"];

        $hospital = new Hospital();
        
        $hospital->name = $name;
        $hospital->address = $address;
        $hospital->capacity = $capacity;
        $hospital->phone_number = $phone_number;

        $hospital->updateInfo($id);

        header("location:?controller=hospitals&action=list");
    }

    function detail() {
        $id = $_GET["id"];
        $hospital = Hospital::getHospital($id);
        include_once("models/person.php");
        $personList = Person::getHospitalList($id);
        include_once("views/hospitals/detailHospital.php");
    }
}