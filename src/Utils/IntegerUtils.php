<?php

namespace App\Utils;


class IntegerUtils {

    public static function checkId($id) {

        if (is_null($id))
            return false;

        if (!is_numeric($id))
            return false;

        if ($id < 1)
            return false;

        return true;
    }

    public static function checkNum($val) {

        if (is_null($val))
            return false;

        if (!is_numeric($val))
            return false;

        return true;
    }


    public static function checkPositiveNum($val) {

        if (is_null($val))
            return false;

        if (!is_numeric($val))
            return false;

        if ($val <= 0)
            return false;

        return true;
    }

    public static function checkZeroOrOne($num) {

        if (!is_numeric($num)) {
            return false;
        }

        if ($num != 0 && $num != 1) {
            return false;
        }

        return true;
    }

}
