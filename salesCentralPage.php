<?php
//Global variables
$DailyIncome=0;


//Load data for the operation of the page (DOP), functions loadEmpNames($List) & loadSituationsOrders($List)
//DOP : Situations from orders and employees names

$OrdersSituationsList=array();
$OrdersSituationsList=loadSituationsOrders($OrdersSituationsList);
$EmployeersNamesList=array();
$EmployeersNamesList=loadEmpNames($EmployeersNamesList);

//================================================================================================================//
//Functions AREA

//find per Sales situations Quantities
function calculateDataForSalesGraphQuantityEdition($time){

    $NumberOfCompleteOrders=0;
    $NumberOfInvalidOrders=0;
    $OldestDate = calculateOldestDate($time);
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)
    //Create Connection

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM $SalesTable WHERE (OrderSituation='Ολοκληρωμένη' AND OrderDay>='".$OldestDate."')";
    $result= $conn->query($sql);
    $NumberOfCompleteOrders=$result->num_rows;

    $sql = "SELECT * FROM $SalesTable WHERE (OrderSituation='Άκυρη' AND OrderDay>='".$OldestDate."')";
    $result= $conn->query($sql);
    $NumberOfInvalidOrders=$result->num_rows;

    echo $NumberOfCompleteOrders." -- ";
    echo $NumberOfInvalidOrders;
    echo "<br>Oldest Day: ".$OldestDate;
    //Complete & Invalid Orders Quantity sales
    $AllQuantitiesSales = array(
        array("label"=> "Ολοκληρωμένες", "y"=> $NumberOfCompleteOrders),
        array("label"=> "Ακυρωμένες", "y"=> $NumberOfInvalidOrders),
        
    );

    return $AllQuantitiesSales;

}

//find per Sales situations Total Ammounts
function calculateDataForSalesGraphTotalAmmountEdition($time){

    $TotalAmmountOfCompleteOrders=0;
    $TotalAmmountOfInvalidOrders=0;
    $OldestDate = calculateOldestDate($time);
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)
    //Create Connection

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //calculate  complete order's ,total ammount
    $sql = "SELECT TotalAmmount FROM $SalesTable WHERE (OrderSituation='Ολοκληρωμένη' AND OrderDay>='".$OldestDate."')";
    $result= $conn->query($sql);
    
    if($result->num_rows>0){
       while($row=$result->fetch_assoc()){
            $TotalAmmountOfCompleteOrders+=$row['TotalAmmount'];
       } 
    }


    //Calculate invalid orders total ammount
    $sql = "SELECT COUNT TotalAmmount FROM $SalesTable WHERE (OrderSituation='Άκυρη' AND OrderDay>='".$OldestDate."')";
    $result= $conn->query($sql);
    
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
             $TotalAmmountOfInvalidOrders+=$row['TotalAmmount'];
        } 
     }

    echo "<br> Ammounts ".$TotalAmmountOfCompleteOrders." -- ";
    echo $TotalAmmountOfInvalidOrders;
    echo "<br>Oldest Day: ".$OldestDate;
    //Complete & Invalid Orders Quantity sales
    $AllTotalAmmounts = array(
        array("label"=> "Ολοκληρωμένες", "y"=> $TotalAmmountOfCompleteOrders),
        array("label"=> "Ακυρωμένες", "y"=> $TotalAmmountOfInvalidOrders),
        
    );

    return $AllTotalAmmounts;

}

//Find sales for any user

function calculateSalesForAnyPerson($time,$situation,$requestedValue){

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)
    //Create Connection

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $PersonsNamesList=loadEmpNames($PersonsNamesList);//List with names for any peron/user
    $PersonsSalesList=array();//List with sales for any peron/user
    $OldestDate = calculateOldestDate($time);

    //For any person
    foreach($PersonsNamesList as $am=>$name){
        $Value=0;
        //Get all records from sales table, with her ID and order status requested
        $sql ="SELECT * FROM $SalesTable WHERE EmployeeID='".$am."' AND OrderSituation='".$situation."'";
        $result=$conn->query($sql);

        if($result->num_rows>0){
            while ($row=$result->fetch_assoc()){
                if($row['OrderDay']>=$OldestDate){
                    if(strcmp($requestedValue,'TotalAmmount')==0){
                        $Value+=$row[$requestedValue];//$requestedValue->name of colum pou upologizoume to athroisma
                    }else{
                        $Value+=1;//Else, we want number of orders, for any person
                    }
                }
            }
        }
        //Add new person record to PersonsSalesList
        array_push($PersonsSalesList,array("label"=> $name, "y"=> $Value));

    }

    

    //Return list wiht sales
    return $PersonsSalesList;

}


