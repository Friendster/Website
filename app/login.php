<?php

include "../include/header.php";
include "../include/db.php";

$usr = "";
$pass = "";
$usrErr = "";
$passErr = "";
$loginMsg = "";

if(isset($_POST["submit"])) {

    //echo "RECAPCHA response " . $_POST["g-recaptcha-response"];

    g_recaptcha($_POST["g-recaptcha-response"]);

    if (empty($_POST["usr"])) {
        $usrErr = "Required";
    } else {
        $usr = sanitize_input($_POST["usr"]);
    }

    if (empty($_POST["pass"])) {
        $passErr = "Required";
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
            echo $row["user"], $row["pass"];

            if (password_verify($pass, $row["pass"])) {
//            if($pass === $row["pass"]) {
                $loginMsg = "SUCCESSFUL LOGIN!";
            } else {
                $passErr = "Wrong password";
                $loginMsg = $passErr;
            }

        } else {
            $usrErr = "Inexistent user";
            $loginMsg = $usrErr;
        }

        $conn->close();
    }
}

function sanitize_input($data) {
    $data = htmlspecialchars($data);
    return $data;
}


function g_recaptcha($response) {
    $secret = "6LcpFBoUAAAAALNJMzRqz3XcQHW3XHl_IpC11xeU";

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secret,
        'response' => $response
    );
    $options = array(
        'http' => array (
            'method' => 'POST',
            'header'=>"Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);
    if ($captcha_success->success==false) {
        echo "<p>You are a bot! Go away!</p>";
    } else if ($captcha_success->success==true) {
        echo "<p>You are not a bot!</p>";
    }
}
?>

<div class="row align-items-center justify-content-center">
    <div class="my-login-box col-md-6 col-lg-4">
        <h1>Enter Wonderland!</h1>

        <?php if(!empty($loginMsg)) echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> $loginMsg</div>"; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
            <div class="form-group <?php if(!empty($usrErr)) echo "has-danger";?>">
                <label class="form-control-label" for="usr">Unicorn name</label>
                <input type="text" class="form-control <?php if(!empty($usrErr)) echo "form-control-danger";?>" id="usr" name="usr" value="<?php echo "$usr";?>">
                <div class="form-control-feedback" <?php if(empty($usrErr)) echo "hidden";?>>
                    <?php echo $usrErr;?>
                </div>
            </div>
            <div class="form-group <?php if(!empty($passErr)) echo "has-danger";?>">
                <label class="form-control-label" for="pass">Secret Magical Password</label>
                <input type="password" class="form-control <?php if(!empty($passErr)) echo "form-control-danger";?>" id="pass" name="pass" value="<?php echo "$pass";?>">
                <div class="form-control-feedback" <?php if(empty($passErr)) echo "hidden";?>>
                    <?php echo $passErr;?>
                </div>
            </div>

            <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD" data-theme="dark"></div>

            <a class="btn btn-default" href="app/register.php">Register?</a>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>

    </div>
</div>

<?php include "../include/footer.php";?>