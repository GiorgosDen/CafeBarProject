<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Αποθήκη</h1>
        </header>
        <main>
            <article>
                <section>
                    <h2>Απόθεμα</h2>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <?php 
                        echo "<table border='4' class='stats' cellspacing='0'>
                            <tr>
                                <th>Κωδικός Πόρου</th>
                                <th>Όνομα Πόρου</th>
                                <th>Ποσότητα</th>
                                <th>Ελάχιστη Αποδεκτή Ποσότητα</th>
                                <th>Μέγιστη Αποδεκτή Ποσότητα</th>
                                <th>Μάζα ανά μονάδα</th>
                                <th>Μονάδα Μέτρησης</th>
                            </tr>";
                            $servername='localhost';
                            $username='root';
                            $password='';
                            $dbName='ordersDataBase';
                            $MaterialsTable='MaterialsTable';//Table with materials for production products(*)
                            //Create Connection

                            $conn = new mysqli($servername,$username,$password,$dbName);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql="SELECT * FROM $MaterialsTable";
                            $result=$conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    if($row['Mmin']==$row['MQuantity']){
                                        echo "<tr style='background-color:orange'>";
                                        echo "<td>".$row['MID']."</td><td>".$row['MName']."</td>
                                        <td>".$row['MQuantity']."</td><td>".$row['Mmin']."</td>
                                        <td>".$row['Mmax']."</td><td>".$row['Mmass']."</td>
                                        <td>".$row['MmeasurementUnit']."</td><td><button name='b' value=".$row['MID'].">Επιλογή</button></td>";
                                        echo "</tr>";
                                    }else if($row['MQuantity']==0){
                                        echo "<tr style='background-color:red'>";
                                        echo "<td>".$row['MID']."</td><td>".$row['MName']."</td>
                                        <td>".$row['MQuantity']."</td><td>".$row['Mmin']."</td>
                                        <td>".$row['Mmax']."</td><td>".$row['Mmass']."</td>
                                        <td>".$row['MmeasurementUnit']."</td><td><button name='b' value=".$row['MID'].">Επιλογή</button></td>";
                                        echo "</tr>";
                                    }else{
                                        echo "<tr style='background-color:MediumSeaGreen'>>";
                                        echo "<td>".$row['MID']."</td><td>".$row['MName']."</td>
                                        <td>".$row['MQuantity']."</td><td>".$row['Mmin']."</td>
                                        <td>".$row['Mmax']."</td><td>".$row['Mmass']."</td>
                                        <td>".$row['MmeasurementUnit']."</td><td><button name='b' value=".$row['MID'].">Επιλογή</button></td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                        echo "</table>";
                        
                        ?>
                    </form>
                    <button onclick="window.location.href='addMaterialPage.php';">Νέος Πόρος</button>
                </section>
            </article>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    setcookie("selectMaterial",$_POST['b']);
                    header("Location: materialPage.php");
                    
                }
            ?>
        </main>
        <footer>
            <a href="bossCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>