<?php
include_once '../config.inc.php';

$validateError = array();
$SubmitStatus = array();

if (isset($_POST['submit'])){

    if (empty($_POST['pro_owner_id'])){
        $validateError['pro_owner_id'] = "Pro owner id is empty";
    } else {
        $proOwnerId = $_POST['pro_owner_id'];
    }

    if (empty($_POST['pro_name'])){
        $validateError['pro_name'] = "Pro Name is empty";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['pro_name'])) {
            $validateError['pro_name'] = "Use the letter for pro name";
        } else { $proName = $_POST['pro_name']; }
    }

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
        $dbQuery = "INSERT INTO project(pro_owner_id,pro_name,address,geo_locate,approx_budget,start_date,end_date,plan_doc,boq_doc,release_user)
                    VALUES ('".$proOwnerId."','".$proName."','".$address."','".$geoLocation."','".$approxBudget."','".$startDate."','".$endDate."','".$planDocName."','".$boqDocName."','admin');";

        if (mysqli_query($conn, $dbQuery)){
            $SubmitStatus['dbStatus'] = "Submit success";
        }else {
            $SubmitStatus['dbError'] = "Update error to database";
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Project</title>

        <script>
            $(function() {
                $("#skill_input").autocomplete({
                    source: "search.php",
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#skill_input").val(ui.item.id);
                    }
                });
            });
        </script>
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <label>Project Name </label>
            <input type="text" name="pro_name" placeholder="Enter project name"><br>
            <label>Project Owner Name </label>
            <input type="text" name="pro_owner_id" id="skill_input" placeholder="Enter project owner"><br>
            <label>Address </label>
            <input type="text" name="address" placeholder="Enter address"><br>
            <label>Geo Location </label>
            <input type="text" name="geo_location" placeholder="Enter geo location"><br>
            <label>Approximated Budget </label>
            <input type="text" name="approx_budget" placeholder="Enter approximated budget"><br>
            <label>Advance Payment </label>
            <input type="text" name="advance_payment" placeholder="Enter advance payment"><br>
            <label>Start Date </label>
            <input type="date" name="start_date"><br>
            <label>End Date </label>
            <input type="date" name="end_date"><br>
            <label>Plan Document </label>
            <input type="file" name="plan_doc"><br>
            <label>BOQ Document </label>
            <input type="file" name="boq_doc"><br>
            <label>BOQ Document2 </label>
            <input type="file" name="boq_doc"><br>
            <input type="submit" name="submit" value="submit">
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
    </body>
</html>