<?php

class Invoice
{


    public static function get_all()
    {

        $DB = Database::getInstance();
        return $DB->read("select * from Invoice order by id desc");
    }

    public static function add_invoice($client_id, $client_name, $invoice_name, $open_date, $last_edit_date, $items, $payments, $discount, $balance, $notes, $terms)
    {
        $DB = Database::getInstance();

        $DBdata = array(
            'client_id' => $client_id,
            'client_name' => $client_name,
            'invoice_name' => $invoice_name,
            'open_date' => $open_date,
            'last_edit_date' => $last_edit_date,
            'items' => $items,
            'payments' => $payments,
            'discount' => $discount,
            'balance' => $balance,
            'notes' => $notes,
            'terms' => $terms
        );

        $query = "INSERT INTO Invoice (client_id, client_name, invoice_name, open_date, last_edit_date, items, payments, discount, balance, notes, Terms) 
              VALUES (:client_id, :client_name, :invoice_name, :open_date, :last_edit_date, :items, :payments, :discount, :balance, :notes, :terms)";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            // Return the ID of the inserted record
            return $DB->getConnection()->lastInsertId();
        } else {
            return -1;
        }
    }




    public static function update_invoice($id, $invoice_name, $items, $payments, $discount, $balance, $notes, $terms)
    {
        $DB = Database::getInstance();

        $DBdata = array(
            'id' => $id,
            'invoice_name' => $invoice_name,
            'last_edit_date' => date('Y-m-d'),
            'items' => $items,
            'payments' => $payments,
            'discount' => $discount,
            'balance' => $balance,
            'notes' => $notes,
            'terms' => $terms
        );

        // $query = "UPDATE Invoice SET client_id=:client_id, client_name=:client_name, invoice_name=:invoice_name, open_date=:open_date, last_edit_date=:last_edit_date, items=:items, payments=:payments, discount=:discount, balance=:balance, notes=:notes, Terms=:terms where id=:id";

        $query = "UPDATE Invoice SET invoice_name=:invoice_name, last_edit_date=:last_edit_date, items=:items, payments=:payments, discount=:discount, balance=:balance, notes=:notes, Terms=:terms where id=:id";


        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }





    public static function get_by_id($id)
    {
        $DB = Database::getInstance();

        $query = "select Invoice.* from Invoice where Invoice.id = :id";
        $result = $DB->read($query, array('id' => $id));

        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
    public static function get_by_id_with_client($id)
    {
        $DB = Database::getInstance();

        $query = "select Invoice.*, Clients.* from Invoice inner join Clients on Invoice.client_id = Clients.id where Invoice.id = :id";
        $result = $DB->read($query, array('id' => $id));

        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    
    public static function get_by_client_id($id)
    {
        $DB = Database::getInstance();

        $query = "select Invoice.* from Invoice where Invoice.client_id = :id";
        $result = $DB->read($query, array('id' => $id));

        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public static function deleteInvoice($id)
    {

        $DB = Database::getInstance();
        $DBdata = array(
            'id' => $id
        );

        $query = "delete from Invoice where id = :id";

        $result = $DB->write($query, $DBdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
