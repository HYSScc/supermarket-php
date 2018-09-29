<?php

namespace App;

class Helpers
{
    public static function popup($info) {
        echo "<script language=\"javascript\">alert(\"$info\");</script>";
    }

    public static function skip($location) {
        echo "<script language=\"javascript\">location.href=\"$location\"</script>";
        exit;
    }
}