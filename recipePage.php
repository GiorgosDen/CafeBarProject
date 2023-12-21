<?php

//Find Basic Product/Variation of basic product
$ID=$_COOKIE['RecipeID'];//ID from product
$Name="";//Product Name
$Price=0.0;//Product Price
$BasicProductConn="";//For Variation ()

//-----------------------------------------------------------------------------------------//
$ProductsTable='ProductsTable';//Table with Basic products (*)
$VariationProductsTable='VariationProductsTable';//Table with variations products (*)
$servername='localhost';
$username='root';
$password='';
$dbName='ordersDataBase';
//-----------------------------------------------------------------------------------------//

//Create Connection

$conn = new mysqli($servername,$username,$password,$dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//if select Basic Product in previous page
if($_COOKIE['BasicOrVariation']=="B"){

    $sql ="SELECT * FROM ProductsTable WHERE ProductID=$ID";
    $result=$conn->query($sql);
    
    if ($result->num_rows > 0) {
        //Arxikopoiisi stoixeiwn proiontos
        while($row = $result->fetch_assoc()) {
            
            $Name=$row['ProductName'];
            $Price=$row['ProductPrice'];
        }
    }else{
        echo "No results1";
    }

}else{
    //Select Variation in previous page
    $BasicProductConn=$_COOKIE['BasicConnName'];
    $sql ="SELECT * FROM VariationProductsTable WHERE VID=$ID";
    $result=$conn->query($sql);

    if ($result->num_rows >= 0) {
        //Arxikopoiisi stoixeiwn proiontos
        while($row = $result->fetch_assoc()) {
            $Name=$row['VName'];
            $Price=$row['VPrice'];
        }
    }else{
        echo "No results2";
    }
}

///====================================================================================///

//Form Code Area

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['newMaterial'])){

        $MID=intval($_POST['newMaterial']);//Select Material ID

        if($_COOKIE['BasicOrVariation']=="B"){
            addToBasicRecipe($MID,$ID);
        }else{
            addToVariationRecipe($MID,$ID);
        }
    }

    if(isset($_POST['delete'])){
        $DID=$_POST['delete'];//Row ID pros delete

        if($_COOKIE['BasicOrVariation']=="B"){
            deleteFromBasicRecipe($DID,$ID);
        }else{
            deleteFromVariationRecipe($DID,$ID);
        }
    }
}


///==========================================================================///
//Functions AREA

function deleteFromBasicRecipe($DID,$ID){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $BasicRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql ="DELETE FROM BasicProductsMaterialsTable WHERE (ID=$DID AND PID=$ID)";
    if($conn->query($sql)===False){
        echo "Error ".$conn->error;
    }
}

function deleteFromVariationRecipe($DID,$ID){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $BasicRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="DELETE FROM VariationsProductsMaterialsTable WHERE (ID=$DID AND VID=$ID)";
    if($conn->query($sql)===False){
        echo "Error ".$conn->error;
    }
}

function addToBasicRecipe($MID,$ID){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $BasicRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql ="INSERT INTO BasicProductsMaterialsTable (PID,MID,Ratio)
    VALUES (".$ID.",".$MID.",0)";
    if($conn->query($sql)===False){
        echo "Error ".$conn->error;
    }
}

function addToVariationRecipe($MID,$ID){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $BasicRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="INSERT INTO VariationsProductsMaterialsTable (VID,MID,Ratio)
    VALUES ($ID,$MID,0)";
    if($conn->query($sql)===False){
        echo "Error ".$conn->error;
    }
}


function printBasicRecipe($SelectProductIDF){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $BasicRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //Take a table with connection Products & Materials
    $sql = "SELECT * FROM BasicProductsMaterialsTable
    INNER JOIN  MaterialsTable 
    ON MaterialsTable.MID=BasicProductsMaterialsTable.MID";

    
    $result=$conn->query($sql);
    if ($result->num_rows > 0) {
        //Print the recipe product
        echo "<form method='post' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>";
        while($row = $result->fetch_assoc()) {
            //Check if Material uses in select product
            if($row['PID']==$SelectProductIDF && $row['Ratio']>=0){
                echo "<tr>";
                echo "<td>".$row['MID']."</td>";
                echo "<td>".$row['MName']."</td>";
                echo "<td>".$row['Ratio']."</td>";
                echo "<td><button name='delete' value='".$row['ID']."'>Διαγραφή</button></td>";
                echo "</tr>";
                $BasicRecipeError=1;
            }
        }
        echo "</form>";
        echo "<br>";
    }
    if($BasicRecipeError==0){
        echo "Error with Basic product recipe<br>";
        echo $conn->error."<br>";
    }
}



function printVariationRecipe($SelectVariationIDF){
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $VarRecipeError=0;
    $conn = new mysqli($servername,$username,$password,$dbName);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //Take a table with connection SelectVariationProduct & Materials
    $sql = "SELECT * FROM MaterialsTable
    INNER JOIN VariationsProductsMaterialsTable
    ON MaterialsTable.MID=VariationsProductsMaterialsTable.MID";

    $result=$conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<form method='post' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>";
        //Print the recipe product
        while($row = $result->fetch_assoc()) {
            //Check if Material uses in select variation of product
            if($row['VID']==$SelectVariationIDF && $row['Ratio']>=0){
                echo "<tr>";
                echo "<td>".$row['MID']."</td>";
                echo "<td>".$row['MName']."</td>";
                echo "<td>".$row['Ratio']."</td>";
                echo "<td><button name='delete' value='".$row['ID']."'>Διαγραφή</button></td>";
                echo "</tr>";
                $VarRecipeError=1;
            }
        }
        echo "</form>";
    }
    if($VarRecipeError==0){
        echo "Error with Variation product recipe<br>";
    }
}

///========================================================================================///

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Συνταγή <<<?php echo $BasicProductConn." ".$Name."(".$ID.") ";?>>></h1>
        </header>
        <main>
            <article>
                <section>
                    <table border='4' cellspacing='0'>
                        <tr>
                            <td colspan=3>Υπάρχουσα Συνταγή</td>
                        </tr>
                        <tr>
                            <td>ID(Πόρου)</td>
                            <td>Όνομα Πόρου</td>
                            <td>Ποσότητα</td>
                            <td>    </td>
                        </tr>
                        <?php

                            if($_COOKIE['BasicOrVariation']=="B"){
                                printBasicRecipe($ID);
                            }else{
                                printVariationRecipe($ID);
                            }

                        
                        ?>
                    </table>
                </section>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <?php
                            
                            $conn = new mysqli($servername,$username,$password,$dbName);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            echo "<h2>Διαθέσιμα Υλικά</h2>";


                            $sql ="SELECT * FROM MaterialsTable";
                            if($conn->query($sql)===FALSE){
                                echo "Error: ".$conn->error."<br>";
                            }

                            $result=$conn->query($sql);

                            if($result->num_rows>0){
                                //Show all Materials
                                $N=1;//Number of Materials per row
                                while($row = $result->fetch_assoc()){

                                    echo "<button name='newMaterial' value='".$row['MID']."'>".$row['MName']."</button>";
                                    $N+=1;

                                    //if print 4 Materials
                                    if($N>4){
                                        echo "<br>";//Chnage row
                                        $N=1;
                                    }
                                }
                            }


                        ?>
                    </form>
                </section>
            </article>
        </main>
        <footer>
            <a href="selectProduct.php">Επιστροφή</a>
        </footer>
    </body>
</html>