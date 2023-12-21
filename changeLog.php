<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Σελίδα Αλλαγής Στοιχείων Εισόδου</h1>
        <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <section>
                <p>Νέο Όνομα</p>
                <input type="text" name="FirstFieldN" value="<?php echo $_COOKIE['userFnLog'];?>">
                <p>Επιβεβαίωση</p>
                <input type="text" name="SecondFieldN" value="">
                <br>
            </section>
            <section>
                <p>Νέο Επίθετο</p>
                <input type="text" name="FirstFieldL" value="<?php echo $_COOKIE['userLnLog'];?>">
                <p>Επιβεβαίωση</p>
                <input type="text" name="SecondFieldL" value="">
                <br>
            </section>
            <section>
                <p>Νέος κωδικός</p>
                <input type="password" name="FirstFieldC" value="<?php echo $_COOKIE['userPs'];?>">
                <p>Επιβεβαίωση</p>
                <input type="password" name="SecondFieldC" value="">
                <br>
            </section>
            <input type="submit" name="sub">
                <?php
                //if cookie BossLog==1 means Boss has log, else is employeer
                    if($_COOKIE['BossLog']==1){
                        echo "<a href='bossCentralPage.php'>Επιστροφή</a>";
                    }else{
                        echo "<a href='empCentralPage.php'>Επιστροφή</a>";
                    }
                ?>
        </form>
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //Password fields
                $field1=$_POST['FirstFieldC'];
                $field2=$_POST['SecondFieldC'];
                //User FirstName fields
                $field3=$_POST['FirstFieldN'];
                $field4=$_POST['SecondFieldN'];
                //User LastName fields
                $field5=$_POST['FirstFieldL'];
                $field6=$_POST['SecondFieldL'];

                $servername='localhost';
                    $username='root';
                    $password='';
                    $dbName='usersDataBase';
                    $usersTable='usersTable';//Table for any user
                    $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)

                    //Create Connection

                    $conn = new mysqli($servername,$username,$password,$dbName);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                if($field1==$field2){

                    $sql="UPDATE usersTable SET SystemPassword='".$field1."' WHERE AM='".$_COOKIE['userId']."'";
                    if($conn->query($sql)===TRUE){
                        echo "Ο κωδικός σας άλλαξε με επιτυχία";
                    }else{
                        echo "Error".$conn->error;
                    }
                }

                if($field3==$field4){

                    $sql="UPDATE usersTable SET firstname='".$field3."' WHERE AM='".$_COOKIE['userId']."'";
                    if($conn->query($sql)===TRUE){
                        echo "Το όνομά σας άλλαξε με επιτυχία";
                        setcookie("userFnLog",$field3);
                    }else{
                        echo "Error".$conn->error;
                    }
                }

                if($field5==$field6){

                    $sql="UPDATE usersTable SET lastname='".$field5."' WHERE AM='".$_COOKIE['userId']."'";
                    if($conn->query($sql)===TRUE){
                        echo "Το επίθετό σας άλλαξε με επιτυχία";
                        setcookie("userLnLog",$field5);
                    }else{
                        echo "Error".$conn->error;
                    }
                }

            }
        ?>
    </body>
</html>