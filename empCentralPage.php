<?php
    //Cookie BossLog=2 means employee change their log-->
    setcookie("BossLog",2);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['commentButton'])){
            $value=$_POST['commentButton'];
            setcookie("IDfromOrder",$value);
                            
            //header("Location: commentsPage.php");
            echo "<script type='text/javascript'>window.top.location='commentsPage.php';</script>";exit;
            }else{
                $value=$_POST['sel'];
                setcookie("newOrderCreate",1);
                setcookie("IDfromOrder",$value);
                            
                //$conn->close();
                //header("Location: ordersManager.php");
                echo "<script type='text/javascript'>window.top.location='ordersManager.php';</script>";exit;
                }
            }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- <title>Είσοδος σελίδα/Login page</title> -->
        <link rel="stylesheet" href="empCentralPageStyle.css">
        <link rel="stylesheet" href="ButtonsStyle.css">
    </head>
    <body>


        <header>
            <h1>Υπάλληλος: <?php echo $_COOKIE['userFnLog']." ". $_COOKIE['userLnLog']?></h1>
        </header>    

        <main>
            <article>
                <section>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <?php
                        
                        //Variables for tips and perfomance
                        $totalTips=0;
                        $totalPerfomance=0;

                        //Emp Name OrdersTable
                        $enot='FinEmpOrdersTable';

                        //Import orders data
                        $servername="localhost";
                        $username="root";
                        $password="";
                        $database="ordersDataBase";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password,$database);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        //Print Daily Orders
                        $sql = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                        echo "<table border='4' class='stats' cellspacing='0'>

                        <tr>
                        <td class='hed' colspan='8'>Daily Orders</td>
                        </tr>
                        <tr>
                        <th>Αριθμός Παραγγελίας</th>
                        <th>Αριθμός Τραπεζιού</th>
                        <th>Συνολικό Ποσό</th>
                        <th>Κατάσταση</th>
                        <th>Σχόλια</th>
                        <th>Επιλογή</th>

                        </tr>";

                        $sql1 = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
                        $result1 = $conn->query($sql1);
                        // output data of each row
                        while($row = $result1->fetch_assoc()) {
                            //Elegxos gia tis paraggelies tou sugkekrimenou xristi, pou sundethike
                            if($_COOKIE['userId']==$row['EmpID'] && $row['situation']=="Ολοκληρωμένη"){
                                echo "<tr><td>".$row["OrdID"]."</td><td>".$row["tableNumber"].
                                "</td><td>".$row["totalAmmount"]."</td><td>".$row["situation"]."</td><td><button name='commentButton' value='".$row['OrdID']."'> ... </button></td>
                                <td><input type='submit' value=".$row['OrdID']." name='sel'></td></tr>";
                                
                                //Update totalPerfomance
                                if($row['situation']=='Ολοκληρωμένη'){
                                    $totalPerfomance+=$row['totalAmmount'];
                                }
                            }
                        }

                        $sql1 = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
                        $result1 = $conn->query($sql1);
                        // output data of each row
                        while($row = $result1->fetch_assoc()) {
                            //Elegxos gia tis paraggelies tou sugkekrimenou xristi, pou sundethike
                            if($_COOKIE['userId']==$row['EmpID'] && $row['situation']=="Προς Πληρωμή"){
                                echo "<tr><td>".$row["OrdID"]."</td><td>".$row["tableNumber"].
                                "</td><td>".$row["totalAmmount"]."</td><td>".$row["situation"]."</td><td><button name='commentButton' value='".$row['OrdID']."'> ... </button></td>
                                <td><input type='submit' value=".$row['OrdID']." name='sel'></td></tr>";
                                
                                //Update totalPerfomance
                                if($row['situation']=='Ολοκληρωμένη'){
                                    $totalPerfomance+=$row['totalAmmount'];
                                }
                            }
                        }

                        $sql1 = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
                        $result1 = $conn->query($sql1);
                        // output data of each row
                        while($row = $result1->fetch_assoc()) {
                            //Elegxos gia tis paraggelies tou sugkekrimenou xristi, pou sundethike
                            if($_COOKIE['userId']==$row['EmpID'] && $row['situation']=="Άκυρη"){
                                echo "<tr><td>".$row["OrdID"]."</td><td>".$row["tableNumber"].
                                "</td><td>".$row["totalAmmount"]."</td><td>".$row["situation"]."</td><td><button name='commentButton' value='".$row['OrdID']."'> ... </button></td>
                                <td><input type='submit' value=".$row['OrdID']." name='sel'></td></tr>";
                                
                                //Update totalPerfomance
                                if($row['situation']=='Ολοκληρωμένη'){
                                    $totalPerfomance+=$row['totalAmmount'];
                                }
                            }
                        }

                        $sql1 = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
                        $result1 = $conn->query($sql1);
                        // output data of each row
                        while($row = $result1->fetch_assoc()) {
                            //Elegxos gia tis paraggelies tou sugkekrimenou xristi, pou sundethike
                            if($_COOKIE['userId']==$row['EmpID'] && $row['situation']=="Προς Εκτέλεση"){
                                echo "<tr><td>".$row["OrdID"]."</td><td>".$row["tableNumber"].
                                "</td><td>".$row["totalAmmount"]."</td><td>".$row["situation"]."</td><td><button name='commentButton' value='".$row['OrdID']."'> ... </button></td>
                                <td><input type='submit' value=".$row['OrdID']." name='sel'></td></tr>";
                                
                                //Update totalPerfomance
                                if($row['situation']=='Ολοκληρωμένη'){
                                    $totalPerfomance+=$row['totalAmmount'];
                                }
                            }
                        }


                        echo "</table>";
                    } else {
                            echo "<h3 style='color:red'>Δεν υπάρχουν σημερινές παραγγελίες</h3>";
                    }
                    
                    $conn->close();
                        
                        
                    ?>
                </form>

                </section>

                

                <section>
                
                <?php
                    
                    //Emp Name PerfomanceTable
                    $npt='EmpPerfomanceTable';

                    //Import orders data
                    $servername="localhost";
                    $username="root";
                    $password="";
                    $database="ordersDataBase";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password,$database);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    //Update employer Perfomance
                    $x=$_COOKIE['userId'];
                    $sql ="UPDATE EmpPerfomanceTable SET total=$totalPerfomance WHERE EmID='".$x."'";
                    if ($conn->query($sql) === TRUE) {

                    }else{
                        echo "FUCK: ".$conn->error;
                    }

                    //Print Daily Orders
                    $sql = "SELECT Uname, EmID,tips,total FROM $npt";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                    echo "<table border='4' class='stats' cellspacing='0'>

                    <tr>
                    <td class='hed' colspan='8'>Daily Perfomance</td>
                    </tr>
                    <tr>
                    <th>Ονοματεπώνυμο</th>
                    <th>Αριθμός Μητρώου</th>
                    <th>Φιλοδωρήματα</th>
                    <th>Απόδοση</th>

                    </tr>";

                    $sql = "SELECT Uname, EmID,tips,total FROM $npt";
                    $result = $conn->query($sql);
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //Emfanisi mono tou sundedemenou xristi
                        if($_COOKIE['userId']==$row['EmID'] ){
                            echo "<tr><td>".$row["Uname"]."</td><td>".$row["EmID"].
                            "</td><td>".$row["tips"]."</td><td>".$row["total"]."</td>";
                            
                            //Set cookie with tips
                            setcookie("EmpTips",$row['tips']);
                        }
                    }
                    echo "</table>";
                    } else {
                        echo "<h3 style='color:red'>Error 404 NOT FOUND</h3>";
                    }
                   
                    $conn->close();
                    
                    
                ?>
                
                </section>
                <section id="endPage">
                    <a href="FirstPage.html">Έξοδος</a><br>
                    <a href="empLog.php">Επανασύνδεση</a>
                    <a href="capacityOrder.php">Νέα Παραγγελία</a>
                    <a href="workEnds.php">Τέλος Βάρδιας</a>
                    <a href="printZ.php">Έκδοση Ζ</a>
                    <a href="changeLog.php">Αλλαγή Στοιχείων Εισόδου</a>
                </section>
            </article>
        </main>
        
    </body>
</html>