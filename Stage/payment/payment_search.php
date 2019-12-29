<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "usbw";
$dbDatabase = "bfc";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);
if (isset($_POST['customer_name'])){
    $dbQueryCustomer = "SELECT id,first_name,last_name FROM customer WHERE first_name LIKE '%".$_POST['customer_name']."%' LIMIT 10;";
    // get the result from db
    $dbCustomer = mysqli_query($conn, $dbQueryCustomer);
    // Generate array with skills data
    $cus_data_set = array();
    if (mysqli_num_rows($dbCustomer) > 0) {
        while ($row = mysqli_fetch_assoc($dbCustomer)) {
            $data['id'] = $row['id'];
            $data['full_name'] = $row['first_name']." ".$row['last_name'];
            array_push($cus_data_set, $data);
        }
    }
    // Return results as json encoded array
    echo json_encode($cus_data_set);
}

if (isset($_POST['project_id'])){
    $dbQueryPro = "SELECT project.id,project.pro_name,SUM(stages.approx_budget) FROM project JOIN stages ON project.id = stages.pro_id WHERE project.pro_owner_id = '".$_POST['project_id']."' AND project.full_paid_state = '0' GROUP BY project.id;";
    // get the result from db
    $db_pro_name = mysqli_query($conn, $dbQueryPro);
    // Generate array with skills data
    $pro_data_set = array();
    if (mysqli_num_rows($db_pro_name) > 0) {
        while ($row = mysqli_fetch_assoc($db_pro_name)) {
            $data['id'] = $row['id'];
            $data['pro_name'] = $row['pro_name'];
            $data['outstanding'] = $row['SUM(stages.approx_budget)'];
            array_push($pro_data_set, $data);
        }
    }
    // Return results as json encoded array
    echo json_encode($pro_data_set);
}

if (isset($_POST['stage_details'])){
    $dbQueryStage = "SELECT stages.stage_id,stages.stage_name,stages.approx_budget,stages.outstanding FROM stages WHERE stages.pro_id = '".$_POST['stage_details']."';";
    // get the result from db
    $dbStageDetail = mysqli_query($conn, $dbQueryStage);
    // Generate array with skills data
    $stage_data_set = array();
    if (mysqli_num_rows($dbStageDetail) > 0) {
        while ($row = mysqli_fetch_assoc($dbStageDetail)) {
            $data['stage_id'] = $row['stage_id'];
            $data['stage_name'] = $row['stage_name'];
            $data['approx_budget'] = $row['approx_budget'];
            $data['outstanding'] = $row['outstanding'];
            array_push($stage_data_set, $data);
        }
    }
    // Return results as json encoded array
    echo json_encode($stage_data_set);
}