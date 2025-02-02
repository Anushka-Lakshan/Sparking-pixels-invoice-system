<?php

class Dashboard
{
    public static function outstanding()
    {
        $DB = Database::getInstance();
        $query = "SELECT SUM(CAST(REPLACE(balance, ',', '') AS DECIMAL(10, 2))) AS total_balance
        FROM Invoice;";

        $result = $DB->read($query);

        return $result[0]['total_balance'];
    }


    public static function Payments()
    {
        $DB = Database::getInstance();
        $query = "SELECT SUM(CAST(json_extract(value, '$.amount') AS INTEGER)) AS total_payments
        FROM Invoice, json_each(Invoice.payments)";

        $result = $DB->read($query);

        return $result[0]['total_payments'];
    }

    
    public static function getClientCount()
    {
        $DB = Database::getInstance();
        $query = "SELECT COUNT(*) AS total_clients FROM Clients";

        $result = $DB->read($query);

        return $result[0]['total_clients'];
    }

    public static function getInvoiceCount()
    {
        $DB = Database::getInstance();
        $query = "SELECT COUNT(*) AS total_invoices FROM Invoice";

        $result = $DB->read($query);

        return $result[0]['total_invoices'];
    }


    public static function getPayments()
    {
        $DB = Database::getInstance();
        $query = "SELECT 
        Invoice.client_id AS client_id,
        Invoice.Invoice_name AS Invoice_name,
        Clients.Name,
        Invoice.id,
        json_extract(value, '$.name') AS payment_name,
        CAST(json_extract(value, '$.amount') AS INTEGER) AS amount,
        json_extract(value, '$.date') AS payment_date
    FROM 
        Invoice,
        json_each(Invoice.payments)
    INNER JOIN Clients ON Invoice.client_id = Clients.id
    ORDER BY 
        datetime(json_extract(value, '$.date')) DESC;
    ";

        $result = $DB->read($query);

        return $result;
    }


    public static function chart_data()
    {
        $DB = Database::getInstance();
        $query = "SELECT 
        strftime('%Y-%m', date(json_extract(value, '$.date'))) AS month,
        SUM(CAST(json_extract(value, '$.amount') AS INTEGER)) AS amount_sum
    FROM 
        Invoice,
        json_each(Invoice.payments)
    WHERE 
        date(json_extract(value, '$.date')) <= date('now')  -- Consider only past months
    GROUP BY 
        strftime('%Y-%m', date(json_extract(value, '$.date')))
    ORDER BY 
        strftime('%Y-%m', date(json_extract(value, '$.date'))) DESC;
    
    ";

        $result = $DB->read($query);

        return $result;
    }


    
}
