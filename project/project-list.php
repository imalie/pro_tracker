<?php
include_once '../mod/admin-head.php';
include_once '../config.inc.php';
?>
<div class="">
    <table class="">
        <thead>
        <tr class="">
            <th class="">Project ID</th>
            <th class="">Project Name</th>
            <th class="">Owner Name</th>
            <th class="">Approximated Budget</th>
            <th class="">Advance Payment</th>
            <th class="">Start Date</th>
            <th class="">End Date</th>
            <th class="">Release Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $dbQuery = "SELECT project.id,project.pro_name,customer.first_name,customer.last_name,project.approx_budget,project.advance_payment,project.start_date,project.end_date,project.release_date
                    FROM project INNER JOIN customer ON project.id = customer.id;";
        if ($result = mysqli_query($conn, $dbQuery)){
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo '<tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['pro_name'].'</td>
                            <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                            <td>'.$row['approx_budget'].'</td>                                    
                            <td>'.$row['advance_payment'].'</td>
                            <td>'.$row['start_date'].'</td>
                            <td>'.$row['end_date'].'</td>
                            <td>'.$row['release_date'].'</td>
                            <td><a href="project-viewer.php?id='.$row['id'].'">View</a></td>
                          </tr>';
                }
            }else {
                echo '
                      <tr>
                        <td style="color: #ff0000">0 result</td>
                      </tr>';
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php include_once '../mod/admin-footer.php'?>
