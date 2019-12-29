<?php
include_once '../mod/admin-head.php';
include_once '../config.inc.php';

$validateError = array();
$SubmitStatus = array();

if (isset($_POST['update'])){
    if (empty($_POST['address'])){
        $validateError['address'] = "address is empty";
    } else { $address = $_POST['address'];}

    if (empty($_POST['geo_location'])){
        $validateError['geo_location'] = "address is empty";
    } else { $geoLocation = $_POST['geo_location'];}

    if (empty($_POST['approx_budget'])){
        $validateError['approx_budget'] = "approx budget is empty";
    } else {
        if (is_numeric($_POST['approx_budget'])){
            $approxBudget = $_POST['approx_budget'];
        }else { $validateError['approx_budget'] = "approx budget is invalid"; }
    }

    if (empty($_POST['advance_payment'])){
        $validateError['advance_payment'] = "advance payment is empty";
    } else {
        if (is_numeric($_POST['advance_payment'])){
            $advancePayment = $_POST['advance_payment'];
        }else { $validateError['advance_payment'] = "advance payment is invalid"; }
    }

    if (empty($_POST['start_date'])){
        $validateError['start_date'] = "start date is empty";
    } else {
        $startDate = $_POST['start_date'];
    }

    if (empty($_POST['end_date'])){
        $validateError['end_date'] = "end date is empty";
    } else {
        $endDate = $_POST['end_date'];
    }

    if (!($_FILES['plan_doc']['name'] == null)){
        $fileExt = explode('.', $_FILES['plan_doc']['name']);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('pdf');
        if (!(in_array($fileActualExt, $allowed))){$validateError['planDocError1'] = "Can not upload format of this file"; }
        if (!($_FILES['plan_doc']['error'] == 0)){$validateError['planDocError2'] = "There are some error this file"; }
        if ($_FILES['plan_doc']['size'] > 1000000){$validateError['planDocError3'] = "File size long of this file"; }
        if (0 === count($validateError)){
            $fileNewName = uniqid('',true).".".$fileActualExt;
            $fileDestination = '../file/'.$fileNewName;
            //image upload code and update upload status
            if(move_uploaded_file($_FILES['plan_doc']['tmp_name'], $fileDestination)){
                $SubmitStatus['planDocStatus'] = "Upload success to system";
            } else {
                $validateError['planDocError4'] = "plan file upload error";
            }
        }
        $planDocName = $fileNewName;
    } else {
        $validateError['planDocError1'] = "Select plan document";
    }

    if (!($_FILES['boq_doc']['name'] == null)){
        $fileBoqExt = explode('.', $_FILES['boq_doc']['name']);
        $fileBoqActualExt = strtolower(end($fileBoqExt));
        $boqAllowed = array('pdf');
        if (!(in_array($fileBoqActualExt, $boqAllowed))){$validateError['boqDocError1'] = "Can not upload format of this file"; }
        if (!($_FILES['boq_doc']['error'] == 0)){$validateError['boqDocError2'] = "There are some error this file"; }
        if ($_FILES['boq_doc']['size'] > 1000000){$validateError['boqDocError3'] = "File size long of this file"; }
        if (0 === count($validateError)){
            $fileBoqNewName = uniqid('',true).".".$fileBoqActualExt;
            $fileBoqDestination = '../file/'.$fileBoqNewName;
            //image upload code and update upload status
            if(move_uploaded_file($_FILES['boq_doc']['tmp_name'], $fileBoqDestination)){
                $SubmitStatus['boqDocStatus'] = "Upload success to system";
            } else {
                $validateError['boqDocError4'] = "boq file upload error";
            }
        }
        $boqDocName = $fileBoqNewName;
    } else {
        $validateError['boqDocError1'] = "Select boq document";
    }

    if (0 === count($validateError)){
        $dbQuery = "";

        if (mysqli_query($conn, $dbQuery)){
            $SubmitStatus['dbStatus'] = "Submit success";
        }else {
            $SubmitStatus['dbError'] = "Update error to database";
        }
        //close the db connection
        mysqli_close($conn);
    }
}

$detail_id = $_GET['id'];

$id = $proOwnerId = $proName = $address = $geoLocate = $approxBudget = $advancePayment = $startDate = $endDate = $planDoc = $boqDoc = $releaseDate = "";
$releaseUser = "";

getUserInfo($conn);
function getUserInfo($conn) {
    global $detail_id,$id,$proOwnerId,$proName,$address,$geoLocate,$approxBudget,$advancePayment,$startDate,$endDate,$planDoc,$boqDoc,$releaseDate,$releaseUser;
    //define db query
    $dbSelectQuery = "SELECT * FROM `project` WHERE `id`='".$detail_id."';";
    //get the result from db
    if ($dbResult = mysqli_query($conn, $dbSelectQuery)) {
        $row = mysqli_fetch_assoc($dbResult);
        //define variable and set value
        $id = $row['id'];
        $proOwnerId = $row['pro_owner_id'];
        $proName = $row['pro_name'];
        $address = $row['address'];
        $geoLocate = $row['geo_locate'];
        $approxBudget = $row['approx_budget'];
        $advancePayment = $row['advance_payment'];
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $planDoc = $row['plan_doc'];
        $boqDoc = $row['boq_doc'];
        $releaseDate = $row['release_date'];
        $releaseUser = $row['release_user'];
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <label>Project Name </label>
    <input type="text" name="pro_name" value="<?php echo $proName; ?>" disabled><br>
    <label>Project Owner Name </label>
    <input type="text" name="pro_owner_id" value="<?php echo $proOwnerId; ?>" disabled><br>
    <label>Address </label>
    <input type="text" name="address" placeholder="Enter address" value="<?php echo $address; ?>"><br>
    <label>Geo Location </label>
    <input type="text" name="geo_location" placeholder="Enter geo location" value="<?php echo $geoLocate; ?>"><br>
    <label>Approximated Budget </label>
    <input type="text" name="approx_budget" placeholder="Enter approximated budget" value="<?php echo $approxBudget; ?>"><br>
    <label>Advance Payment </label>
    <input type="text" name="advance_payment" placeholder="Enter advance payment" value="<?php echo $advancePayment; ?>"><br>
    <label>Start Date </label>
    <input type="date" name="start_date" value="<?php echo $startDate; ?>"><br>
    <label>End Date </label>
    <input type="date" name="end_date" value="<?php echo $endDate; ?>"><br>
    <label>Plan Document </label>
    <input type="file" name="plan_doc"><br>
    <a href="../file/<?php echo $planDoc; ?>">Go to Plan Document</a><br>
    <label>BOQ Document </label>
    <input type="file" name="boq_doc"><br>
    <a href="../file/<?php echo $boqDoc; ?>">Go to BOQ Document</a><br>
    <label>Release Date: <?php echo $releaseDate; ?></label><br>
    <label>Release User: <?php echo $releaseUser; ?></label><br>
    <input type="submit" name="update" value="Update">
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
</form>
<?php include_once '../mod/admin-footer.php'?>