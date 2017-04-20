<?php
/**
 * Created by PhpStorm.
 * User: Boris

 */

include "../include/header.php";
include "../include/init.php";
include "googlerecapcha.php";

$recapchaError = '';
$emailError = '';
$passwordError ='';
$v_passwordError ='';

if (isset($_POST['submit']))
{
    $is_recapcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

    if (!$is_recapcha_valid) {
        $recapchaError = "Please validate recapcha";
    }

    // Connect to db
    $conn = connect_to_db();


    echo "TESTING THE SUBMIT" . "<br>";
    //assign user-provided data to variables
    $email = $_POST['email'];
    $password = $_POST['password'];
    $v_password =$_POST['v_password'];

    // Escape user input data
    $email = mysqli_escape_string($conn, $email);
    $password = mysqli_escape_string($conn, $password);
    $v_password = mysqli_escape_string($conn, $v_password);

    echo $email. "<br>";
    echo $password . "<br>";
    echo $v_password . "<br>";

    //checks to see if user input is a valid email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailError = "Provided email address is NOT considered valid.\n";
    }

    //checks if the two user password input match and  if they meet password requirements
    if(!empty($password) && ($password == $v_password)) {

        if (strlen($password) <= '8') {
            $passwordError = "Your Password Must Contain At Least 8 Characters!";
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    } elseif(!empty($password)) {
        $v_passwordError = "Please Check You've Entered Or Confirmed Your Password!";
    }

        $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        echo $salt. "<br>";

        $options = [
            'cost' => 11
        ];
        $hashed_pw = password_hash($password, PASSWORD_BCRYPT, $options);
        $hashed_pw = base64_encode($hashed_pw);
        echo password_verify($password, base64_encode($hashed_pw));
        if(password_verify($password, base64_decode($hashed_pw))){
            echo"This Pineapple";
        }
        echo $hashed_pw . "<br>";

        // TODO ADD TO DB AS METHOD
        //creation of variable with the information and db specifics to be injected into db
        $query = "INSERT INTO user (email, pass) VALUES(?, ?)";

        $stmt = $conn->stmt_init();


        if(!$stmt->prepare($query))
        {
            print "Failed to prepare statement\n";
        }
        else
        {

            $stmt->bind_param('ss', $email, $hashed_pw);

            //execution on the information injection into the db
            $stmt->execute();

        }

        $stmt->close();
        $conn->close();
    }

?>

<div class="row align-items-center justify-content-center">
    <div class="my-login-box col-md-6 col-lg-4">
        <h1>Register for Friendster!</h1>

        <?php if(!empty($loginMessage)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginMessage</div>"; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
            <div class="form-group <?php echo empty($emailError) ? "" : "email-error"; ?>">
                <?php echo empty($emailError) ? "" : "<p class=\"text-danger\">$emailError</p>"; ?>
                <label class="form-control-label" for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="">
            </div>

            <div class="form-group <?php echo empty($passwordError) ? "" : "password-error"; ?>">
                <?php echo empty($passwordError) ? "" : "<p class=\"text-danger\">$passwordError</p>"; ?>
                <label class="form-control-label" for="pass">Secret Magical Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group <?php echo empty($v_passwordError) ? "" : "v_password-error"; ?>">
                <?php echo empty($v_passwordError) ? "" : "<p class=\"text-danger\">$v_passwordError</p>"; ?>
                <label class="form-control-label" for="ver_pass">Verify Magical Password</label>
                <input type="password" class="form-control" id="v_password" name="v_password">
            </div>

            <div class="<?php echo empty($recapchaError) ? "" : "recapcha-error"; ?>">
                <?php echo empty($recapchaError) ? "" : "<p class=\"text-danger\">$recapchaError</p>"; ?>
                <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Register</button>
            <a class="btn btn-default" href="login.php">Login</a>
        </form>

    </div>
</div>

<?php include "../include/footer.php";?>
