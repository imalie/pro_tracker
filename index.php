<?php
//start session
session_start();
//gather errors
$loginValidation = array();

if (isset($_POST['submit'])) {
    //load the dbms configuration
    include 'config.inc.php';
    //check if e-mail address is empty or not
    if (empty($_POST["userEmail"])) {
        $error = true;
        $loginValidation['emailError'] = "Enter user email";
    }else {
        // check if e-mail address is well-formed
        if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $loginValidation['emailError'] = "Email is invalid";
        }
    }
    //check if password is empty
    if (empty($_POST["userPassword"])) {
        $error = true;
        $loginValidation['passwordError'] = "Enter password";
    }
    //validation for login form
    if (0 === count($loginValidation)){
        $userEmail = mysqli_real_escape_string($conn, $_POST["userEmail"]);
        //password encryption method with $userPassword variable
        $userPassword = md5(mysqli_real_escape_string($conn, $_POST['userPassword']));
        echo md5($userPassword);
        //check if user e-mail and user password is valid
        loginValid($conn, $userEmail, $userPassword);
    }
}

//define check e-mail and password function
function loginValid($conn, $userEmail, $userPassword){
    //define query variable and set the db query
    $dbQuery = "SELECT * FROM `users` WHERE email = '$userEmail' AND password = '$userPassword';";
    //get the result from db
    $dbResult = mysqli_query($conn, $dbQuery);
    //close the db connection
    mysqli_close($conn);

    if ($dbResult && mysqli_num_rows($dbResult) == 1) {
        $row = mysqli_fetch_assoc($dbResult);
        //set the user information to session
        $_SESSION['userID'] = $row['user_id'];
        $_SESSION['userFirstName'] = $row['first_name'];
        //redirect to system if user e-mali and password is valid
        pageRedirect("mod/dashboard.php");
    } else {
        //access denied
        global $loginValidation;
        $loginValidation['accessError'] = "Access denied";
    }
}
//define redirect function
function pageRedirect($path){
    header( 'Location: ' . $path );
    exit();
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Pro Tracker| Sign in</title>
        <meta charset="UTF-8">
    </head>
    <body class="hold-transition login-page" style="background-image: url(login_background.jpg);background-repeat:space; background-size: cover; margin-top: 11%";>
    <div class="login-box">
    <form method="post">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder=" Enter Email" name="userEmail"  required>
            <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            <input type="password" class="form-control"  placeholder="Password" name="userPassword" required/>
            </div>
            <div class="row">
                <div class="col-xs-8">
                         <label>
                        Remember Me
                        </label>
                        <input  type="checkbox" name="rem">
                </div>
                <div class="col-xs-4">
            <button type="submit" name="submit">Login</button>
            </div>
        </div>
    </form>
    
    
    
    
    
        <?php
        if (isset($_GET['signout'])) {
            if ($_GET['signout'] == "true") {
                showValidateMsg("Login Session: ", "You are now logged out.");
            }
        }
        if (!(0 === count($loginValidation))) {
            foreach ($loginValidation as $error){
                showValidateMsg("Warning: ", $error);
            }
        }
        function showValidateMsg($validateHeader, $validateBody){
            echo '<div class="">
                    <span class="">'.$validateHeader.'</span>
                    <span class="">'.$validateBody.'</span>
                  </div>';
        }
        ?>
        
    </body>
</html>
