<?php
$SelectMaterialID=$_COOKIE['selectMaterial'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body>
        <header>
            <h1>Λεπτομερής Προβολή Πόρου</h1>
        </header>
        <section>
            <?php
                 if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $servername='localhost';
                    $username='root';
                    $password='';
                    $dbName='ordersDataBase';
                    $MaterialsTable='MaterialsTable';//Table with materials for production products(*)
                    $VariationProductsTable='VariationProductsTable';//Table with variations products (*)
                //$BasicProductsMaterialsTable='BasicProductsMaterialsTable';//Connection between basic Products & Materials(*)
                $VariationsBaseProductsTable='VariationsBaseProductsTable';
                $VariationsProductsMaterialsTable='VariationsProductsMaterialsTable';//Connection between Variations products & Materials(*)
                    //Create Connection
                    $conn = new mysqli($servername,$username,$password,$dbName);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if(isset($_POST['update'])){
                        $min=intval($_POST['min']);
                        $max=intval($_POST['max']);
                        $someID=intval($_COOKIE['selectMaterial']);
                        if($min<$max){
                            $sql ="UPDATE MaterialsTable SET Mmin=$min,Mmax=$max WHERE MID=$someID";
                            if($conn->query($sql)===TRUE){
                            }else{
                               echo "Error: ".$conn->error;
                            }
                        }else{
                            echo "Μέγιστη Αποδεκτή Ποσότητα < Ελάχιστης";
                        }
                    }
                    if(isset($_POST['buy'])){
                        
                        header("Location: buyMaterialsPage.php");
                        
                    }
                    if(isset($_POST['delete'])){
                        $P=0;
                        //Check for connections with products, and delete they
                        $sql ="DELETE FROM BasicProductsMaterialsTable WHERE MID=$SelectMaterialID";
                        if($conn->query($sql)===FALSE){
                            echo "<h1>".$conn->error." 11</h1>";
                            $P+=1;
                        }
                        $sql ="DELETE FROM VariationsProductsMaterialsTable WHERE MID=$SelectMaterialID";
                        if($conn->query($sql)===FALSE){
                            echo "<h1>".$conn->error." 22</h1>";
                            $P+=2;
                        }

                        if($P==0){
                            //Delete from Materials table
                        $sql = "DELETE FROM MaterialsTable WHERE MID=$SelectMaterialID";
                        if($conn->query($sql)===FALSE){
                            echo "<h1>".$conn->error." 33</h1>";
                        }
                        }

                    }
                    if(isset($_POST['ratio'])){
                        //Upadate select row ratio
                        $SelectRow=$_POST['ratio'];//Save the number of row, has ratio's change
                        $NewRatio=floatval($_POST[$SelectRow]);//Save new ratio in variable
                        //Update Table
                        $sql = "UPDATE VariationsProductsMaterialsTable SET Ratio=$NewRatio WHERE ID=$SelectRow"; 

                        if($conn->query($sql)===TRUE){
                            //echo "COMPLEDOYRA";
                        }
                    }
                }
            ?>
            <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <?php
                    $SelectMaterialName;
                    $SelectMaterialQuantity;
                    $SelectMaterialMin;
                    $SelectMaterialMax;
                    $SelectMaterialMass;
                    $SelectMaterialMeasurementUnit;

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

                    $sql="SELECT * FROM $MaterialsTable WHERE MID=$SelectMaterialID";
                    $result=$conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $SelectMaterialName=$row['MName'];
                            setcookie('selectMaterialName',$SelectMaterialName);
                            $SelectMaterialQuantity=$row['MQuantity'];
                            $SelectMaterialMin=$row['Mmin'];
                            $SelectMaterialMax=$row['Mmax'];
                            $SelectMaterialMass=$row['Mmass'];
                            $SelectMaterialMeasurementUnit=$row['MmeasurementUnit'];
                        }
                    }

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
                    echo "<tr>
                            <td>".$SelectMaterialID."</td>
                            <td>".$SelectMaterialName."</td>
                            <td>".$SelectMaterialQuantity."</td>
                            <td><input name='min' type='text' value='".$SelectMaterialMin."'></td>
                            <td><input name='max' type='text' value='".$SelectMaterialMax."'></td>
                            <td>".$SelectMaterialMass."</td>
                            <td>".$SelectMaterialMeasurementUnit."</td>
                    </tr>";
                    echo "</table>";
                    $conn->close();
                    echo "<button name='update'>Ενημέρωση</button>
                    <button name='buy'>Αγορά</button>
                    <button name='delete'>Διαγραφή Πόρου</button>";
                    
                ?>
            <form>
        </section>
        <section>
            <h2>Παράγωγα Προιόντα</h2>
            <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <?php
                $servername='localhost';
                $username='root';
                $password='';
                $dbName='ordersDataBase';
                $ProductsTable='ProductsTable';
                $MaterialsTable='MaterialsTable';//Table with materials for production products(*)
                $VariationProductsTable='VariationProductsTable';//Table with variations products (*)
                $BasicProductsMaterialsTable='BasicProductsMaterialsTable';//Connection between basic Products & Materials(*)
                $VariationsBaseProductsTable='VariationsBaseProductsTable';
                $VariationsProductsMaterialsTable='VariationsProductsMaterialsTable';//Connection between Variations products & Materials(*)
                //Create Connection
                $conn = new mysqli($servername,$username,$password,$dbName);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //Ενωση πινκα με προιοντα και πινκα συνδεσης βασικων προιοντων-πόρων
                //$sqlb προιοντα συνδεδεμενα με τον πορο
                $sqlb="SELECT * FROM ProductsTable
                INNER JOIN BasicProductsMaterialsTable 
                ON BasicProductsMaterialsTable.PID=ProductsTable.ProductID 
                WHERE BasicProductsMaterialsTable.MID=$SelectMaterialID";
                $resultb=$conn->query($sqlb);

                if ($resultb->num_rows > 0) {

                    $FindBasicProduct=1;//Flag 
                    
                    echo "<table border='4' cellspacing='0'>";
                   //Ελεγχος αν το βασικό προιον και οι παραλαγες χρειαζονται τον πορο της σελιδας
                    while($rowb = $resultb->fetch_assoc()) {

                            //Print basic products,if exists
                            //Check if exists some basic product
                            if($rowb['MID']==$SelectMaterialID && $rowb['Ratio']>0){
                                if($FindBasicProduct==1){
                                    //Print table with product
                                    echo "<tr>
                                        <th>Κωδικός Προιόντος</th>
                                        <th>Όνομα Προιόντος</th>
                                        <th>Περιγραφή</th>
                                        <th>Απαιτούμενη Ποσότητα</th>
                                        <th></th>
                                    </tr>";
                                    $FindBasicProduct=2;
                                }
                                echo "<tr>
                                    <td>".$rowb['ProductID']."</td>
                                    <td>".$rowb['ProductName']."</td>
                                    <td> -- </td>
                                    <td>".$rowb['Ratio']."</td>
                                    <td>".$rowb['ProductID']."</td>
                                </tr>";
                            }

                            $PID=$rowb['PID'];
                            //Επιλογη ολων των παραγων που χρειαζονται τον πορο <<και ανηκουν στο βασικό προιον
                            $sql ="SELECT * FROM VariationProductsTable
                            INNER JOIN 
                            VariationsProductsMaterialsTable 
                            ON VariationProductsTable.VID=VariationsProductsMaterialsTable.VID
                            WHERE VariationsProductsMaterialsTable.MID=$SelectMaterialID AND VariationProductsTable.BID=$PID";
                            $result=$conn->query($sql);
                            if ($result->num_rows > 0) {
                                //Εφοσον ο πορος χρειαζεται στο προιν η σε καποια παραλλαγη
                                echo "<tr> <th colspan='4'>".$rowb['ProductName']."<<'Παραλλαγές του'>></th></tr>";
                                echo "<tr>
                                    <th>Κωδικός Προιόντος</th>
                                    <th>Όνομα Προιόντος</th>
                                    <th>Περιγραφή</th>
                                    <th>Απαιτούμενη Ποσότητα</th>
                                    <th></th>
                                </tr>";

                                while($row = $result->fetch_assoc()) {
                                        //Print all connections Variations (From BasicProduct) with Materials
                                        //Any table row has a text input ,for change-view ratio,
                                        //and has a submit button wiht ID number from VariationsProductsMaterialsTable
                                        //(ID is number of row)
                                        //! The input text has ID (from VariationsProductsMaterialsTable) as name
                                        echo "<tr>
                                            <td>".$row['VID']."</td>
                                            <td>".$row['VName']."</td>
                                            <td>".$row['VDescription']."</td>
                                            <td><input type='text' value='".$row['Ratio']."' name='".$row['ID']."'></td>
                                            <td><input type='submit' value='".$row['ID']."' name='ratio'></td>
                                        </tr>";
                                    
                                }   
                            }
                    }
                    echo "</table>";
                }else{
                    echo "<h1>No results 1h</h1>";
                }
            ?>
            </form>
        </section>
        <footer>
            <a href="StorageCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>