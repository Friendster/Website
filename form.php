<?php

$usr = "";
$pass = "";
$usrErr = "";
$passErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["usr"])) {
        $usrErr = "Required";
    } else {
        $usr = sanitize_input($_POST["usr"]);
    }

    if(empty($_POST["pass"])) {
        $passErr = "Required";
    } else {
        $pass = sanitize_input($_POST["pass"]);
    }
}

function sanitize_input($data) {
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="row align-items-center justify-content-center">

    <div class="my-login-box col-md-6 col-lg-4">
        <h1>Enter Wonderland!</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
            <div class="form-group <?php if($usrErr != "") echo "has-danger";?>">
                <label class="form-control-label" for="usr">Unicorn name</label>
                <input type="text" class="form-control <?php if($usrErr != "") echo "form-control-danger";?>" id="usr" name="usr" value="<?php echo "$usr";?>">
                <div class="form-control-feedback" <?php if($usrErr === "") echo "hidden";?>>
                    <?php echo $usrErr;?>
                </div>
            </div>
            <div class="form-group <?php if($passErr != "") echo "has-danger";?>">
                <label class="form-control-label" for="pass">Secret Magical Password</label>
                <input type="password" class="form-control <?php if($passErr != "") echo "form-control-danger";?>" id="pass" name="pass" value="<?php echo "$pass";?>">
                <div class="form-control-feedback" <?php if($passErr === "") echo "hidden";?>>
                    <?php echo $passErr;?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <?php echo "<h2>Your Input:</h2> $usr <br> $pass";?>
    </div>
</div>
