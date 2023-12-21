<?php
$servername='localhost';
$username='root';
$password='';
$dbName='ordersDataBase';
$ProductsTable='ProductsTable';
$MaterialsTable='MaterialsTable';//Table with materials for production products(*)
$BasicProductsMaterialsTable='BasicProductsMaterialsTable';//Connection between basic Products & Materials(*)
$VariationsProductsMaterialsTable='VariationsProductsMaterialsTable';//Connection between Variations products & Materials(*)
//Table with Basic products (*)                                
$CatProducts='CategoriesProducts';//Table wiht categories product (*)                                
$categoriesList=array();//List with category product
//=======================================================================================//


//Functions area

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
                echo "<li>".$row['MName'].", <input type='text' size='5' name='".$row['ID']."' value='".$row['Ratio']."'></li> <button name='changeratio' value='".$row['ID']."'>Αλλαγή</button>";
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
                echo "<li>".$row['MName'].", <input type='text' size='5' name='".$row['ID']."' value='".$row['Ratio']."'></li> <button name='changeratio' value='".$row['ID']."'>Αλλαγή</button>";
                $VarRecipeError=1;
            }
        }
        echo "</form>";
    }
    if($VarRecipeError==0){
        echo "Error with Variation product recipe<br>";
    }
}

function changeRatio($SPID,$SVID,$NewRatio,$rowID){
    //echo "<h1>".$SVID."</h1>";
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

    //$SVID==-1 means : No variation product select
    $NewRatio1=floatval($NewRatio);
    if($SVID==-1){
        $sql ="UPDATE BasicProductsMaterialsTable SET Ratio=$NewRatio1 WHERE PID=$SPID AND ID=$rowID";
        if($conn->query($sql)===FALSE){
            echo $conn->error;
        }
        
    }else{
        $sql ="UPDATE VariationsProductsMaterialsTable SET Ratio=$NewRatio1 WHERE ID=$rowID";
        
        if($conn->query($sql)===FALSE){
            echo $conn->error;
        }
    }
}