function printGraphs($AllQuantitiesSales,$AllTotalAmmounts,$PersonList,$time){
    echo "<script>";
    echo "window.onload = function () {
    
    var chart = new CanvasJS.Chart('chartContainer', {
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: 'Αναλογία Ολοκληρωμένων/Ακυρωμένων Πωλήσεων (".$time.")'
        },
        subtitles: [{
            text: 'Currency Used: Αριθμός Παραγγελιών Ν'
        }],
        data: [{
            type: 'pie',
            showInLegend: 'true',
            legendText: '{label}',
            indexLabelFontSize: 16,
            indexLabel: '{label} - #percent%',
            yValueFormatString: 'N:#,##0',
            dataPoints: ".json_encode($AllQuantitiesSales, JSON_NUMERIC_CHECK)."
        }]
    });
    chart.render();

    var chart1 = new CanvasJS.Chart('chartContainer1', {
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: 'Αναλογία ,Χρηματικών Ποσών, Ολοκληρωμένων/Ακυρωμένων Πωλήσεων (".$time.")'
        },
        subtitles: [{
            text: 'Currency Used: Χρηματικό Ποσό ($)'
        }],
        data: [{
            type: 'pie',
            showInLegend: 'true',
            legendText: '{label}',
            indexLabelFontSize: 16,
            indexLabel: '{label} - #percent%',
            yValueFormatString: '$:#,##0',
            dataPoints: ".json_encode($AllTotalAmmounts, JSON_NUMERIC_CHECK)."
        }]
    });
    chart1.render();

    var chart2 = new CanvasJS.Chart('chartContainer2', {
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: 'Ποσοστά Πωλήσεων ανά Υπάλληλο (".$time.")'
        },
        subtitles: [{
            text: 'Currency Used: Χρηματικό Ποσό ($)'
        }],
        data: [{
            type: 'pie',
            showInLegend: 'true',
            legendText: '{label}',
            indexLabelFontSize: 16,
            indexLabel: '{label} - #percent%',
            yValueFormatString: '$:#,##0',
            dataPoints: ".json_encode($PersonList, JSON_NUMERIC_CHECK)."
        }]
    });
    chart2.render();
    
    }
    </script>";

    echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div>
    <script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
    echo "<div id='chartContainer1' style='height: 370px; width: 100%;'></div>
    <script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
    echo "<div id='chartContainer2' style='height: 370px; width: 100%;'></div>
    <script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
   
}

//=============================================================================================//

function loadEmpNames($List){
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

    $sql = "SELECT * FROM usersTable WHERE Category='EMP'";
    $result = $conn->query($sql);

    if($result->num_rows>0){

        while($row = $result->fetch_assoc()) {
            $List[$row['AM']]=$row['firstName']." ".$row['lastName'];
        }
    }else{
        echo "Error with staff data <br>";
    }

    return $List;

}

function loadSituationsOrders($List){

    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $OrdSituations='OrderSituationsTable';//Table wiht order's situations (*)

    //Create Connection

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM $OrdSituations";
    $result = $conn->query($sql);

    if($result->num_rows>0){

        while($row = $result->fetch_assoc()) {
            $List[$row['SituationID']]=$row['SituationName'];
            //echo "Key: ".$row['SituationID']." Value: ".$row['SituationName']."<br>";
        }
        foreach($List as $i=>$x){
            //echo "Key: ".$i." Value: ".$x."<br>";
        }
    }else{
        echo "Error with Situations (from Orders) data <br>";
    }


    return $List;
}

