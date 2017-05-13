<?php


function login($profile)
{
    session_start();

    // TODO refactor session name -> email

    // TODO encapsulate session into a session object
    $_SESSION["name"] = $profile->email;
    $_SESSION["user_id"] = $profile->id;
    $_SESSION["profile_picture_name"] = $profile->profile_picture_name;

    // TODO add other profile details

    set_location_to_root();
}

