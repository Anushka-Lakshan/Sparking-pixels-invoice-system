<?php

class Client
{


    public static function Add_client($data)
    {

        $errors = array();
        $db = Database::getInstance();

        include "app/core/Validator.php";

        $Validate = new Validator();

        if (!Validator::string($data['name'], 1, 50)) {
            $errors[''] = 'The Name is required.';
        }


        //check email already exist
        $sql = "select * from Clients where Name = :name limit 1";
        $arr['name'] = $data['name'];

        $check = $db->read($sql, $arr);

        if (is_array($check) && count($check) > 0) {
            array_push($errors, 'This Client Name is already in the system');
            // show($check);
        }


        if (empty($errors)) {

            $DBdata = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'Address' => $data['address'],
                'nic' => $data['nic'],
            );


            $query = "insert into Clients (Name,Email,Phone,Address,NIC) values
            (:name,:email,:phone,:Address,:nic)";

            $result = $db->write($query, $DBdata);

            if ($result) {

                sweetAlert("New Client Added", "");

                return array('success' => true);
            } else {
                return $errors;
            }
        } else {
            return $errors;
        }
    }

    


    public static function Update_client($data)
    {
        $errors = array();
        $db = Database::getInstance();

        include_once "app/core/Validator.php";

        if (!Validator::string($data['name'], 1, 50)) {
            $errors[''] = 'The Name is required.';
        }

        if (empty($errors)) {

            $DBdata = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'Address' => $data['address'],
                'nic' => $data['nic'],
                'id' => $data['id'],
            );

            $query = "update Clients set Name = :name,Email = :email,Phone = :phone,Address = :Address,NIC = :nic where id = :id";


            $result = $db->write($query, $DBdata);

            if ($result) {

                sweetAlert("Client Details Updated!", "");


                return array('success' => true);
            } else {
                return $errors;
            }
        } else {
            return $errors;
        }
    }



    public static function get_all()
    {

        $DB = Database::getInstance();
        return $DB->read("select * from Clients order by id desc");
    }

    public static function get_by_id($id)
    {

        $DB = Database::getInstance();
        return $DB->read("select * from Clients where id = :id", array('id' => $id));
    }

    public static function deleteClient($id)
    {

        $DB = Database::getInstance();
        $DBdata = array(
            'id' => $id
        );

        $query = "delete from Clients where id = :id";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
