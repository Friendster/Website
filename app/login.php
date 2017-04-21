<?php


function login($email, $id){
    session_start();
    $_SESSION["name"] = $email;
    $_SESSION["user_id"] = $id;
    header("Location: ../index.php");
}

