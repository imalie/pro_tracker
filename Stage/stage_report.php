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
        <div class="container">
            <table class="table border">
                <thead>
                    <tr class="">
                        <th class="">Project ID</th>
                        <th class="">Project Name</th>
                        <th class="">Approximated Budget</th>
                        <th class="">Release Date</th>
                        <th class="">Release User</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                //DBMS Connection settings
                $dbServer = "localhost";
                $dbUser = "root";
                $dbPassword = "usbw";
                $dbDatabase = "bfc";

                //DBMS Connection create
                $conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbDatabase);

                $dbQuery = "SELECT stages.pro_id,project.pro_name,SUM(stages.approx_budget),stages.release_date,stages.release_user 
                            FROM stages JOIN project ON stages.pro_id = project.id GROUP BY stages.pro_id;";
                if ($result = mysqli_query($conn, $dbQuery)){
                    if (mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)){
                            echo '<tr>
                                    <td>'.$row['pro_id'].'</td>
                                    <td>'.$row['pro_name'].'</td>
                                    <td>'.$row['SUM(stages.approx_budget)'].'</td>
                                    <td>'.$row['release_date'].'</td>                                    
                                    <td>'.$row['release_user'].'</td>
                                    <td><a href="stage-viewer.php?id='.$row['pro_id'].'">View</a></td>
                                  </tr>';
                        }
                    }else {
                        echo '<tr>
                                <td style="color: #ff0000">0 result</td>
                              </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>