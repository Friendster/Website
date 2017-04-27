<?php


function login($email, $id)
{
    session_start();

    // TODO refactor session name -> email
    $_SESSION["name"] = $email;
    $_SESSION["user_id"] = $id;
    set_location_to_root();
}

