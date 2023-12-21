<?php

//Globals AREA

$Z_Ammount=0;//Value has saved as daily Z ammount


//Functions AREA 

//This function  calculates Z ammount

function calculateZ(){

    $totalZ=0;//Variable with totalAmmount from completed orders

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM SalesTable WHERE OrderDay='".date('Y-m-d')."'";
    echo $conn->error;
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $totalZ+=$row['TotalAmmount'];
        }
    }

    return $totalZ;

}

//This function print in table rows, the completed orders (Orders will add on Z)
function printCompleteSales(){

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM SalesTable WHERE OrderDay='".date('Y-m-d')."'";
    echo $conn->error;
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row['OrderID']."</td>";
            echo "<td>".$row['TotalAmmount']."</td>";
            echo "</tr>";
            $totalZ+=$row['TotalAmmount'];
        }
    }else{
        echo "<tr><th colspan='8' style='color:red'>No results</th></tr>";
    }

    
}

//Check if daily Z already exist

function checkDailyZ(){

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $ZTable='ZTable';//Table with all Z, Z=daily earnings(*)

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql ="SELECT * FROM ZTable";
    $result=$conn->query($sql);

    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            //echo $row['ZDay']." - ".date('Y-m-d')."<br>";
            if($row['ZDay']==date('Y-m-d')){
                return FALSE;
            }
        }
    }

    return TRUE;
}

//Save Z, total ammounts has calculate on printCompleteSales() function, global variable $Z_Ammount

function SaveZ($x){
   

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $ZTable='ZTable';//Table with all Z, Z=daily earnings(*)

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    //Check if Z exist
    if(checkDailyZ()){
        $sql= "INSERT INTO ZTable (TotalAmmount,ZDay,UserID)
        VALUES($x,CAST('".date("Y-m-d")."' AS DATE),'".$_COOKIE['uzerId']."')";

        if($conn->query($sql)===FALSE){
            echo $conn->error;
        }else{
            echo "<p style='color:green'>Z save</p>";
        }
    }else{
        echo "<p style='color:red'>Z already exist</p>";
    }
}


//=========================================================================================================//

//Method AREA

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Z'])){
        SaveZ(calculateZ());
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
            <h1>Έκδοση Ζ</h1>
        </header>
        <main>
            <article>
                <section>
                    <table border='4' cellspacing='0'>
                        <tr>
                            <th colspan='8'>Σύνολο Ολοκληρωμένων Πωλήσεων</th>
                        </tr>
                        <tr>
                            <th>Αριθμός Παραγγελίας</th>
                            <th>Συνολικό Ποσό</th>
                        </tr>
                        <?php
                            printCompleteSales();
                        ?>
                    </table>
                </section>
                <section>
                        <table border='4' cellspacing='0'>
                            <tr>
                                <th colspan='8'>Στοιχεία Ζ</th>
                            </tr>
                            <tr>
                                <th>Ποσό Ζ</th>
                                <th>Ημερομηνία</th>
                            </tr>
                            <tr>
                                <td><?php echo calculateZ();?></td>
                                <td><?php echo date('Y-m-d');?></td>
                            </tr>
                        </table>
                        
                </section>
                <section>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <button type='submit' name='Z'>Έκδοση</button>
                    </form>
                </section>
            </article>
        </main>
        <footer>
            <a href="empCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>