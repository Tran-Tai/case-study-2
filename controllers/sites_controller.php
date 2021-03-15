<?php
include_once("models/site.php");

class SitesController {
    function list() {
        $siteList = Site::getAll();
        include_once("views/sites/listSite.php");
    }

    function add() {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            include_once("views/sites/addSite.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->inputSiteInfo();
        }
    }

    function inputSiteInfo() {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $capacity = $_POST["capacity"];
        $used_bed = 0;
        $phone_number = $_POST["phone_number"];

        $site = new Site();
        
        $site->name = $name;
        $site->address = $address;
        $site->capacity = $capacity;
        $site->used_bed = $used_bed;
        $site->phone_number = $phone_number;

        $site->saveInfo();

        header("location:?controller=sites&action=list");
    }

    function edit() {
        $id = $_GET["id"];
        if ($_SERVER["REQUEST_METHOD"] == "GET")
            $site = Site::getSite($id);
            include_once("views/sites/editSite.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->updateSiteInfo($id);
        }
    }

    function updateSiteInfo($id) {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $capacity = $_POST["capacity"];
        $phone_number = $_POST["phone_number"];

        $site = new Site();
        
        $site->name = $name;
        $site->address = $address;
        $site->capacity = $capacity;
        $site->phone_number = $phone_number;

        $site->updateInfo($id);

        header("location:?controller=sites&action=list");
    }

    function detail() {
        $id = $_GET["id"];
        $site = Site::getSite($id);
        include_once("models/person.php");
        $personList = Person::getSiteList($id);
        include_once("views/sites/detailSite.php");
    }
}