function deleteVariation($VID){

    //$F=Flag Variable, if variation delete -> $F=TRUE else $F+FALSE 
    $F=TRUE;

    //server data
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $VariationProductsTable='VariationProductsTable';//Table with variations products (*)
    $VariationsBaseProductsTable='VariationsBaseProductsTable';//Table who connect Variations with Basic Products(*)
    $VariationsProductsMaterialsTable='VariationsProductsMaterialsTable';//Connection between Variations products & Materials(*)
    $conn = new mysqli($servername,$username,$password,$dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Delete Variation from VariationsBaseProductsTable
    $sql = "DELETE FROM VariationsBaseProductsTable WHERE VID=$VID";
    if($conn->query($sql)===FALSE){
        $F=FALSE;
        echo "Error VariationsBaseProductsTable ".$conn->error."<br>";
    }else{
        //if delete Variation from first table
        //The delete Variation from VariationsProductsMaterialsTable
        $sql = "DELETE FROM VariationsProductsMaterialsTable WHERE VID=$VID";
        if($conn->query($sql)===FALSE){
            $F=FALSE;
            echo "Error VariationProductsMaterialsTable ".$conn->error."<br>";
        }else{
            //if delete variation from all tables, then delete it from VariatiosTable,(last table)
            $sql = "DELETE FROM VariationProductsTable WHERE VID=$VID";
            if($conn->query($sql)===FALSE){
                $F=FALSE;
                echo "Error VariationProductsTable ".$conn->error."<br>";
            }
        }

    }

    //If delete comleted the variation ($F==TRUE) , print message
    if($F){
        echo "Variation Delete<br>";
    }

    //Refresh page

    header("Refresh:0");

}

//Control if basic product has Variations
//Product with Variations cant deleted
function checkForVariations($PID){

    //server data
    $servername='localhost';
    $username='root';
    $password='';
    $dbName='ordersDataBase';
    $VariationsBaseProductsTable='VariationsBaseProductsTable';//Table who connect Variations with Basic Products(*)
    $conn = new mysqli($servername,$username,$password,$dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql ="SELECT * FROM VariationsBaseProductsTable WHERE BID=$PID";
    if($conn->query($sql)===FALSE){
        echo $conn->error."<br>";
    }
    $result = $conn->query($sql);

    if($result->num_rows>0){
        //It's means basic product has variations
        return FALSE;
    }
    
    //Basic product hasn't variations
    return TRUE;

}

function deleteBasicProduct($BID){

    if(checkForVariations($BID)){
        //If basic product hasn't variations
        echo "<h1>".$BID."</h1>";
        $servername='localhost';
        $username='root';
        $password='';
        $dbName='ordersDataBase';
        $ProductsTable='ProductsTable';//Table with Basic products (*)
        $BasicProductsMaterialsTable='BasicProductsMaterialsTable';//Connection between basic Products & Materials(*)
        
        $conn = new mysqli($servername,$username,$password,$dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //Delete basic product from BasicProductsMaterialsTable

        $sql ="DELETE FROM BasicProductsMaterialsTable WHERE PID=$BID";
        if($conn->query($sql)===FALSE){
            echo "<h1>Error with Materials</h1>";
        }else{
            //if delete product connections with materials 
            $sql ="DELETE FROM ProductsTable WHERE ProductID=$BID";
            echo "<h1>".$BID."</h1>";
            if($conn->query($sql)===FALSE){
                echo "<h1>Error with BasicProduct</h1>";
            }   
        }


    }else{
        //Print message

        echo "Delete all varitiaions<br>";
    }
}

//==================================================//


//Find select Product with cookie: selectProductID

//Elements from product
$SelectProductID=intval($_COOKIE['SelectProductID']);
$SelectProductName="";
$SelectProductPrice;
$SelectProductCategory;
$SelectProductQuantity;

//Create Connection

$conn = new mysqli($servername,$username,$password,$dbName);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//Load categories in List
$sql = "SELECT * FROM $CatProducts";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    //import all categories
    while($row = $result->fetch_assoc()) {
        $categoriesList[$row['CategoryNumber']]=$row['CategoryName'];
    }
}
//Print products
$sql ="SELECT * FROM $ProductsTable WHERE ProductID=$SelectProductID";

$result=$conn->query($sql);
if ($result->num_rows > 0) {
    //print all products
    while($row = $result->fetch_assoc()) {
        $SelectProductName=$row['ProductName'];
        $SelectProductPrice=$row['ProductPrice'];
        $SelectProductCategory=$categoriesList[$row['ProductCategory']];
        $SelectProductQuantity=$row['ProductQuantity'];
    }
}else{
    echo $conn->error;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Προιόν << <?php echo $SelectProductName;?> >></h1>
        </header>
        <main>
            <article>
                <section>
                    <table border='4' cellspacing='0'>
                        <tr>
                            <th colspan='8'>Σύνοψη Προιόντος</th>
                        </tr>
                        <tr>
                            <th>Κωδικός</th>
                            <th>Όνομα</th>
                            <th>Κατηγορία</th>
                            <th>Τιμή</th>
                            <th>Απόθεμα (εκτίμηση)</th>
                            
                        </tr>
                        <tr>
                            <td><?php echo $SelectProductID;?></td>
                            <td><?php echo $SelectProductName;?></td>
                            <td><?php echo $SelectProductCategory;?></td>
                            <td><?php echo $SelectProductPrice;?></td>
                            <td><?php echo $SelectProductQuantity;?></td>
                            
                        </tr>
                    </table>
                </section>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <button name="recipe">Συνταγή</button>
                        <button name="BRbutton" value=<?php echo $SelectProductID?>>Προσθήκη Πόρου</button>
                        <button name="DBbutton" value=<?php echo $SelectProductID?>>Διαγραφή</button>
                    </form>
                </section>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <table border='4' cellspacing='0'>
                            <tr>
                                <th colspan='8'>Παραλλαγές Προιόντος</th>
                            </tr>
                            <tr>
                                <th>Κωδικός</th>
                                <th>Όνομα</th>
                                <th>Τιμή</th>
                                <th>Περιγραφή</th>
                                <th>    </th>
                                <th>    </th>
                                <th>    </th>
                            </tr>
                            <?php
                                $VariationProductsTable="VariationProductsTable";
                                $servername='localhost';
                                $username='root';
                                $password='';
                                $dbName='ordersDataBase';

                                $conn = new mysqli($servername,$username,$password,$dbName);
                                // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                //Load categories in List
                                $sql = "SELECT * FROM $VariationProductsTable WHERE BID=$SelectProductID";
                                $result=$conn->query($sql);
                                if ($result->num_rows > 0) {
                                    //import all categories
                                    while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['VID']."</td>";
                                    echo "<td>".$row['VName']."</td>";
                                    echo "<td>".$row['VPrice']."</td>";
                                    echo "<td>".$row['VDescription']."</td>";
                                    echo "<td><button name='Vbutton' value='".$row['VID']."'>Επιλογή</button></td>";
                                    echo "<td><button name='RVbutton' value='".$row['VID']."'>Προσθήκη Πόρου</button></td>";
                                    echo "<td><button name='DELbutton' value='".$row['VID']."'>Διαγραφή Παραλλαγής</button></td>";
                                    echo "</tr>";
                                    }
                                }else{
                                    echo "<tr><th colspan='8' style='color:red'>Not Found for this Product :(</th></tr>";
                                }$conn = new mysqli($servername,$username,$password,$dbName);
                                // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    
                            ?>
                        </table>
                        <button type='submit' name='newVar'>Νέα Παραλλαγή</button>
                    </form>
                </section>
                <section>
                    <h2>Συνταγή</h2>
                    <list>
                        <?php

                            if($_SERVER["REQUEST_METHOD"] == "POST"){

                                //if want delete basic product
                                if(isset($_POST['DBbutton'])){
                                    deleteBasicProduct($_POST['DBbutton']);
                                }

                                //If want create new Variation

                                if(isset($_POST['newVar'])){
                                    setcookie("BasicConnName",$SelectProductName);//BasicConnName , transport Basic ProductName to createNewVariation.php
                                    header("Location: createNewVariationProduct.php");//Move to createNewVariationProduct.php
                                }

                                //if want delete some variation

                                if(isset($_POST['DELbutton'])){
                                    deleteVariation($_POST['DELbutton']);
                                }
                                
                                //Cookie ==1 set SelectVariationID, else no
                                if($_COOKIE['SelectVariationRecipe']==1){
                                    $SelectVariationID=-1;
                                    setcookie("SelectVariationRecipe",2);
                                }
                                $VarRecipeError=$BasicRecipeError=0;
                                    $conn = new mysqli($servername,$username,$password,$dbName);
                                    // Check connection
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                    }
                                if(isset($_POST['recipe'])){

                                    printBasicRecipe($SelectProductID);
                                    setcookie("SelectVariationRecipe",1);
                                }
                                if(isset($_POST['Vbutton'])){
                                    
                                    //If select some Variation product
                                    $SelectVariationID= $_POST['Vbutton'];
                                    //setcookie("svid",$SelectVariationID);
                                    printBasicRecipe($SelectProductID);
                                    printVariationRecipe($SelectVariationID);
                                    
                                }
                                if(isset($_POST['changeratio'])){
                                    changeRatio($SelectProductID,$SelectVariationID,floatval($_POST[$_POST['changeratio']]),$_POST['changeratio']);
                                    
                                    setcookie("SelectVariationRecipe",1);
                                }

                                //Select add material in basic product recipe
                                if(isset($_POST['BRbutton'])){
                                    $RID=$SelectProductID;//RID recipe ID, (id from basic product or variation of basic product)
                                    setcookie("RecipeID",$RID);//RecipeID cookie, transpot ID from Basic/Variation Product to recipe.php
                                    setcookie("BasicOrVariation","B");//If is B ->basic product , else V ->variation
                                    header("Location: recipePage.php");//Move to recipePage.php
                                }

                                //Select add Material to Variation
                                if(isset($_POST['RVbutton'])){
                                    $RID=intval($_POST['RVbutton']);//Button with name RVbutton has Variation Id as value
                                    setcookie("RecipeID",$RID);//RecipeID cookie, transpot ID from Basic/Variation Product to recipe.php
                                    setcookie("BasicOrVariation","V");//If is B ->basic product , else V ->variation
                                    setcookie("BasicConnName",$SelectProductName);//BasicConnName , transport Basic ProductName to recipe.php
                                    header("Location: recipePage.php");//Move to recipePage.php
                                }
                            }
                        ?>
                    </list>
                </section>
            </article>
        </main>
        <footer>
            <a href="productsPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>