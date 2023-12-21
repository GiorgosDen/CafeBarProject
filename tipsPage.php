<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body>
        <article>
            <h1>Καθόλου tips????</h1>
            <section>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <input type='text' name='tipChar' value='0'>
                    <input type='Submit' value='Υποβολή'>
                </form>
            </section>
        </article>

        <?php

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $ctips=$_POST['tipChar'];//tips in string type
                $fTips=intval($ctips)+$_COOKIE['EmpTips'];//tips in float type

                //Emp Name PerfomanceTable
                $npt='EmpPerfomanceTable';

                //Update tips 
                $servername="localhost";
                $username="root";
                $password="";
                $database="ordersDataBase";

                // Create connection
                $conn = new mysqli($servername, $username, $password,$database);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //Update employer Tips
                $x=$_COOKIE['userId'];
                $sql ="UPDATE EmpPerfomanceTable SET tips=$fTips WHERE EmID='".$x."'";
                if ($conn->query($sql) === TRUE) {
                    $conn->close();
                    header("Location: empCentralPage.php");
                }else{
                    echo "FUCK: ".$conn->error;
                }
            }


        ?>

    </body>
</html>