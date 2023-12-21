<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <header>
        <h2>Επιλογή Τραπεζιού</h2>
        </header>
        <section>
            <?php $st="0";//SelectedTable?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            
            <!--<input type="submit">-->
            <h2>Διαθέσιμα τραπέζια για <?php echo $_COOKIE['capacity']?> άτομα</h2>
            <?php
                $servername='localhost';
                $username='root';
                $password='';
                $dbName='ordersDataBase';
                $AvTables ='AvailableTables';//Table with availiable tables(all tables generaly)

                //Create Connection

                $conn = new mysqli($servername,$username,$password,$dbName);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM $AvTables";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                // output data of each row
                    while($row = $result->fetch_assoc()) {
                        if($row['TableCapacity']>=$_COOKIE['capacity']){
                            echo "<input type='submit' name='chT' value=".$row['TableNumber'].">";
                            
                        }
                     }
                } else {
                    echo "0 results";
                }
                
                
                $conn->close();
            
            ?>
        </form>
        </section>
        <section>
            
        </section>
        <?php
            setcookie("selectedTable","none");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $st=$_POST['chT'];
                setcookie("selectedTable",$st);
                setcookie("newOrderCreate",0);
            }
        ?>
        <br>
        TableNumber: <input type="text" name="tn" value=<?php echo $st?>>
        <br>
        <a href="capacityOrder.php">Αλλαγή Αριθμού</a>
        <a href="ordersManager.php">Ολοκλήρωση Παραγγελίας</a>
    </body>
</html>


