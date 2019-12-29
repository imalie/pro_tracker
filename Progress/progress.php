<?php
//DBMS Connection settings
$dbServer = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbDatabase = "testtracker1";

//DBMS Connection create
$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

$dbQuery = "SELECT project.pro_name,project.status,stages.stages_status,stages.stage_id,stages.stage_name,project.in_paid_state FROM project JOIN stages ON project.id = stages.pro_id
            WHERE project.id = '1';";

$dataset = array();
    if ($result = mysqli_query($conn, $dbQuery)){
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                $data = array();
                $data['pro_name'] = $row['pro_name'];
                $data['stage_id'] = $row['stage_id'];
                $data['stage_name'] = $row['stage_name'];
                $data['in_paid_state'] = $row['in_paid_state'];
                $data['status'] = $row['status'];
                $data['stages_status'] = $row['stages_status'];
                array_push($dataset,$data);
            }
        }
    }
$dbQueryRemark = "SELECT project_remark.remark FROM project_remark WHERE project_remark.pro_id = '1';";
$datasetRemark = array();
if ($resultRemark = mysqli_query($conn, $dbQueryRemark)){
    if (mysqli_num_rows($resultRemark) > 0){
        while ($rowRemark = mysqli_fetch_assoc($resultRemark)){
            $dataRemark = array();
            $dataRemark['remark'] = $rowRemark['remark'];
            array_push($datasetRemark,$dataRemark);
        }
    }
}
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
        <div>
            <h2>Progress</h2>
        </div>
        <table class="table">
            <tr>
                <td class="w-25"><label for="">Project ID</label><input class="form-control" id="pro_id" value="<?php echo '1'; ?>" disabled></td>
                <td class="w-auto"><label for="">Project Name</label><input class="form-control" id="pro_name" value="<?php echo $dataset[0]['pro_name']; ?>" disabled></td>
                <?php
                if ($dataset[0]['in_paid_state'] == 1) {
                    if ($dataset[0]['status'] == 'inprogress') {
                        echo '<td><br><button type="button" id="start" class="btn btn-success w-100" disabled>INPROGRESS</button></td>';
                        echo '<td><br><button type="button" id="update" class="btn btn-outline-success w-100">Update</button></td>';
                    } else {
                        echo '<td><br><button type="button" id="start" class="btn btn-success w-100">START</button></td>';
                    }

                }
                ?>
            </tr>
        </table>
        <table class="table border w-100">
            <?php
                for ($i = 0; $i < count($dataset); $i++) {
                    echo '<tr>
                    <td class="w-auto"><label for="">Stage Name</label><input type="text" id="stage_id_'.$i.'" class="form-control stage_id" value="'.$dataset[$i]['stage_id'].'" disabled></td>
                    <td class="w-25"><label for="">Stage Name</label><input type="text" class="form-control" value="'.$dataset[$i]['stage_name'].'" disabled></td>';
                    if ($dataset[0]['status'] == 'inprogress') {
                        echo '<td class="w-25"><label for="">Images</label><br><input type="file" class="custom-file" value="Upload Images"></td>';
                        if ($dataset[$i]['stages_status'] == 'inprogress') {
                            echo '<td class="w-25"><label for="">Status</label><br>
                            <select id="stages_status_'.$i.'" class="custom-select">
                                <option selected value="inprogress">Inprogress</option>
                                <option value="hold">Hold</option>
                                <option value="complete">Complete</option>
                            </select>
                            </td>                            
                            </tr>';
                        } else if ($dataset[$i]['stages_status'] == 'hold') {
                            echo '<td class="w-25"><label for="">Status</label><br>
                            <select id="stages_status_'.$i.'" class="custom-select">
                                <option value="inprogress">Inprogress</option>
                                <option selected value="hold">Hold</option>
                                <option value="complete">Complete</option>
                            </select>
                            </td>               
                            </tr>';
                        } else {
                            echo '<td class="w-25"><label for="">Status</label><br>
                            <select id="stages_status_'.$i.'" class="custom-select">
                                <option value="inprogress">Inprogress</option>
                                <option value="hold">Hold</option>
                                <option selected value="complete">Complete</option>
                            </select>
                            </td>               
                            </tr>';
                        }
                    }
                }
            ?>
        </table>
        <form id="formImg" action="img-progress.php" class="form-group" enctype="multipart/form-data">
            <label>Upload Stage Images</label>
            <select id="stages_name_img" name="stages_name_img" class="custom-select">
            <?php
            for ($i = 0; $i < count($dataset); $i++) {
                echo '<option value="'.$dataset[$i]['stage_id'].'">'.$dataset[$i]['stage_name'].'</option>';
            }
            ?>
            </select>
            <input type="file" class="custom-file" name="file">
            <input type="submit" class="btn btn-outline-success" name="submit" value="submit">
        </form>
        <table class="table">
            <tr>
                <td><label>Project Remark</label></td>
                <td><input class="btn btn-outline-dark float-right" type="button" id="add_remark" value="Add Remark"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="checkbox" id="cus_visible" class="checkbox">Customer Visible<br>
                    <textarea class="form-control" id="remark"></textarea>
                </td>
            </tr>
            <?php
            for ($i = 0; $i < count($datasetRemark); $i++) {
                echo '<tr><td colspan="2"><textarea class="form-control" disabled>'.$datasetRemark[$i]['remark'].'</textarea></td></tr>';
            }
            ?>
        </table>
        <p id="count" class="d-none"><?php echo count($dataset); ?></p>
    </div>
    </body>
<script>
    $(document).ready(function (e) {
        $('#start').click(function () {
            $.ajax({
                url: "update-progress.php",
                type: "POST",
                data: { pro_id: $('#pro_id').val() },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data['state'].includes("OK")){
                        location.reload();
                    }else { alert("Failed!"); }
                }
            });
        });
        $('#update').click(function () {

            var dataset = [];
            var count = parseInt($('#count').text());
            for (var i = 0; i < count; i++) {
                var data = {
                    'stages_id': $('#stage_id_'+i+'').val(),
                    'stages_status': $('#stages_status_'+i+' option:selected').val(),
                };
                dataset.push(data);
            }

            console.log(dataset);

            $.ajax({
                url: "update-progress.php",
                type: "POST",
                data: { progress: dataset },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data['state'].includes("OK")){
                        location.reload();
                    }else { alert("Failed!"); }
                }
            });
        });
        $('#add_remark').click(function () {
            var validate = false;
            var remark = $('#remark').val();
            var visible = 0;

            if ($('#cus_visible').is(":checked")){
                visible = 1;
            } else {
                visible = 0;
            }

            if (remark !== "") {
                validate = true;
            }

            if (validate) {
                var dataset = {
                    'pro_id': '1',
                    'remark': remark,
                    'visible': visible
                };
                console.log(dataset);
                $.ajax({
                    url: "update-progress.php",
                    type: "POST",
                    data: { remark: dataset },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data['state'].includes("OK")){
                            location.reload();
                        }else { alert("Failed!"); }
                    }
                });
            }
        });
        $("#formImg").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
                url: "img-progress.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    console.log(data);
                    location.reload();
                },
                error: function(){}
            });
        }));
    });

</script>
</html>
