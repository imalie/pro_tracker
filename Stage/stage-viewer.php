<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "usbw";
$dbDatabase = "bfc";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <script src="include/jquery.min.js" ></script>
        <script src="include/jquery-ui.min.js" ></script>
        <link rel="stylesheet" href="include/bootstrap.css">
        <link rel="stylesheet" href="include/jquery-ui.css">
    </head>
    <body>
        <div class="container p-3">
            <?php
            if (isset($_GET['id'])){
                $dbQueryStages = "SELECT stages.stage_id,project.pro_name,stages.stage_name,stages.approx_budget,stages.stage_desc FROM stages 
                            JOIN project ON stages.pro_id = project.id WHERE stages.pro_id = '".$_GET['id']."';";
                if ($resultStage = mysqli_query($conn, $dbQueryStages)){
                    if (mysqli_num_rows($resultStage) > 0){
                        while ($rowStage = mysqli_fetch_assoc($resultStage)){
                            echo '<div class="border rounded mt-2">
                                <table class="table table-borderless">
                                <tr><td>Stage Name: '.$rowStage['stage_name'].'</td><td>Aprox Budget: '.$rowStage['approx_budget'].'</td></tr>
                                <tr><td colspan="2">'.$rowStage['stage_desc'].'</td></tr>';

                            $dbQueryStagesItem = "SELECT stages_item.item_id, product.product_name, stages_item.item_cost, stages_item.qty, stages_item.total_amount FROM stages_item JOIN product ON stages_item.item_id = product.id WHERE stages_item.stage_id = '".$rowStage['stage_id']."';";
                            if ($resultStageItem = mysqli_query($conn, $dbQueryStagesItem)){
                                if (mysqli_num_rows($resultStageItem) > 0){
                                    while ($rowStageItem = mysqli_fetch_assoc($resultStageItem)){

                                        echo '</table><div class="border rounded">
                                            <table class="table table-borderless" id="item_table">
                                            <tr>
                                            <td>'.$rowStageItem['item_id'].'</td><td>'.$rowStageItem['product_name'].'</td><td>'.$rowStageItem['item_cost'].'</td>
                                            <td>'.$rowStageItem['qty'].'</td><td>'.$rowStageItem['total_amount'].'</td>
                                            </tr>';

                                    }
                                }
                            }
                            echo '</table></div>';
                        }
                    }
                }
            }
            ?>
        </div>
    </body>
</html>
