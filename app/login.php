<?php

include "../include/header.php";
include "../include/init.php";
include "googlerecapcha.php";


$usr = "";
$pass = "";
$usrErr = "";
$passErr = "";
$recapchaErr = "";
$loginMsg = "";

if (isset($_POST["submit"])) {

    $is_recapcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

    if (!$is_recapcha_valid) {
        $recapchaErr = "Please validate recapcha";
    }

//    is_valid_user($_POST["usr"]);
//    is_valid_pass($_POST["pass"]);

    if (empty($_POST["usr"])) {
        $usrErr = "is required";
    } else {
        $usr = sanitize_input($_POST["usr"]);
    }



    if (empty($_POST["pass"])) {
        $passErr = "is required";
    } else {
        $pass = sanitize_input($_POST["pass"]);
    }


    // If user input is ok so far then QUERY db
    if ($usrErr === "" && $passErr === "") {

        // Connect to db
        $conn = connect_to_db();

        //http://php.net/manual/en/mysqli-stmt.get-result.php

        $sql = "SELECT * FROM `user` WHERE `user`='$usr'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row["user"], "______", $row["pass"];

            $hashed_pw = $row["pass"];
//            if (password_verify('q', base64_decode('JDJ5JDExJC5mSnlCRkZjQVZIRzMyeUxN'))) {
            if (password_verify($pass, base64_decode($hashed_pw)) && $is_recapcha_valid) {
                echo "USR" . $row["user"];
                $_SESSION["name"] = $row["user"];
                echo "SESSION" . $_SESSION["name"];
                header("Location: ../index.php");

            }
        } else {
            $loginErr = "Something went wrong";
        }

        $conn->close();
    }
}

function is_valid_user($user) {
    if (empty($user)) {
        $usrErr = "is required";
    } else {
        $usr = sanitize_input($user);
    }
    return $usrErr;
}

function is_valid_pass($pass) {
    if (empty($pass)) {
        $passErr = "is required";
    } else {
        $pass = sanitize_input($pass);
    }
    return $passErr;
}

function sanitize_input($data) {
    $data = htmlspecialchars($data);
    return $data;
}

?>

    <div class="my-login-box">

        <?php if (!empty($loginMsg)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginMsg</div>"; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
            <fieldset>
                <legend>Enter Wonderland!</legend>
                <div class="form-group <?php echo !empty($usrErr) ? "has-error" : ""; ?>">
                    <label class="control-label" for="usr">Unicorn
                        name <?php if (!empty($usrErr)) echo $passErr; ?></label>
                    <input type="text"
                           class="form-control <?php if (!empty($usrErr)) echo "form-control-danger"; ?>" id="usr"
                           name="usr" value="<?php echo "$usr"; ?>">
                </div>
                <div class="form-group <?php echo !empty($passErr) ? "has-error" : ""; ?>">
                    <label class="control-label" for="pass">Secret Magical
                        Password <?php if (!empty($passErr)) echo $passErr; ?></label>
                    <input type="password"
                           class="form-control <?php if (!empty($passErr)) echo "form-control-danger"; ?>" id="pass"
                           name="pass" value="<?php echo "$pass"; ?>">
                </div>


                <div class="<?php echo empty($recapchaErr) ? "" : "recapcha-error"; ?>">
                    <?php echo empty($recapchaErr) ? "" : "<p class=\"text-danger\">$recapchaErr</p>"; ?>
                    <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"
                         data-theme="dark"></div>
                </div>


                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    <a class="btn btn-default" href="register.php">Register?</a>
                </div>
                <fieldset>
        </form>

    </div>


<?php include "../include/footer.php"; ?>