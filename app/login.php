<?php

include "../include/header.php";
include "../include/init.php";
include "googlerecaptcha.php";


$email = '';
$password = '';
$email_error = '';
$password_error = '';
$recaptcha_error = '';

$login_error = '';


if (isset($_POST["submit"])) {

    $is_user_valid = validate_user($_POST["usr"]);
    $is_pass_valid = validate_pass($_POST["pass"]);
    $is_recaptcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

    if (!$is_recaptcha_valid) {
        $recaptcha_error = "Please validate recapcha";
    }

    // If user input is ok so far then QUERY db
    if ($is_user_valid && $is_pass_valid && $is_recaptcha_valid) {
        $db_user = db_get_user($email);

        $hashed_pw = $db_user->pass;
        if (!empty($hashed_pw) && password_verify($password, base64_decode($hashed_pw))) {
            $_SESSION["name"] = $email;
            $_SESSION["user_id"] = $db_user->id;
            header("Location: ../index.php");
        } else {
            $login_error = "Username or password is wrong";
        }
    }

}

function validate_user($value)
{
    global $email_error, $email;
    $email = htmlspecialchars($value);

    $isValid = !empty($email);
    $email_error = $isValid ? "" : "is required";

    return $isValid;
}

function validate_pass($value)
{
    global $password_error, $password;
    $password = htmlspecialchars($value);

    $isValid = !empty($password);
    $password_error = $isValid ? "" : "is required";

    return $isValid;
}

?>

    <div class="my-login-box panel panel-default">
        <div class="panel-body">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                <legend>Enter Wonderland!</legend>

                <?php if (!empty($login_error)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $login_error</div>"; ?>

                <div class="form-group <?php echo !empty($email_error) ? "has-error" : ""; ?>">
                    <label class="control-label" for="usr">Unicorn email
                        <?php if (!empty($email_error)) echo $password_error; ?></label>
                    <input type="text"
                           class="form-control <?php if (!empty($email_error)) echo "form-control-danger"; ?>"
                           id="usr"
                           name="usr" value="<?php echo "$email"; ?>">
                </div>
                <div class="form-group <?php echo !empty($password_error) ? "has-error" : ""; ?>">
                    <label class="control-label" for="pass">Secret Magical
                        Password <?php if (!empty($password_error)) echo $password_error; ?></label>
                    <input type="password"
                           class="form-control <?php if (!empty($password_error)) echo "form-control-danger"; ?>"
                           id="pass"
                           name="pass" value="<?php echo "$password"; ?>">
                </div>


                <div class="<?php echo empty($recaptcha_error) ? "" : "recapcha-error"; ?>">
                    <?php echo empty($recaptcha_error) ? "" : "<p class=\"text-danger\">$recaptcha_error</p>"; ?>
                    <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    <a class="btn btn-default" href="register.php">Register?</a>
                </div>

            </form>
        </div>
    </div>


<?php include "../include/footer.php"; ?>