<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        setcookie("SelectProductID",$_POST['id']);//Save Id from select product
        setcookie("SelectVariationRecipe",1);//Cookie used in selectProduct.php,  if is 1 set VID, else no
        header("Location: selectProduct.php");//Move to selectProductPage
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Σελίδα Προιόντων</h1>
        </header>
        <main>
            <article>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <table border='4' class='stats' cellspacing='0'>
                            <tr>
                                <td colspan='8'>Προιόντα</td>
                            </tr>
                            <tr>
                                <td>Κωδικός</td>
                                <td>Όνομα</td>
                                <td>Κατηγορία</td>
                                <td>Τιμή</td>
                                <td>Ποσότητα(εκτίμηση)</td>
                                <td>    </td>
                            </tr>
                            <?php
                                $servername='localhost';
                                $username='root';
                                $password='';
                                $dbName='ordersDataBase';
                                $ProductsTable='ProductsTable';//Table with Basic products (*)
                                $CatProducts='CategoriesProducts';//Table wiht categories product (*)

                                $categoriesList=array();//List with category products
                                $productsPerCategory=array();//List with number products for any category
                                $numberOfProducts=0;//All products number

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
                                        $categoriesList[$row['CategoryNumber']]=$row['CategoryName'];//Load category in List
                                        $productsPerCategory[$row['CategoryNumber']]=0;//Initialization List : productsPerCategory
                                    }
                                }
                                //Print products
                                $sql ="SELECT * FROM $ProductsTable ORDER BY ProductCategory";
                                $result=$conn->query($sql);
                                if ($result->num_rows > 0) {
                                    //print all products
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row['ProductID']."</td>";
                                        echo "<td>".$row['ProductName']."</td>";
                                        echo "<td>".$categoriesList[$row['ProductCategory']]."(".$row['ProductCategory'].")</td>";
                                        echo "<td>".$row['ProductPrice']."</td>";
                                        echo "<td>".$row['ProductQuantity']."</td>";
                                        echo "<td><input type='submit' value='".$row['ProductID']."' name='id'></td>";
                                        echo "</tr>";
                                        //Update number of total products
                                        $numberOfProducts+=1;
                                        //Update number products per any category
                                        $productsPerCategory[$row['ProductCategory']]+=1; 
                                    }
                                }
                            ?>
                        </table>
                    </form>
                </section>
                <section>
                    <button onclick="location.href='createNewBasicProduct.php';">Προσθήκη Προιόντος</button>
                </section>
                <section>
                    <h2>Συνολικά Προιόντα = <?php echo $numberOfProducts;?></h2>
                            <table border='4' class='stats' cellspacing='0'>
                                <tr>
                                    <th colspan='8'>Ανά Κατηγορία</th>
                                </tr>
                                <tr>
                                    <th>Κωδικός</th>
                                    <th>Όνομα</th>
                                    <th>Αριθμός Προιόντων</th>
                                </tr>
                                <?php
                                    foreach($productsPerCategory as $i=>$value){
                                        echo "<tr>";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$categoriesList[$i]."</td>";
                                        echo "<td>".$value."</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                </section>
            </article>
        </main>
        <footer>
            <a href="bossCentralPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>