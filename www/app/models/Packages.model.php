<?php

class Packages
{


    public static function get_all()
    {

        $DB = Database::getInstance();
        return $DB->read("select * from Packages order by id asc");
    }




    public static function get_by_id($id)
    {

        $DB = Database::getInstance();
        return $DB->read("select * from Packages where id = :id", array('id' => $id));
    }


    public static function add_package($name, $description, $unitCost)
    {
        $DB = Database::getInstance();

        $DBdata = array(
            'name' => $name,
            'description' => $description,
            'unitCost' => $unitCost
        );

        $query = "insert into Packages (Item,Description,UnitCost) values (:name,:description,:unitCost)";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    public static function edit_package($id, $name, $description, $unitCost)
    {
        $DB = Database::getInstance();

        $DBdata = array(
            'name' => $name,
            'description' => $description,
            'unitCost' => $unitCost,
            'id' => $id
        );

        $query = "update Packages set Item = :name, Description = :description, UnitCost = :unitCost where id = :id";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }




    public static function delete_package($id)
    {
        $DB = Database::getInstance();

        $DBdata = array(
            'id' => $id
        );


        $query = "delete from Packages where id = :id";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }



}