//Vriskei tin palaioteri imerominia pou prepei na exoun oi paraggelies , sumfwna me tin anazhtisi
function calculateOldestDate($timeStamp){

    if($timeStamp=="Ημέρας"){
        return date('Y-m-d');
    }elseif($timeStamp=="Εβδομάδας"){
        return date('Y-m-d', strtotime('-7 day'));
    }elseif($timeStamp=="Μήνα"){
        return date('Y-m-d', strtotime('-1 month'));
    }elseif($timeStamp=="Τρίμηνου"){
        return date('Y-m-d', strtotime('-3 month'));
    }elseif($timeStamp=="Τετράμηνου"){
        return date('Y-m-d', strtotime('-4 month'));
    }elseif($timeStamp=="Εξάμηνου"){
        return date('Y-m-d', strtotime('-6 month'));
    }elseif($timeStamp=="Οκτάμηνου"){
        return date('Y-m-d', strtotime('-8 month'));
    }elseif($timeStamp=="Έτους"){
        return date('Y-m-d', strtotime('-1 year'));
    }else{
        return date('Y-m-d', strtotime('-10 year'));
    }
}

function printSelectedOrders($time,$staff,$situation){
   
    $OldestDate=calculateOldestDate($time);
    //echo $OldestDate."<br>";
    $HaveResults=false;//If is true , we have orders to print
    $EmpList=array();//Function List with names
    $printNames=false;//if true print and the employeers names
    $printSituations=false;//if true print and the situations from orders
    $returnValue=0;//DailyIncomes where function returns
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $SalesTable='SalesTable';//Table with all sales, for any day(*)
    //Create Connection

    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Print all complete dayily orders
    $sql = "SELECT * FROM $SalesTable";
    if($conn->query($sql)===FALSE){
        echo $conn->error;
    }
    $result=$conn->query($sql);
    $EmpList=loadEmpNames($EmpList);
    echo "
    <table border='4' cellspacing='0'>
        <tr>";
            if($staff!="Everybody"){
                echo "<th colspan='18' text-align='center'>Συνολικές Πωλήσεις ".$time." του/ης ".$EmpList[$staff]."</th>";
            }else{
                echo "<th colspan='18' text-align='center'>Συνολικές Πωλήσεις ".$time."</th>";
            }
        echo "</tr> ";
        echo "<tr>
            <th>Αριθμός Παραγγελίας</th>
            <th>Αριθμός Τραπεζιού</th>
            <th>Χρηματικό Πόσο</th>";
        //Print additional fields (depending on the search)
        if($situation=="All"){
            //It's means-> select all Orders,so we need a column for situations
            echo "<th>Κατάσταση</th>";
            $printSituations=true;
        }
        if($staff=="Everybody"){
            echo "<th>Υπάλληλος</th>";
            $printNames=true;
        }
        echo "<th>Ημερομηνία</th>";
        echo "</tr>";

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            //If date from order belongs in search time frame
            if($OldestDate<=$row['OrderDay']){
                $flname= $EmpList[$row['EmployeeID']];
                //Print selected orders
                $PrintOrder=FALSE;
                //if select all situations && all staffs
                if($printSituations && $printNames){
                    $HaveResults=true;
                    echo "<tr>";
                    echo "<td>".$row['OrderID']."</td>";
                    echo "<td>".$row['TableNumber']."</td>";
                    echo "<td>".$row['TotalAmmount']."</td>";
                    echo "<td>".$row['OrderSituation']."</td>";
                    echo "<td>".$flname."</td>";
                    echo "<td>".$row['OrderDay']."</td>";
                    echo "</tr>";
                    $PrintOrder=TRUE;
                    
                }elseif($printSituations && !$printNames){
                    //Select all situations and one employee
                    if($row['EmployeeID']==$staff){
                        $HaveResults=true;
                        echo "<tr>";
                        echo "<td>".$row['OrderID']."</td>";
                        echo "<td>".$row['TableNumber']."</td>";
                        echo "<td>".$row['TotalAmmount']."</td>";
                        echo "<td>".$row['OrderSituation']."</td>";
                        echo "<td>".$row['OrderDay']."</td>";
                        echo "</tr>";
                        $PrintOrder=TRUE;
                        
                    }

                }elseif(!$printSituations && $printNames){
                    if($row['OrderSituation']==$situation){
                        $HaveResults=true;
                        //select all employees and one situation
                        echo "<tr>";
                        echo "<td>".$row['OrderID']."</td>";
                        echo "<td>".$row['TableNumber']."</td>";
                        echo "<td>".$row['TotalAmmount']."</td>";
                        echo "<td>".$row['OrderDay']."</td>";
                        echo "<td>".$flname."</td>";
                        echo "</tr>";
                        $PrintOrder=TRUE;
                        
                    }

                }else{
                    //Select one situation and one employee
                    if($row['OrderSituation']==$situation && $row['EmployeeID']==$staff){
                        $HaveResults=true;
                        echo "<tr>";
                        echo "<td>".$row['OrderID']."</td>";
                        echo "<td>".$row['TableNumber']."</td>";
                        echo "<td>".$row['TotalAmmount']."</td>";
                        echo "<td>".$row['OrderDay']."</td>";
                        echo "</tr>";
                        $PrintOrder=TRUE;
                    }
                }

                if($PrintOrder && $row['OrderSituation']=="Ολοκληρωμένη"){
                    $returnValue+=$row['TotalAmmount'];
                }
                
            }
        }

        //If dont have results, print "No Orders for this search"
        if(!$HaveResults){
            echo "<tr><th colspan='9' style='color:red'>No Orders for this search</th></tr>";    
        }
       
    }else{
        echo "<tr><th colspan='9'>No results</th></tr>";
    }
    echo "</table>";
    
    return $returnValue;

}

