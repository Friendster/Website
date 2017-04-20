<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 3/7/2017
 * Time: 22:14
 */
include "include/header.php";
include "include/db.php";


$conn = connect_to_db();

$sql = "SELECT * FROM `user`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo $row["user"] . '<br>' . $row["pass"] . '<br>';
    }

    //if (password_verify($pass, $row["pass"])) {
}


include "include/footer.php";