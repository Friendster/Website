<?php
/**
 * Created by PhpStorm.
 * User: Boris

 */

include "../include/header.php";
include "../include/db.php";

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
        'cost' => 11,
        'salt' => $salt,
    ];
    $hashed_pw = password_hash($password, PASSWORD_BCRYPT, $options);


    echo $hashed_pw . "<br>";




    //encrypt password with the db salt
    $password = crypt($password, $salt);

    //creation of variable with the information and db specifics to be injected into db
    $query = "INSERT INTO user (user, pass)";
    $query .= "VALUES('{$email}','{$password}')";

    //execution on the information injection into the db
    $register_user_query = mysqli_query($conn, $query);
    if (!$register_user_query)
    {
        die("Query failed!". mysqli_error($conn) . ' '. mysqli_errno($conn));
    }
}
?>

<div class="row align-items-center justify-content-center">
    <div class="my-login-box col-md-6 col-lg-4">
        <h1>Register for a magical journey :^)</h1>

        <?php if(!empty($loginMsg)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginMsg</div>"; ?>

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
        </form>

    </div>
</div>

<?php include "../include/footer.php";?>
