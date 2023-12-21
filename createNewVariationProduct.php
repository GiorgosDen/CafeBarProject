<?php

    //Warnings variables, show warnigs on bottom to page

    $ErrorNameMessage="";
    $ErrorPriceMessage="";
    $ErrorDescriptionMessage="";


    //Functions AREA

    function checkName($name){

        if(strlen($name)==0){
            //If name is null or unknow type
            $ErrorNameMessage="Error with Variation name";
            return FALSE;
        }else{
            //If name is not null or unknow type, check if basic product has Variation with same name
            
            //Server data
            $servername='localhost';
            $username='root';
            $password='';
            $dbName='ordersDataBase';
            $VariationsBaseProductsTable='VariationsBaseProductsTable';//Table who connect Variations with Basic Products(*)
           
            //Create Connection

            $conn = new mysqli($servername,$username,$password,$dbName);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql= "SELECT * FROM $VariationsBaseProductsTable WHERE PID=$BasicproductID AND VName='".$name."'";
            $result=$conn->query($sql);

            if($result->num_rows>0){
                //It's means : basic product has already a variation with same name
                $ErrorNameMessage="Variation with this name, already exist";
                return FALSE;
            }else{
                //Name is correct and Product hoesn't Variation with same name
                return TRUE;
            }
                    
        }

        return FALSE;
        
    }

    function checkPrice($price){

        if($price<0){
            
            $ErrorPriceMessage="Error with Variation price";
            return FALSE;
        }

        return TRUE;
    }

    function checkDescription($des){

        if(strlen($des)==0){
            $ErrorDescriptionMessage="Add description";
            return FALSE;
        }

        return TRUE;
    }

    //=================================================================================================//

    //Set Basic Product ID, and name

    $BasicproductID=intval($_COOKIE['SelectProductID']);//Cookie from previous page
    $BasicproductName=$_COOKIE['BasicConnName'];//Cookie from previous page

    //Form code

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Variation data
        $NewVariationName=$_POST['name'];
        $NewVariationPrice=floatval($_POST['price']);
        $NewVariationDescription=$_POST['description'];

        //Connect to server and and variation

        //Connect

        $servername='localhost';
        $username='root';
        $password='';
        $dbName='ordersDataBase';

        $VariationProductsTable='VariationProductsTable';//Table with variations products (*)
        $VariationsBaseProductsTable='VariationsBaseProductsTable';//Table who connect Variations with Basic Products(*)
        
        //Create Connection

        $conn = new mysqli($servername,$username,$password,$dbName);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //If name is correct (not null and Product doesn't variation with same name)
        //,price is usinged and not null and description is not NULL
        //Add Variation to VariationsProducts and to VariationsBasicsProducts Tables

        if(checkName($NewVariationName) && checkPrice($NewVariationPrice) && checkDescription($NewVariationDescription)){
            //Add new record to variationstable
            $sql = "INSERT INTO VariationProductsTable (VName,VPrice,VDescription,BID)
                VALUES ('".$NewVariationName."',".$NewVariationPrice.",'".$NewVariationDescription."',".$BasicproductID.")";
            if($conn->query($sql)===FALSE){
                echo "<h1>".$conn->error."</h1>";
            }else{
                //if add new record to variations products table
                $last_id = $conn->insert_id;
                $sql = "INSERT INTO VariationsBaseProductsTable (VName,VID,BName,BID)
                VALUES ('".$NewVariationName."',".$last_id.",'".$BasicproductName."',".$BasicproductID.")";

                if($conn->query($sql)===FALSE){
                    echo "<h1>".$conn->error."</h1>";
                }else{
                    echo "New Variation Create!!!";
                }
            }
        }

            
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body>
        <main>
            <h1>Δημιουργία Νέας Παραλλαγής</h1>
            <p>Προιόν: <?php echo $BasicproductName;?> </p>
            <article>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        Name: <input type="text" name="name"><br>
                        Price: <input type="text" name="price"><br>
                        Description: <br><textarea name="description" cols='20' rows='5'></textarea><br>
                        <br>
                        <input type="submit" name="sub">
                    </form>
                </section>
                <section>
                    <?php

                    ?>
                </section>
            </article>
        </main>
        <footer>
            <a href="selectProduct.php">Επιστροφή</a>
        </footer>
    </body>
</html>