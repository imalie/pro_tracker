<?php
include_once 'admin-head.php';
include_once '../config.inc.php';

$validateError = array();
$SubmitStatus = array();

if (isset($_POST['submit'])){
    if (empty($_POST['surname'])){ $validateError['surname'] = "surname is empty";} else { $surname = $_POST['surname'];}
    if (empty($_POST['firstName'])){ $validateError['firstName'] = "first name is empty";} else { $firstName = $_POST['firstName'];}
    if (empty($_POST['lastName'])){ $validateError['lastName'] = "last name is empty";} else { $lastName = $_POST['lastName'];}
    if (empty($_POST['nic'])){ $validateError['nic'] = "nic is empty";} else { $nic = $_POST['nic'];}
    if (empty($_POST['gender'])){ $validateError['gender'] = "gender is empty";} else { $gender = $_POST['gender'];}

    if (empty($_POST["email"])) {
        $validateError['email'] = "Enter user email";
    }else {
        // check if e-mail address is well-formed
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $validateError['email'] = "Email is invalid";
        }else { $email = $_POST['email'];}
    }

    if (empty($_POST['password'])){
        $validateError['password'] = "password is empty";
    } else {
        if (empty($_POST['confirmPass'])){
            $validateError['confirmPass'] = "confirmPass is empty";
        }else {
            $password = md5($_POST['password']);
            $confirmPass = md5($_POST['confirmPass']);
            if ($password != $confirmPass){$validateError['confirmError'] = "password confirm error";}
        }
    }

    if (0 === count($validateError)){
        $dbQuery = "INSERT INTO customer (surname, first_name, last_name, nic, gender, email, user_registered) 
                    VALUES ('".$surname."', '".$firstName."','".$lastName."', '".$nic."','".$gender."','".$email."','');";
        $dbQuery .= "INSERT INTO users(first_name, last_name, email, password, user_type, user_registered)
                    VALUES ('".$firstName."','".$lastName."','".$email."','".$password."','customer','');";

        if (mysqli_multi_query($conn, $dbQuery)){
            $SubmitStatus['dbStatus'] = "Submit success";
        }else {
            $SubmitStatus['dbError'] = "Update error to database";
        }
    }
}
?>
<h1>Add Customer <small>Create new victim account</small></h1>
<form class="" method="post">
    <div class="">
        <h4>Customer Info</h4>
    </div>
    <div class="">
        <input type="text" name="surname" placeholder="Surname">
        <input type="text" name="firstName" placeholder="First Name">
        <input type="text" name="lastName" placeholder="Last Name">
        <input type="text" name="nic" placeholder="NIC">
        <label>Gender</label>
        <div class="">
            <input type="radio" name="gender" value="male" checked> <p>Male</p>
            <input type="radio" name="gender" value="female"> <p>Female</p>
        </div>
        <label>Birthday</label>
        <input type="text" name="email" placeholder="email">
        <input type="text" name="password" placeholder="password">
        <input type="text" name="confirmPass" placeholder="Confirm Password">
        <div class="">
            <button type="submit" name="submit" value="submit">Submit</button>
        </div>
        <?php
        if (!(0 === count($validateError))){
            foreach ($validateError as $error){
                showSubmitValidationMsg("Warning",$error);
            }
        }
        if (!(0 === count($SubmitStatus))){
            foreach ($SubmitStatus as $status){
                showSubmitValidationMsg("Status",$status);
            }
        }
        function showSubmitValidationMsg($validationHeader, $validationBody) {
            echo '<div class="">
                    <span class="">'.$validationHeader.':&nbsp;</span>
                    <span class="">&nbsp;'.$validationBody.'</span>
                  </div>';
        }
        ?>
    </div>
</form>
<?php include_once 'admin-footer.php';?>