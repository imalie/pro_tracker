<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "usbw";
$dbDatabase = "bfc";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

if (isset($_POST['project_name'])){
    $dbQueryPro = "SELECT id,pro_name FROM project WHERE pro_name LIKE '%".$_POST['project_name']."%' LIMIT 10;";
    // get the result from db
    $db_pro_name = mysqli_query($conn, $dbQueryPro);
    // Generate array with skills data
    $pro_data_set = array();
    if (mysqli_num_rows($db_pro_name) > 0) {
        while ($row = mysqli_fetch_assoc($db_pro_name)) {
            $data['id'] = $row['id'];
            $data['value'] = $row['pro_name'];
            array_push($pro_data_set, $data);
        }
    }
    // Return results as json encoded array
    echo json_encode($pro_data_set);
}
if (isset($_POST['product_details'])){
    $dbQuery = "SELECT id,product_name,uom_code,unit_cost FROM product WHERE product_name LIKE '%".$_POST['product_details']."%' LIMIT 10;";
    // get the result from db
    $db_item_detail = mysqli_query($conn, $dbQuery);
    // Generate array with skills data
    $data_set = array();
    if (mysqli_num_rows($db_item_detail) > 0) {
        while ($row = mysqli_fetch_assoc($db_item_detail)) {
            $data['id'] = $row['id'];
            $data['product_name'] = $row['product_name'];
            $data['uom_code'] = $row['uom_code'];
            $data['unit_cost'] = $row['unit_cost'];
            array_push($data_set, $data);
        }
    }
    // Return results as json encoded array
    echo json_encode($data_set);
}

