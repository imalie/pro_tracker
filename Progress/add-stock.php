<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbDatabase = "testtracker1";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

$dataset_count = count($_POST['dataset']);
$validate = false;
for ($i = 0; $i < $dataset_count; $i++) {
    $dbQueryStage = "UPDATE stages_item SET available_qty = '".$_POST['dataset'][$i]['ads_qty']."' WHERE id = '".$_POST['dataset'][$i]['id']."';";
    if ($dbResult = mysqli_query($conn, $dbQueryStage)){$validate = true;}
}
mysqli_close($conn);
if ($validate == true){
    $data = array();
    $data['state'] = "OK";
    echo json_encode($data);
}else{
    echo "not work";
}
