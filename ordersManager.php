<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OrderManager</title>
    </head>
    <body>
        <?php

        function moveToTipsPage(){
            header("Location: tipsPage.php", true, 301);
        }

        $message='';

        $servername='localhost';
        $username='root';
        $password='';
        $dbName='ordersDataBase';
        $situationsList=array();
        $OrdSituations='OrderSituationsTable';//Table wiht order's situations
        //Create Connection

        $conn = new mysqli($servername,$username,$password,$dbName);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //Get the Situations of Orders
        $sql = "SELECT SituationName FROM $OrdSituations";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()){
                array_push($situationsList,$row['SituationName']);
                //echo $row['SituationName']."<br>";
            }
        }
        

        $last_id;//ID
            $numTable; // table of new order
            $ordSut;//Situation
            $ammount;//Total cost order
            $commnets;

        //newCreateOrder cookie, για να μην δημιουργει νεα παραγγελία με κάθε refresh 
        if($_COOKIE['newOrderCreate']==0){
            setcookie("newOrderCreate",1);
            
            
            //Create new order in EmpOrdersTable

            //New Order variables
            $last_id=0;//ID
            $numTable= $_COOKIE['selectedTable']; // table of new order
            $ordSut = $situationsList[0];//Situation
            $userID = $_COOKIE['userId'];
            $ammount =0.0;//Total cost order
            $commnets="";
            $FinEmpOrders = 'FinEmpOrdersTable';//Correct Table for any Employeer daily order (*)
            $sql = "INSERT INTO $FinEmpOrders (tableNumber,totalAmmount,situation,comments,EmpID)
                VALUES ('".$numTable."',$ammount,'".$ordSut."','".$commnets."','".$userID."')";

            //Get last ID , ID for new order
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                echo "New record created successfully. Last inserted ID is: " . $last_id;
                setcookie("IDfromOrder",$last_id);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
        }else{
            $enot = 'FinEmpOrdersTable';//Correct Table for any Employeer daily order (*)
            //get last order (τρέχουσα)
            $sql = "SELECT OrdID,tableNumber,totalAmmount,situation,comments,EmpID FROM $enot";
            $last_id=$_COOKIE['IDfromOrder'];
            $result = $conn->query($sql);
            if ($conn->query($sql) === TRUE) {
                                            
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                
            }
            while($row = $result->fetch_assoc()){
                if($last_id==$row['OrdID']){
                    //$last_id=$row['OrdID'];//ID
                    $numTable= $row['tableNumber']; // table of new order
                    $ordSut = $row['situation'];//Situation
                    $ammount =$row['totalAmmount'];//Total cost order
                    $commnets=$row['comments'];
                }
            }
        }
        $conn->close();
        ?>
        <header>
            <h1>Νέα παραγγελία <<<?php echo $last_id;?>>></h1>
            <h2 style="color:red"><?php echo $message?></h2>
        </header>
        <main>
            
            

           
            <article>
                <section>
                    <h2> Επιλογές</h2>
                    
                        <form method='get' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                            <?php
                                //Print all aviable products
                                $servername='localhost';
                                $username='root';
                                $password='';
                                $dbName='ordersDataBase';
                                $ProductsTable='ProductsTable';//Table with products (*)
                                $CatProducts='CategoriesProducts';//Table wiht categories product (*)
                                $VariationProductsTable='VariationProductsTable';//Table with variations products (*)
                                
                                //Create Connection
                                $conn = new mysqli($servername,$username,$password,$dbName);
                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT * FROM $CatProducts";
                                $result = $conn->query($sql);
                                
                               // $sqlv="SELECT * FROM $VariationProductsTable";
                                //$resultv=$conn->query($sqlv);

                                
                                    // output data of each row
                                    while($row = $result->fetch_assoc()){
                                        //array_push($CatArray,$row['CategoryName']);

                                        echo "<h2>".$row['CategoryName']."</h2>";
                                        $sqlc="SELECT * FROM $ProductsTable";
                                        $resultc=$conn->query($sqlc);
                                            
                                        while($rowc = $resultc->fetch_assoc()){
                                            
                                            if($row['CategoryNumber']==$rowc['ProductCategory']){
                                                echo $rowc['ProductName'].": <input type='submit' name='sp' value=".$rowc['ProductID']."> ";
                                                echo "<br>";
                                            }
                                        }
                                    
                                    }

                                   
                                    $conn->close();
                                    
                            ?>
                        </form>
                        
                </section>    
            </article>
                        <!-- Add Selected Product to order-->
                        <?php
                            $Dorders='DailyOrdersTable';//Table with product order (*)
                        
                            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                $addProduct=0;
                                //Selected Product Variables
                                $SelectProductName;//Name
                                $SelectProductID= $_GET['sp'];//ID
                                $SelectProductCategory;//Category
                                $SelectProductQuality=1;//Quality (How many times product select)
                                $SelectProductPrice=0.0;//Price (In order: Price*Quality)

                                //Create Dataserver connection
                                $servername='localhost';
                                $username='root';
                                $password='';
                                $dbName='ordersDataBase';
                                $ProductsTable='ProductsTable';//Table with products (*)
                                $CatProducts='CategoriesProducts';//Table wiht categories product (*)
                                $Dorders='DailyOrdersTable';//Table with product order (*)

                                $conn = new mysqli($servername,$username,$password,$dbName);
                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                //Get all products
                                $sql = "SELECT * FROM $ProductsTable";
                                $result = $conn->query($sql);

                                while($row = $result->fetch_assoc()){
                                    //Find Selected Product Row
                                    if($row['ProductID']==$SelectProductID){
                                        $SelectProductPrice=$row['ProductPrice'];
                                        $SelectProductName=$row['ProductName'];

                                        $IDcatgeory=$row['ProductCategory'];

                                        //Find Select Product Category Name
                                        $sqlc = "SELECT * FROM $CatProducts";
                                        $resultc= $conn->query($sqlc);
                                        while($rowc = $resultc->fetch_assoc()){
                                            if($rowc['CategoryNumber']==$IDcatgeory){
                                                $SelectProductCategory=$rowc['CategoryName'];
                                                break;
                                            }
                                        }

                                        //Add new record to DailyOrdersTable

                                            $sqlp = "INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice)
                                                VALUES ($last_id,'".$SelectProductName."','".$SelectProductCategory."',$SelectProductQuality,$SelectProductPrice)";
                                        if ($conn->query($sqlp) === TRUE) {
                                            
                                            echo "New record created successfully";
                                        } else {
                                            echo "Error: " . $sqlp . "<br>" . $conn->error;
                                        }

                                        

                                        break;
                                    }
                                }
                                $conn->close();

                            }
                        
                        
                        ?>
            <article>
                <section>
                <?php
                        echo "<table border='4' class='stats' cellspacing='0'>

                        <tr>
                        <td class='hed' colspan='8'>Προιόντα Παρραγελίας</td>
                        </tr>
                        <tr>
                        <th>Ποσότητα</th>
                        <th>Προιόν</th>
                        <th>Κατηγορία</th>
                        <th>Τιμή</th>
    
                        </tr>";
                        
                        //Create Dataserver connection
                        $servername='localhost';
                        $username='root';
                        $password='';
                        $dbName='ordersDataBase';
                        $Dorders='DailyOrdersTable';//Table with product order (*)

                        $conn = new mysqli($servername,$username,$password,$dbName);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        //Get Products from all Daily Orders
                        $sql = "SELECT * FROM $Dorders";
                        $result= $conn->query($sql);
                        //Print Products from Select Order
                        if ($conn->query($sql) === TRUE) {
                                            
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        $Poso=0.0;
                        while($row = $result->fetch_assoc()){
                           if($row['OrdID']==$last_id){
                                echo "<tr>";
                                echo "<th>".$row['quantity']."</th>";
                                echo "<th>".$row['product']."</th>";
                                echo "<th>".$row['category']."</th>";
                                echo "<th>".$row['tPrice']."</th>";
                                echo "</tr>";
                                $Poso= $Poso + $row['tPrice'];
                            }
                        }
                        echo $Poso;
                        $ammount=$Poso;
                        $sql1 = "UPDATE FinEmpOrdersTable SET totalAmmount=$Poso WHERE OrdID=$last_id";
                        if ($conn->query($sql1) === TRUE) {

                        }else{
                            echo "FUCK";
                        }
                        

                        $conn->close();

                    ?>
                </section>  

            </article>


            <article>
                <section>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST"){

                        
                        $servername='localhost';
                        $username='root';
                        $password='';
                        $dbName='ordersDataBase';
                        //Create Connection
                        $conn = new mysqli($servername,$username,$password,$dbName);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $selectButton = $_POST['pcsr'];
                        if($selectButton=='Πληρωμή' && $ordSut!=$situationsList[3]){

                            $sql = "UPDATE FinEmpOrdersTable SET situation='".$situationsList[2]."' WHERE OrdID=$last_id";
                            if ($conn->query($sql) === TRUE) {

                            }else{
                                echo "FUCK: ".$conn->error;
                            }
                            $conn->close();
                           
                            //header("Location: tipsPage.php");
                            //moveToTipsPage();
                            //header("Location: tipsPage.php", true, 301);

                            echo "<script type='text/javascript'>window.top.location='tipsPage.php';</script>";exit;

                        }else if($selectButton=='Ακύρωση' && $ordSut!=$situationsList[3]){
                            $sql ="DELETE FROM DailyOrdersTable WHERE OrdID=$last_id";
                            if ($conn->query($sql) === TRUE) {

                            }else{
                                echo "FUCK: ".$conn->error;
                            }
                            $sql = "UPDATE FinEmpOrdersTable SET situation='".$situationsList[3]."' WHERE OrdID=$last_id";
                            if ($conn->query($sql) === TRUE) {

                            }else{
                                echo "FUCK: ".$conn->error;
                            }
                        }else if($selectButton=='Αποθήκευση' && $ordSut!=$situationsList[3]){
                            $message ='* Save Order';
                            
                            if($ordSut==$situationsList[0]){
                                $ordSut=$situationsList[1];
                                
                                $sql = "UPDATE FinEmpOrdersTable SET situation='".$situationsList[1]."' WHERE OrdID=$last_id";
                                if ($conn->query($sql) === TRUE) {

                                }else{
                                    echo "FUCK: ".$conn->error;
                                }
                            }
                        }else{
                            $conn->close();
                            //header("Location: empCentralPage.php");
                        }
                        $conn->close();
                    }
                
                ?>
                    <?php

                        echo "<table border='4' class='stats' cellspacing='0'>

                        <tr>
                        <td class='hed' colspan='8'>Στοιχεία Παρραγελίας</td>
                        </tr>
                        <tr>
                        <th>Αριθμός Παραγγελίας</th>
                        <th>Αριθμός Τραπεζιού</th>
                        <th>Συνολικό Ποσό</th>
                        <th>Κατάσταση</th>
                        <th>Σχόλια</th>
    
                        </tr>";
    
                        echo "<tr>
                                <td>".$last_id."</td>
                                <td>".$numTable."</td>
                                <td>".$ammount."</td>
                                <td>".$ordSut."</td>
                                <td><a href='commentsPage.php'>...</a></td>";  
                        echo "</table>";

                    ?>
                </section>
                <section>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <input type='submit' value='Πληρωμή' name='pcsr'>
                        <input type='submit' value='Ακύρωση' name='pcsr'>
                        <input type='submit' value='Αποθήκευση' name='pcsr'>
                        <a href="empCentralPage.php">Επιστροφή</a>
                    </form>
                </section>
               
            </article>

                        

            
        </main>
    </body>
</html>