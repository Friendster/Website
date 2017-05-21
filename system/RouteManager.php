<?php


class RouteManager {
    public static function navigate($query = "") {
        $root_location = (Config::$host != "localhost") ? "/" : "index.php" . $query;
        header("Location:" . $root_location);
    }
}