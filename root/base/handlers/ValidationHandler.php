<?php

namespace Root\Base\Handlers;

class Validation
{
    public static function validate(array $requestArrays, array $validationArrays): object
    {
        $errorsArray = [];
        //available input Validation: email, mobile, date, europeanDate, integer, float, zipcode/postcode, ex: 'userName:email'
        foreach ($validationArrays as $validateArray) {
            $splitedValue = is_string($validateArray) ? explode(':', $validateArray) : [$validateArray];
            if (isset($requestArrays[$splitedValue[0]])) {
                $getValue = $requestArrays[$splitedValue[0]];
                if (self::isNotEmpty($getValue)) {
                    if (isset($splitedValue[1])) {
                        if ($splitedValue[1] == 'email' && !self::isValidEmail($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid";
                        } else if ($splitedValue[1] == 'mobile' && !self::isValidMobile($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid";
                        } else if ($splitedValue[1] == 'integer' && !self::isValidInteger($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid";
                        } else if ($splitedValue[1] == 'float' && !self::isValidFloat($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid";
                        } else if (($splitedValue[1] == 'zipcode' || $splitedValue[1] == 'postcode') && !self::isValidZipOrPostalCode($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid";
                        } else if ($splitedValue[1] == 'date' && !self::isValidDate($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid. Date must be YYYY-MM-DD";
                        } else if ($splitedValue[1] == 'europeanDate' && !self::isValidEuropeanDate($getValue)) {
                            $errorsArray[$splitedValue[0]] = "{$splitedValue[1]} is not valid. Date must be DD-MM-YYYY";
                        }
                    }
                } else {
                    $errorsArray[$splitedValue[0]] = 'value is required';
                }
            } else {
                $errorsArray[$splitedValue[0]] = 'field is required';
            }
        }
        if (count($errorsArray) !== 0) {
            return (object)['status' => false, 'error' => $errorsArray];
        } else {
            return (object)['status' => true, 'error' => null];
        }
    }

    public static function isNotEmpty($value)
    {
        return (!empty($value) || $value == 0) ? true : false;
    }
    public static function isValidEmail($value)
    {
        if (!self::isNotEmpty($value)) {
            return false;
        }

        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public static function isValidMobile($value)
    {
        if (!self::isNotEmpty($value)) {
            return false;
        }
        $pattern = "/^\+?[0-9\s\-\(\)]{7,20}$/";
        if (preg_match($pattern, $value)) {
            return true;
        }
        return false;
    }
    public static function isValidInteger($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) {
            return true;
        }
        return false;
    }
    public static function isValidFloat($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return true;
        }
        return false;
    }
    public static function isValidZipOrPostalCode($value)
    {
        if (!self::isNotEmpty($value)) {
            return false;
        }
        $pattern = "/^\d{6}$/";
        if (preg_match($pattern, $value)) {
            return true;
        }
        return false;
    }
    public static function isValidDate($value) //YYYY-MM-DD
    {
        if (!self::isNotEmpty($value)) {
            return false;
        }
        $pattern = "/^\d{4}-\d{2}-\d{2}$/";
        if (preg_match($pattern, $value)) {
            return true;
        }
        list($year, $month, $day) = explode('-', $value);
        return checkdate((int)$month, (int)$day, (int)$year);
    }
    public static function isValidEuropeanDate($value)  //DD-MM-YYYY
    {
        if (!self::isNotEmpty($value)) {
            return false;
        }
        $pattern = "/^\d{2}-\d{2}-\d{4}$/";
        if (preg_match($pattern, $value)) {
            return true;
        }
        list($day, $month, $year) = explode('-', $value);
        return checkdate((int)$month, (int)$day, (int)$year);
    }
}
