<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body>
        <header>
            <h1>Σελίδα Προσθήκης Νέου Πόρου</h1>
        </header>
        
        <main>
            <article>
                <section>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            $nameError=$minmaxError=$massError=$unionError=$minError=$maxError="";//Errors Messages

                            $f=0;//Variable gia tin metrisi sunthikwn pou isxuoun 

                            $newMaterialName=$_POST['mName'];
                            $newMaterialMin=intval($_POST['min']);
                            $newMaterialMax=intval($_POST['max']);
                            $newMaterialMass=floatval($_POST['mass']);
                            $newMaterialUnion=$_POST['union'];

                            //Check if minimum Quainty< maximum Quantity
                            if($newMaterialMin<$newMaterialMax){
                                $f+=1;
                            }else{
                                $minmaxError="*Μέγιστη Αποδεκτή Ποσότητα < Ελάχιστης";
                                $minError=$newMaterialMin;
                                $maxError=$newMaterialMax;
                            }
                            //Check if import Mass select 
                            if(gettype($newMaterialMass)!=NULL && $newMaterialMass>0){
                                $f+=1;
                            }else{
                                $massError="*Προσθέστε μάζα";
                            }
                            //Check if Union select
                            if($newMaterialUnion=="kg" || $newMaterialUnion=="L"){
                                $f+=1;
                            }else{
                                $unionError="*Επιλέξτε Μονάδα Μέτρησης";
                            }

                            //Check if user import name
                            if($newMaterialName!=""){
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

                                $sql="SELECT * FROM $MaterialsTable WHERE MName='".$newMaterialName."'";
                                $result=$conn->query($sql);
                                //if found Material with same name...
                                if ($result->num_rows > 0) {
                                    //Check if found Material with same weight & measurement unit, if dont then f=f+1
                                    $same=0;//same=0-> Not found material with same name && unit
                                    while($row = $result->fetch_assoc()) {
                                        if($row['Mmass']==$newMaterialMass && $row['MmeasurementUnit']==$newMaterialUnion){
                                            $same=1;
                                            $nameError="*Υπάρχει ήδη ο πόρος";
                                            break;
                                        }
                                    }
                                    if($same==0){
                                        $f+=1;
                                    }
                                }else{
                                    $f+=1;
                                }
                                //Afou eginan oloi oi elegxoi prosthetoumai to neo material,efoson plirountai oi periosmoi
                                if($f>=4){
                                    $add="INSERT INTO $MaterialsTable (MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
                                    VALUES ('".$newMaterialName."',0,".$newMaterialMin.",".$newMaterialMax.",".$newMaterialMass.",'".$newMaterialUnion."')";
                                    if($conn->query($add)===TRUE){
                                        echo "<h2>Επιτυχής Προσθήκη Πόρου...</h2>";
                                        echo "Name: ".$newMaterialName."<br>";
                                        echo "Min: ".$newMaterialMin."<br>";
                                        echo "Max: ".$newMaterialMax."<br>";
                                        echo "Mass: ".$newMaterialMass."<br>";
                                        echo "Union: ".$newMaterialUnion."<br>";
                                    }else{
                                        echo "ERORR FUCK: ".$conn->erorr;
                                    }
                                }
                            }else{
                                $nameError="*Προσθέστε όνομα";
                            }
                        }
                    ?>
                </section>
                <section>
                    <h2>Εισαγωγή Νέου Πόρου</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <p>Όνομα Πόρου: <span style="color:red;"><?php echo $nameError?></span></p>
                        <input type="text" name="mName" value="">
                        <p>Ελάχιστη Αποδεκτή Ποσότητα: <span style="color:red;"><?php echo $minmaxError?></span></p>
                        <input type="number" name="min" value="5"><span style="color:red;"><?php echo $minError?></span>
                        <p>Μέγιστη Αποδεκτή Ποσότητα:</p>
                        <input type="number" name="max" value="10"><span style="color:red;"><?php echo $maxError?></span>
                        <p>Μάζα ανά Τεμάχιο: <span style="color:red;"><?php echo $massError?></span></p>
                        <input type="text" name="mass">
                        <p>Μονάδα Μέτρησης: <span style="color:red;"><?php echo $unionError?></span></p>
                        kg:<input type="radio" name="union" id="unionID" value="kg">
                        L:<input type="radio" name="union" id="unionID" value="L">
                        <br>
                        <br>
                        <input type="submit" value="Προσθήκη">
                    </form>
                </section>
            </article>
        </main>
        <footer>
            <a href="StorageCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>