//Print sunolika esoda anazitis

function printSearchTotalAmmount($ammount,$time){

    echo "<table  cellspacing='2'>";
    echo "<tr>";
        echo "<th>Συνολικά Έσοδα ".$time."</th>";
        echo "<th style='color:red'><<".$ammount.">></th>";
    echo "</tr>";
echo "</table>";
}

//=============================================================================================//





?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Κεντρική Σελίδα Πωλήσεων</h1>
        </header>
        <main>
            <article>
                <section>
                    <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <table border='1px solid' cellspacing='0'>
                            <tr>
                                <th colspan='1'>Συνολικές Πωλήσεις 
                                    <select name='timeO'>
                                        <option value='Ημέρας'>Ημέρας</option>
                                        <option value='Εβδομάδας' >Εβδομάδας</option>
                                        <option value='Μήνα'>Μήνα</option>
                                        <option value='Τρίμηνου' >Τρίμηνου</option>
                                        <option value='Τετράμηνου' >Τετράμηνου</option>
                                        <option value='Εξάμηνου' >Εξάμηνου</option>
                                        <option value='Οκτάμηνου' >Οκτάμηνου</option>
                                        <option value='Έτους' >Έτους</option>
                                        <option value='10ετίας' >10ετίας</option>
                                    </select>
                                </th>
                                <th colspan='1'>Υπαλλήλου
                                    <select name='empO'>
                                        <option value='Everybody'>Ολόκληρου Προσωπικού</option>
                                        <?php
                                        //Print employees names
                                        foreach ($EmployeersNamesList as $am=>$name){
                                            echo "<option value='".$am."'>".$name."</option>";
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th colspan='1'>Κατάστασης 
                                    <select name='sitO'>
                                        <option value='All'>Όλες</option>
                                        <?php
                                        //Print employees names
                                        foreach ($OrdersSituationsList as $id=>$name){
                                            echo "<option value='".$name."'>".$name."</option>";
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th colspan='1'>
                                    <button name='searchButton'>Αναζήτηση</button>
                                </th>
                            </tr>
                        </table>
                    </form>
                </section>
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $DailyIncome=0;
                                //If user press search button , from form on top
                                if(isset($_POST['searchButton'])){
                                    $time=$_POST['timeO'];
                                    $staff=$_POST['empO'];
                                    
                                    $situation=$_POST['sitO'];
                                    $DailyIncome=printSelectedOrders($time,$staff,$situation);
                                    printSearchTotalAmmount($DailyIncome,$time);
                                    $AllQuantitiesSales=calculateDataForSalesGraphQuantityEdition($time);
                                    $AllTotalAmmounts=calculateDataForSalesGraphTotalAmmountEdition($time);
                                    $PersonList=calculateSalesForAnyPerson($time,'Ολοκληρωμένη','TotalAmmount');
                                    printGraphs($AllQuantitiesSales,$AllTotalAmmounts,$PersonList,$time);
                                }
                            }
                        ?>
                <section>
                </section>
            </article>
        </main>
        <footer>
            <a href="bossCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>