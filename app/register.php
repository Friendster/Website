<?php
/**
 * Created by PhpStorm.
 * User: Boris
 */

include "../include/header.php";
include "../include/init.php";
include "googlerecaptcha.php";


$email = '';
$password = '';
$verify_password = '';

$recapcha_error = '';
$email_error = '';
$password_error = '';
$verify_password_error = '';

if (isset($_POST['submit'])) {

    $is_email_valid = process_email($_POST["email"]);
    $is_password_valid = process_password($_POST["password"]);
    $is_verify_password_valid = process_verify_password($_POST["verify_password"]);
    $is_recaptcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

    if (!$is_recaptcha_valid) {
        $recapcha_error = "Please validate recapcha";
    }



    echo "TESTING THE SUBMIT" . "<br>";


    echo $email . "<br>";
    echo $password . "<br>";
    echo $verify_password . "<br>";


    if ($is_email_valid && $is_password_valid && $is_recaptcha_valid) {
     // TODO add next stuff here
    }

    // Connect to db
    $conn = connect_to_db();

    $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    echo $salt . "<br>";

    $options = [
        'cost' => 11
    ];
    $hashed_pw = password_hash($password, PASSWORD_BCRYPT, $options);
    $hashed_pw = base64_encode($hashed_pw);
    echo password_verify($password, base64_encode($hashed_pw));
    if (password_verify($password, base64_decode($hashed_pw))) {
        echo "This Pineapple";
    }
    echo $hashed_pw . "<br>";

    // TODO ADD TO DB AS METHOD
    //creation of variable with the information and db specifics to be injected into db
    $query = "INSERT INTO user (email, pass) VALUES(?, ?)";

    $stmt = $conn->stmt_init();


    if (!$stmt->prepare($query)) {
        print "Failed to prepare statement\n";
    } else {

        $stmt->bind_param('ss', $email, $hashed_pw);

        //execution on the information injection into the db
        $stmt->execute();

    }

    $stmt->close();
    $conn->close();
}


function process_email($value) {
    global $email_error, $email;
    $email_error = "";

    // Sanatise
    $email = htmlspecialchars($value);

    // Validate not empty
    if(empty($email)) {
        $email_error = "is required";
    }

    // Checks to see if user input is a valid email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "is NOT valid!";
    }

    // TODO check with db wheter is already registered

    // Is valid if there is no error
    return empty($email_error);
}

function process_password($value) {
    global $password_error, $password;
    $password_error = "";

    // Sanatise
    $password = htmlspecialchars($value);

    // Validate not empty
    if (empty($password)) {
        $password_error = "is required";
    }
    // TODO add comments
    elseif (strlen($password) < '8') {
        $password_error = "must contain at least 8 characters!";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $password_error = "must contain at least 1 number!";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $password_error = "must contain at least 1 capital letter!";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $password_error = "must contain at least 1 lowercase letter!";
    }

    // Is valid if there is no error
    return empty($password_error);
}

function process_verify_password($value) {
    global $verify_password_error, $verify_password, $password;

    // Sanatise
    $verify_password = htmlspecialchars($value);

    // Validate not empty
    if (empty($verify_password)) {
        $verify_password_error = "is required";
    }

    // Checks if the two user password input match
    if ($password !== $verify_password) {
        $verify_password_error = " must match password";
    }

    return empty($verify_password_error);
}
?>

<div class="my-login-box panel panel-default">
    <div class="panel-body">

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">

            <legend>Register for Friendster!</legend>

            <div class="form-group <?php echo !empty($email_error) ? "has-error" : ""; ?>">
                <label class="control-label" for="email">
                    Email <?php if (!empty($email_error)) echo $email_error; ?>
                </label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo "$email"; ?>">
            </div>

            <div class="form-group <?php echo !empty($password_error) ? "has-error" : ""; ?>">
                <label class="control-label" for="pass">
                    Secret Magical Password <?php if (!empty($password_error)) echo $password_error; ?>
                </label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo "$password"; ?>">
            </div>

            <div class="form-group <?php echo !empty($verify_password_error) ? "has-error" : ""; ?>">
                <label class="control-label" for="ver_pass">
                    Verify Magical Password <?php if (!empty($verify_password_error)) echo $verify_password_error; ?>
                </label>
                <input type="password" class="form-control" id="verify_password" name="verify_password" value="<?php echo "$verify_password";?>">
            </div>

            <div class="<?php echo empty($recapcha_error) ? "" : "recapcha-error"; ?>">
                <?php echo empty($recapcha_error) ? "" : "<p class=\"text-danger\">$recapcha_error</p>"; ?>
                <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Register</button>
            <a class="btn btn-default" href="login.php">Login</a>
        </form>

    </div>
</div>

<?php include "../include/footer.php"; ?>
