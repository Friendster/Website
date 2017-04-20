<?php

include "../include/header.php";
include "../include/init.php";
include "googlerecapcha.php";


$user = '';
$pass = '';
$userError = '';
$passError = '';
$recapchaError = '';
$loginError = '';

if (isset($_POST["submit"])) {

    $is_user_valid = validate_user($_POST["usr"]);
    $is_pass_valid = validate_pass($_POST["pass"]);
    $is_recapcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

    if (!$is_recapcha_valid) {
        $recapchaError = "Please validate recapcha";
    }

    // If user input is ok so far then QUERY db
    if ($is_user_valid && $is_pass_valid && $is_recapcha_valid) {
        $db_user = db_get_user($user);

        $hashed_pw = $db_user->pass;
        if (!empty($hashed_pw) && password_verify($pass, base64_decode($hashed_pw))) {
            $_SESSION["name"] = $user;
            $_SESSION["user_id"] = $db_user->id;
            header("Location: ../index.php");
        } else {
            $loginError = "Username or password is wrong";
        }
    }

}

function validate_user($value) {
    global $userError, $user;
    $user = htmlspecialchars($value);

    $isValid = !empty($user);
    $userError = $isValid ? "" : "is required";

    return $isValid;
}

function validate_pass($value) {
    global $passError, $pass;
    $pass = htmlspecialchars($value);

    $isValid = !empty($pass);
    $passError = $isValid ? "" : "is required";

    return $isValid;
}

?>

    <div class="my-login-box panel panel-default">
        <div class="panel-body">

            <?php if (!empty($loginError)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginError</div>"; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
<!--                <fieldset>-->
                    <legend>Enter Wonderland!</legend>
                    <div class="form-group <?php echo !empty($userError) ? "has-error" : ""; ?>">
                        <label class="control-label" for="usr">Unicorn
                            name <?php if (!empty($userError)) echo $passError; ?></label>
                        <input type="text"
                               class="form-control <?php if (!empty($userError)) echo "form-control-danger"; ?>"
                               id="usr"
                               name="usr" value="<?php echo "$user"; ?>">
                    </div>
                    <div class="form-group <?php echo !empty($passError) ? "has-error" : ""; ?>">
                        <label class="control-label" for="pass">Secret Magical
                            Password <?php if (!empty($passError)) echo $passError; ?></label>
                        <input type="password"
                               class="form-control <?php if (!empty($passError)) echo "form-control-danger"; ?>"
                               id="pass"
                               name="pass" value="<?php echo "$pass"; ?>">
                    </div>


                    <div class="<?php echo empty($recapchaError) ? "" : "recapcha-error"; ?>">
                        <?php echo empty($recapchaError) ? "" : "<p class=\"text-danger\">$recapchaError</p>"; ?>
                        <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
                    </div>


                    <div class="form-buttons">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-default" href="register.php">Register?</a>
                    </div>
<!--                    <fieldset>-->
            </form>
        </div>
    </div>


<?php include "../include/footer.php"; ?>