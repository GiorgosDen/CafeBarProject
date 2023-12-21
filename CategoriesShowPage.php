<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <head>
            <h1>Κατηγορίες...</h1>
        </head>
        <section>
            <?php
               
                $servername='localhost';
                $username='root';
                $password='';
                $dbName='usersDataBase';
                $usersTable='usersTable';//Table for any user
                $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)
                    
                //Create Connection

                $conn = new mysqli($servername,$username,$password,$dbName);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //Load all categories in list
                $sql ="SELECT * FROM categoriesTable";
                $result=$conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table border='4' class='stats' cellspacing='0'>
                        <tr>
                        <td class='hed' colspan='8'>Κατηγορίες</td>
                        </tr>
                        <tr>
                        <th>Όνομα Κατηγορίας</th>
                        <th>Κωδικός Κατηγορίας</th>
                        </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row['Catname']."</td><td>".$row['Symbol']."</td></tr>";
                    }
                    echo "</table>";
                }
            ?>
        </section>
        <section>
            <button onclick='<?php echo "In progress";?>'>Επεξεργασία Κατηγορίας</button>
            <a href="employeeManagerPage.php">Επιστροφή</a>
        </section>
    </body>
</html>