<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "usbw";
$dbDatabase = "bfc";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

$dataset_count = count($_POST['data_set']);

$validate = false;
$pro_id = null;
for ($i = 0; $i < $dataset_count; $i++) {
    if ($_POST['data_set'][$i]['type'] == "payment") {
        $dbQueryStage = "INSERT INTO payment (customer_id, project_id, amount, release_user) VALUES ('".$_POST['data_set'][$i]['cus_id']."','".$_POST['data_set'][$i]['pro_id']."','".$_POST['data_set'][$i]['payment']."','admin');";
        if ($dbResult = mysqli_query($conn, $dbQueryStage)){
            $pro_id = $_POST['data_set'][$i]['pro_id'];
            $validate = true;
            $dbQueryStage = "UPDATE project SET in_paid_state = '1' WHERE id = '".$_POST['data_set'][$i]['pro_id']."';";
            if ($dbResult = mysqli_query($conn, $dbQueryStage)){
                $validate = true;
            }else{$validate = false;}
        } else {
            $validate = false;
        }
    }
    if ($_POST['data_set'][$i]['type'] == "outstanding") {
        $dbQueryStage = "UPDATE stages SET outstanding = outstanding - ".$_POST['data_set'][$i]['out']." WHERE stage_id = '".$_POST['data_set'][$i]['stage_id']."';";
        if ($dbResult = mysqli_query($conn, $dbQueryStage)){$validate = true;} else {$validate = false;}
    }
}
if ($validate == true){
    $dbQueryStage = "SELECT SUM(stages.outstanding) FROM stages WHERE stages.pro_id = '".$pro_id."' GROUP BY stages.pro_id;";
    if ($dbResult = mysqli_query($conn, $dbQueryStage)){
        if (mysqli_num_rows($dbResult) > 0){
            $row = mysqli_fetch_assoc($dbResult);
            if ($row['SUM(stages.outstanding)'] == 0){
                $dbQueryStage = "UPDATE project SET full_paid_state = '1' WHERE id = '".$pro_id."';";
                if ($dbResult = mysqli_query($conn, $dbQueryStage)){$validate = true;} else {$validate = false;}
            }

        }
    }else{$validate = false;}
}
mysqli_close($conn);

$data = array();
if ($validate == true){
    $data['state'] = "OK";
}else{
    $data['state'] = "NOT";
}
echo json_encode($data);