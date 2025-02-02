<?php

class Setting
{
    public static function get_setting()
    {
        $DB = Database::getInstance();
        $settings = $DB->read("select * from Settings order by id asc");

        return $settings[0];
    }

    public static function edit_setting($Terms, $address, $phone, $email)
    {
        $DB = Database::getInstance();
        $DBdata = array(
            'terms' => $Terms,
            'address' => $address,
            'Tel' => $phone,
            'Email' => $email
        );

        $query = "update Settings set Terms = :terms, Address = :address, Tel = :Tel, Email = :Email where id = 1";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
