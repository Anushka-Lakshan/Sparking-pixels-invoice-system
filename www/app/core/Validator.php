<?php

class Validator
{
    public static function string($value, $min = 1, $max = INF)
    {
        $value = trim($value);
        $value = self::sanitizeInput($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value)
    {
        $value = trim($value);
        $value = self::sanitizeInput($value);

        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function date($value, $minDate, $maxDate)
    {
        // Assuming $value is a string in the format "YYYY-MM-DD"
        $date = DateTime::createFromFormat('Y-m-d', $value);
        
        return $date !== false && $date >= new DateTime($minDate) && $date <= new DateTime($maxDate);
    }

    public static function time($value, $minTime, $maxTime)
    {
        // Assuming $value is a string in the format "HH:ii" (24-hour format)
        $time = DateTime::createFromFormat('H:i', $value);
        
        return $time !== false && $time >= DateTime::createFromFormat('H:i', $minTime) && $time <= DateTime::createFromFormat('H:i', $maxTime);
    }

    public static function password($value)
    {
        // Password must have more than 6 characters and meet certain criteria
        return strlen($value) > 6 && preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).+$/', $value);
    }




    public static function sanitizeInput($value)
    {
        

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = self::sanitizeInput($val);
            }
        } else {
            // Use htmlspecialchars to escape potentially dangerous characters
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }
}