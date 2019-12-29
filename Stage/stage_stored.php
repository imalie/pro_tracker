<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "usbw";
$dbDatabase = "bfc";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

$dataset_count = count($_POST['dataset']);
$master_id = null;
$validate = false;
for ($i = 0; $i < $dataset_count; $i++) {
    if ($_POST['dataset'][$i]['type'] == "master") {
        $master_id = $i;
        $dbQueryStage = "INSERT INTO stages (pro_id, stage_name, stage_desc, approx_budget, outstanding, release_user) 
                        VALUES ('".$_POST['dataset'][$i]['pro_id']."','".$_POST['dataset'][$i]['stage_name']."','".$_POST['dataset'][$i]['desc']."','".$_POST['dataset'][$i]['approx_budget']."','".$_POST['dataset'][$i]['approx_budget']."','admin');";
        if ($dbResult = mysqli_query($conn, $dbQueryStage)){$validate = true;}
    }
    if ($_POST['dataset'][$i]['type'] == "item") {
        $dbQueryStageItem = "INSERT INTO stages_item (stage_id, item_id, item_cost, qty, total_amount, release_user) 
                            VALUES (((SELECT stage_id FROM stages WHERE stage_name = '".$_POST['dataset'][$master_id]['stage_name']."')),'".$_POST['dataset'][$i]['item_id']."','".$_POST['dataset'][$i]['unit_cost']."','".$_POST['dataset'][$i]['qty']."','".$_POST['dataset'][$i]['total_amount']."','admin');";
        if ($dbResult = mysqli_query($conn, $dbQueryStageItem)){$validate = true;}
    }
}
mysqli_close($conn);
if ($validate == true){
    $data = array();
    $data['state'] = "OK";
    echo json_encode($data);
}else{
    echo "not work";
}