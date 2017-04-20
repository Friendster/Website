<?php
/**
 * Created by PhpStorm.
 * User: Boris

 */

include "../include/header.php";
include "../include/init.php";

if (isset($_POST['submit']))
{
    // Connect to db
    $conn = connect_to_db();


    echo "TESTING THE SUBMIT" . "<br>";
    //assign user-provided data to variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Escape user input data
    $email = mysqli_escape_string($conn, $email);
    $password = mysqli_escape_string($conn, $password);

    echo $email. "<br>";
    echo $password . "<br>";

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
        <h1>Register for a magical journey :^)</h1>

        <?php if(!empty($loginMessage)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginMessage</div>"; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
            <div class="form-group">
                <label class="form-control-label" for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="">
            </div>


            <div class="form-group">
                <label class="form-control-label" for="pass">Secret Magical Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD" data-theme="dark"></div>

            <button type="submit" name="submit" class="btn btn-primary">Register</button>
            <a class="btn btn-default" href="login.php">Login</a>
        </form>

    </div>
</div>

<?php include "../include/footer.php";?>
