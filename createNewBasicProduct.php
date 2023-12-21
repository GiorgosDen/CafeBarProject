<?php

    //Globals 
    $CategoriesList=array();

    //Functions AREA
    function loadCategories($List){
        $servername='localhost';
        $username='root';
        $password='';
        $dbName='ordersDataBase';
        $CatProducts='CategoriesProducts';//Table wiht categories product (*)

        //Create Connection

        $conn = new mysqli($servername,$username,$password,$dbName);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM $CatProducts";
        $result = $conn->query($sql);

        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $List[$row['CategoryNumber']]=$row['CategoryName'];
            }
        }else{
            echo "ERROR with CATEGORIES<br>";
        }


        return $List;
    }

    //Check if user select some categorie
    function checkCategoryProduct($cat){

        //If dont select category
        if(strcmp($cat,"Some")==0){
            return FALSE;
        }

        return TRUE;

    }

    //Check if price is number>0
    function checkProductPrice($price){
        if($price==0){
            return FALSE;
        }

        return TRUE;
    }

    //Check if product (on selected category) with same name already exists
    function checkProductName($name,$cat){

        $cat = intval($cat);

        $servername='localhost';
        $username='root';
        $password='';
        $dbName='ordersDataBase';
        $ProductsTable='ProductsTable';//Table with Basic products (*)

        //Create Connection

        $conn = new mysqli($servername,$username,$password,$dbName);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //Take all product from select category

        $sql = "SELECT * FROM ProductsTable WHERE ProductCategory=$cat";
        if($conn->query($sql)===FALSE){
            echo $conn->error;
        }
        $result= $conn->query($sql);

        if($result->num_rows>0){
            //Check products , also find some with same name
            while($row = $result->fetch_assoc()){
                
                if(strcmp($row['ProductName'],$name)==0){
                    return FALSE;
                }
            }
        }

        //if going here, means doesnt exist product
        return TRUE;

    }

    //FORM AREA

    //Error messages
    $messC=$messN=$messP=$messS="";
    $NewProductCategory=$NewProductPrice=$NewProductName="";
    if($_SERVER['REQUEST_METHOD']=="POST"){

        //Flag, if $F==FALSE --> Error & not add new product
        $F=TRUE;

        //Control importing data

        //First check category
        if(!checkCategoryProduct($_POST['category'])){
            $messC="*Select Category!!";
            $F=FALSE;
        }else{
            //If category is correct, then check if product with same name & catgory exists
            if(!checkProductName($_POST['productName'],$_POST['category'])){
                $messN="*Product already exist";
                
                $F=FALSE;
            }

        }

        //If name & category is correct, check price
        $priceN=floatval($_POST['productPrice']);
        if(!checkProductPrice($priceN)){
            $messP="Price must be a number>0";
            $F=FALSE;
        }

        //If imported data are correct , and the new product
        if($F){
            $NewProductPrice=$priceN;
            $NewProductName=$_POST['productName'];
            $NewProductCategory=intval($_POST['category']);

            $servername='localhost';
            $username='root';
            $password='';
            $dbName='ordersDataBase';
            $ProductsTable='ProductsTable';//Table with Basic products (*)

            //Create Connection

            $conn = new mysqli($servername,$username,$password,$dbName);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //Add new product

            $sql ="INSERT INTO $ProductsTable (ProductName,ProductPrice,ProductCategory,ProductQuantity)
            VALUES ('".$NewProductName."',$NewProductPrice,$NewProductCategory,0)";

            if($conn->query($sql)===FALSE){
                $messS=$conn->error;
            }else{
                $messS="New Product Import!!!";
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
        <header>
            <h1>Δημιουργία Νέου Προιόντος</h1>
        </header>
        <main>
            <article>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        Όνομα Προιόντος:<br>
                        <input type="text" name="productName"><span style='color:red'><?php echo $messN;?></span><br>
                        Τιμή Προιόντος:<br>
                        <input type="text" name="productPrice"><span style='color:red'><?php echo $messP;?></span><br>
                        Κατηγορία Προιόντος:<span style='color:red'><?php echo $messC;?></span><br>
                        <select name='category'>
                            <option value='Some'>Επιλογή Κατηγορίας</option>
                                <?php
                                //Load Categories
                                $CategoriesList=loadCategories($CategoriesList);
                                //Print Categories names
                                foreach ($CategoriesList as $am=>$name){
                                    echo "<option value='".$am."'>".$name."</option>";
                                }
                                ?>
                        </select>
                        <br> 
                        <input type="submit">
                    </form>
                </section>
                <section>
                    <span style="color:green"><?php echo $messS?></span>
                </section>
            </article>
        </main>
        <footer>
            <a href="productsPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>