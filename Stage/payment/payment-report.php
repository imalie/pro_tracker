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
            <th class="">Payment ID</th>
            <th class="">Full Name</th>
            <th class="">Project ID</th>
            <th class="">Paid Amount</th>
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

        $dbQuery = "SELECT * FROM payment";
        if ($result = mysqli_query($conn, $dbQuery)){
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    echo '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['customer_id'].'</td>
                                    <td>'.$row['project_id'].'</td>
                                    <td>'.$row['amount'].'</td>                                    
                                    <td>'.$row['release_date'].'</td>                                    
                                    <td>'.$row['release_user'].'</td>
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