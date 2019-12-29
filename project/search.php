<?php
include '../config.inc.php';

$dbQuery = "SELECT id,first_name,last_name FROM customer WHERE first_name LIKE '%""%' LIMIT 10;";
//get the result from db
$dbResult = mysqli_query($conn, $dbQuery);
// Generate array with skills data
$skillData = array();
if (mysqli_num_rows($dbResult) > 0) {
    while ($row = mysqli_fetch_assoc($dbResult)) {
        $data['id'] = $row['id'];
        $data['value'] = $row['first_name']." ".$row['last_name'];
        array_push($skillData, $data);
    }
}
// Return results as json encoded array
echo json_encode($skillData);