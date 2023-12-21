<?php

    $errorEnd="";
    //Functions AREA

    //Print all Orders , in rows table
    function printDailyOrders(){

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

        //Check orders from selected employee
        $sql = "SELECT * FROM FinEmpOrdersTable WHERE empID='".$_COOKIE['userId']."'";
        if($conn->query($sql)==FALSE){
            echo "<h1 style='color:red'>".$conn->error."</h1>";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['OrdID']."</td>";
                echo "<td>".$row['tableNumber']."</td>";
                echo "<td>".$row['totalAmmount']."</td>";
                echo "<td>".$row['situation']."</td>";
                echo "<td>".$row['comments']."</td>";
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='8'>Error</td></tr>";
        }

    }

    //Checks if all orders are correct/completed
    function checkOrders(){
        $F=TRUE;
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

        //Check orders from selected employee
        $sql = "SELECT * FROM FinEmpOrdersTable WHERE empID='".$_COOKIE['userId']."'";
        if($conn->query($sql)==FALSE){
            echo "<h1 style='color:red'>".$conn->error."</h1>";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row=$result->fetch_assoc()){
                //if a order is no completed return false
                if($row['situation']=="Προς Πληρωμή" || $row['situation']=="Προς Εκτέλεση"){
                    
                    $F=FALSE;
                    return $F;
                }
            }
        }
        //All orders are completed , so return true
        return $F;
    }

    //Elegxei an ena proion exei pouithei simera 
    function checkIfProductSalesToDay($product){

        $servername="localhost";
        $username="root";
        $password="";
        $database="ordersDataBase";
        $SalesProductsTable='SalesProductsTable';//Table with all products sales(*)

        // Create connection
        $conn = new mysqli($servername, $username, $password,$database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $day=date("Y-m-d");
        //Search if row with $product (on ProductName) & to day date already exist
        $sql ="SELECT * FROM SalesProductsTable WHERE SaleDay='".$day."'";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                //If found product name in row from today
                if($row['ProductName']==$product){
                    return $row['DailyQuantity'];
                }
            }
        }else{
            echo "))))";
        }

        //Not found product sale from today on SalesProductsTable
        return -1;

    }

    //Termatizei tin bardia
    function finishDay(){
        //Import orders data
        $servername="localhost";
        $username="root";
        $password="";
        $database="ordersDataBase";
        $SalesTable="SalesTable";//Table with all sales, for any day(*)
        $Dorders='DailyOrdersTable';//Table with product order (*)
        $SalesProductsTable='SalesProductsTable';//Table with all products sales(*)

        // Create connection
        $conn = new mysqli($servername, $username, $password,$database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //Transopt all user orders on SalesTable

        $sql = "SELECT * FROM FinEmpOrdersTable WHERE empID='".$_COOKIE['userId']."'";
        if($conn->query($sql)===FALSE){
            echo "<h1 style='color:red'>".$conn->error."</h1>";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row=$result->fetch_assoc()){
                $sqlS = "INSERT INTO SalesTable (OrderID,TableNumber,TotalAmmount,OrderSituation,OrderComments,EmployeeID,OrderDay)
                VALUES (".$row['OrdID'].",'".$row['tableNumber']."',".$row['totalAmmount'].",'".$row['situation']."','".$row['comments']."','".$row['EmpID']."',CAST('".date("Y-m-d")."' AS DATE))";

                if($conn->query($sqlS)===FALSE){
                    echo "<h1 style='color:red'>".$conn->error."</h1>";
                }else{
                    //If record transpot complite, delete order from FinEmpOrders Table

                    $sqlD = "DELETE FROM FinEmpOrdersTable WHERE OrdID='".$row['OrdID']."'";
                    if($conn->query($sqlD)===FALSE){
                        echo "<h1 style='color:red'>".$conn->error."</h1>";
                    }
                }

                //Transpot all sales products from DailyOrdersTable to SalesProdustTable
                //Tranpot product has connect with trecxon order

                $sqlP="SELECT * FROM DailyOrdersTable WHERE OrdID=".$row['OrdID']."";
                $resultP=$conn->query($sqlP);

                if($resultP->num_rows>0){
                    while($rowp=$resultP->fetch_assoc()){
                        //If have a row with run product
                        $Q=checkIfProductSalesToDay($rowp['product']);
                        if($Q>0){
                            $Q+=$rowp['quantity'];
                            //Update some record
                            $sqlSP ="UPDATE SalesProductsTable SET DailyQuantity=$Q WHERE ProductName='".$rowp['product']."'";
                            if($conn->query($sqlSP)===FALSE){
                                echo "<h1 style='color:red'>".$conn->error."</h1>";}

                        }else{
                            //New record
                            $sqlSP="INSERT INTO SalesProductsTable (ProductName,ProductCategory,DailyQuantity,SaleDay)
                            VALUES ('".$rowp['product']."','".$rowp['category']."',".$rowp['quantity'].",CAST('".date("Y-m-d")."' AS DATE))";

                            if($conn->query($sqlSP)===FALSE){
                                echo "<h1 style='color:red'>".$conn->error."</h1>";}
                                                    }

                        //Delete rercord from DailyOrdersTable

                        $sqlDP ="DELETE FROM DailyOrdersTable WHERE OrdID=".$row['OrdID']."";
                        if($conn->query($sqlDP)===FALSE){
                            echo "<h1 style='color:red'>".$conn->error."</h1>";}
                        
                    }
                }

            }
        }

        

    }

    //=======================================================================================================================//

    //Form AREA

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //If press "Τέλος Βάρδιας" button
        if(isset($_POST['end'])){
            //If all orders are correct
            if(checkOrders()){
                //End Day for employee
                finishDay();
            }else{
                $errorEnd="Υπάρχουν Παραγγελίες Μη Ολοκληρωμένες...";
            }
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Τέλος Βάρδιας</h1>
        </header>
        <main>
            <article>
                <section>
                    <table border='4' cellspacing='0'>
                        <tr>
                            <th colspan='8'>Συνολικές Παραγγελίες << <?php echo $_COOKIE['userFnLog']." ". $_COOKIE['userLnLog']?> >></th>
                        </tr>
                        <tr>
                            <th>Αριθμός Παραγγελίας</th>
                            <th>Αριθμός Τραπεζιού</th>
                            <th>Συνολικό Ποσό</th>
                            <th>Κατάσταση</th>
                            <th>Σχόλια</th>
                        </tr>
                        <?php printDailyOrders()?>
                    </table>
                </section>
                <section>
                    <?php echo "<p style='color:red'>".$errorEnd."</p>";?>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <button type='submit' name='end'>Τέλος Βάρδιας</button>
                    </form>
                </section>
            </article>
        </main>
        <footer>
            <a href="empCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>