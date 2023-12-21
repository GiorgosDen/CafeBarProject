<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body>
        <article>
            <h1>Σχόλια Παραγγελίας <<<?php echo $_COOKIE['IDfromOrder'];?>>></h1>
            <?php
                $orderComments="No comments yet";
                $message="";
                $servername='localhost';
                $username='root';
                $password='';
                $dbName='ordersDataBase';
                $ordID=$_COOKIE['IDfromOrder'];
                $FinEmpOrders = 'FinEmpOrdersTable';//Correct Table for any Employeer daily order (*)

                $conn = new mysqli($servername,$username,$password,$dbName);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM $FinEmpOrders WHERE OrdID=$ordID";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()){
                    $orderComments=$row['comments'];
                }


            
            ?>
            <section>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <p><?php echo strlen($orderComments);?>/100 χαρακτήρες</p>
                    <textarea name='comm' rows='5' cols='20'><?php echo $orderComments;?></textarea>
                    <br>
                    <input type='Submit' value='Υποβολή'>
                    <br>
                    <a href="ordersManager.php">Προβολή παραγγελίας</a>
                    <a href="empCentralPage.php">Επιστροφή στην αρχική</a>
                </form>
            </section>
        </article>

        <?php

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                $newCommnets=$_POST['comm'];

                $sql= "UPDATE FinEmpOrdersTable SET comments='".$newCommnets."' WHERE OrdID=$ordID";
                if($conn->query($sql)==TRUE){
                    $message="Επιτυχής Υποβολλή";
                    echo $message;
                }else{
                    echo "ERROR".$conn->error;
                }

            }
        ?>
        

    </body>
</html>