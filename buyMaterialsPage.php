<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Αγορά Πόρου: <?php echo $_COOKIE['selectMaterialName'];?></h1>
        </header>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $materialOldQuantity;//Yparxousa posotita proiontos
                $materialNewQuantity;//materialNeQuantity = materialOldQuantity+materialAddQuantity
                $materialAddQuantity=$_POST['quantity'];//Posotita pou agorastike
                $cost=$_POST['TotalCost'];//Sunoliko kostos agoras
                $matID=$_COOKIE['selectMaterial'];

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

                //Find material and update their quantity
                $sql="SELECT * FROM $MaterialsTable WHERE MID=$matID";
                $result=$conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $materialOldQuantity=$row['MQuantity'];//Find old quantity
                    }
                }

                //Update quantity
                $materialNewQuantity=$materialAddQuantity+$materialOldQuantity;

                //Update data base
                $sql ="UPDATE MaterialsTable SET MQuantity=$materialNewQuantity WHERE MID=$matID";
                if($conn->query($sql)===TRUE){
                    echo "Επιτυχής Αγορά ".$materialAddQuantity." μονάδων<br>";
                    echo "Με Κόστος ".$cost."<br>";
                    echo "Το απόθεμα από ".$materialOldQuantity." έγινε ".$materialNewQuantity;

                }else{
                    echo $conn->error;
                }
            }
        ?>
        <main>
            <article>
                <section>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <p>Ποσότητα:</p>
                        <input type="number" name="quantity" value="5">
                        <p>Κόστος ανά Μονάδα:</p>
                        <input type="text" name="cost" value="0">
                        <p>Προμηθευτής:</p>
                        Α:<input type="radio" value="A Προμηθευτής">
                        Β:<input type="radio" value="Β Προμηθευτής">
                        Γ:<input type="radio" value="Γ Προμηθευτής">
                        <p>Συνολικό Κόστος:</p>
                        <input type="text" name="TotalCost" value="0">
                        <br>
                        <input type="submit" value="Αγορά">
                    </form>
                </section>
            </article>
        </main>
        <footer>
            <a href="materialPage.php">Επιστροφή</a>
        </footer>
    </body>
</html>