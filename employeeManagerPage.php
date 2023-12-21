<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Σελίδα Διαχείρησης Προσωπικού</h1>
            <h1><?php echo $_COOKIE['Error'];?></h1>
        </header>
        <main>
            <article>
                <?php
                    if($_COOKIE['RefreshEMP']=="YES"){
                        //Arxikopoiish
                        $SelectAM="";//AM for form
                        $DiatiroumenoAM="";//AM for SQL commands
                        setcookie("RefreshEMP","NO");
                        
                    }else{
                        $DiatiroumenoAM=$_COOKIE['Bazw'];
                    }
                ?>
                
                <section>
                    <button onclick="location.href='addEmployeePage.php'">Προσθήκη Υπαλλήλου</button>
                    <button onclick="location.href='CategoriesShowPage.php'">Προβολή Κατηγοριών</button>
                    <a href="bossCentralPage.php">Επιστροφή</a>
                </section>
                <!--Table from Selected Employer-->
                <section>
                    <?php
                        //Find Selected Emplooyer from AM
                        
                        
                        //Stoixeia upallilou
                        $SelectFirstName="Some Value";
                        $SelectLastName="Some Value";
                        $SelectNumber="Some Value";
                        $SelectEmail="Some Value";
                        $SelectPassword="Some Value";
                        $SelectCategory="Some Value";
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            //Find Selected Emplooyer from AM
                            $SelectAM=$_GET['bs'];//AM
                            $DiatiroumenoAM=$_GET['bs'];
                            setcookie("Bazw",$_GET['bs']);
                            //----------------------------//
                            $servername='localhost';
                            $username='root';
                            $password='';
                            $dbName='usersDataBase';
                            $usersTable='usersTable';//Table for any user
                            $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)

                            $categoriesNames=array();//List 
                            
                            //Create Connection

                            $conn = new mysqli($servername,$username,$password,$dbName);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                           $sql="SELECT * FROM usersTable WHERE AM='".$DiatiroumenoAM."'";
                           $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                
                                while($row = $result->fetch_assoc()) {
                                    $SelectFirstName=$row['firstName'];
                                    $SelectLastName=$row['lastName'];
                                    $SelectNumber=$row['phoneNumber'];
                                    $SelectEmail=$row['email'];
                                    $SelectPassword=$row['SystemPassword'];
                                    $SelectCategory=$row['Category'];
                                }
                            }else{
                                echo "Error";
                            }

                            //$conn->close();
                            
                        }
                    ?>    
                </section>
                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    //----------------------------//
                    $servername='localhost';
                    $username='root';
                    $password='';
                    $dbName='usersDataBase';
                    $usersTable='usersTable';//Table for any user
                    $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)

                    $categoriesNames=array();//List 
                    
                    //Create Connection

                    $conn = new mysqli($servername,$username,$password,$dbName);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    //if click some of buttons on form 
                    if(isset($_POST['lbu'])){
                        //Update employer information data
                        $SelectAM=$_POST['am'];
                        $SelectPassword=$_POST['sp'];
                        $SelectFirstName=$_POST['fn'];
                        $SelectLastName=$_POST['ln'];
                        $SelectEmail=$_POST['em'];
                        $SelectNumber=$_POST['tl'];

                        $sql="SELECT * FROM usersTable WHERE AM='".$DiatiroumenoAM."'";
                           $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                echo "Exist";
                            }else{
                                echo "--> ".$DiatiroumenoAM." - ".$_COOKIE['RefreshEMP']."<br>";
                                echo "ERRORRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR11111";
                            }

                        $sql ="UPDATE usersTable SET SystemPassword='".$SelectPassword."',
                        firstName='".$SelectFirstName."',lastName='".$SelectLastName."',
                        phoneNumber=$SelectNumber,AM='".$SelectAM."', 
                        email='".$SelectEmail."' WHERE AM='".$DiatiroumenoAM."'";

                        if($conn->query($sql)===TRUE){
                            setcookie("RefreshEMP","YES");
                        }else{
                            echo $conn->error;
                            setcookie('Error',$conn->error);
                        }

                    }else if(isset($_POST['lbd'])){
                        //Delete employe from system

                        $sql = "DELETE FROM usersTable WHERE AM='".$DiatiroumenoAM."'";
                        if($conn->query($sql)===FALSE){
                            echo $conn->error;
                        }else{

                            $conn->close;

                            //if user was employeer
                            //Must be delete from perfomance table

                            if(TRUE){
                                $dbName='ordersDataBase';
                                $EmpPerf='EmpPerfomanceTable';//Table with daily employeers perfomance (*)

                                //Create Connection

                                $conn = new mysqli($servername,$username,$password,$dbName);
                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                $sql ="DELETE FROM $EmpPerf WHERE EmID='".$DiatiroumenoAM."'";
                                if($conn->query($sql)===FALSE){
                                    echo $conn->error;
                                }
                            }
                            setcookie("RefreshEMP","YES");
                        }

                    }else{
                        echo "ERRORRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR";
                    }
                }
            ?>
                <section>
                <form method='post' action='employeeManagerPage.php'>

                        <h2>Στοιχεία Υπαλλήλου</h2>
                        <p>ΑΜ:</p>
                        <input type='text' name='am' value='<?php echo $SelectAM?>'>
                        <br>
                        <p>Κωδικός Συστήματος:</p>
                        <input type='text' name='sp' value='<?php echo $SelectPassword?>'>
                        <br>
                        <p>Όνομα:</p>
                        <input type='text' name='fn' value='<?php echo $SelectFirstName?>'>
                        <br>
                        <p>Επίθετο:</p>
                        <input type='text' name='ln' value='<?php echo $SelectLastName?>'>
                        <br>
                        <p>Email:</p>
                        <input type='text' name='em' value='<?php echo $SelectEmail?>'>
                        <br>
                        <p>Τηλέφωνο:</p>
                        <input type='text' name='tl' value='<?php echo $SelectNumber?>'>
                        <br>
                        <p>Κατηγορία:</p>
                        <?php echo $categoriesNames[$SelectCategory]." (".$SelectCategory.")";?>
                        <br>
                        <br>
                        <input type='submit' name='lbu' value='Ενημέρωση'>
                        <input type='submit' name='lbd' value='Διαγραφή Υπαλλήλου'>
                        
                    </form>
                </section>
                <section>
                    <!--Table with employee Staff-->
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
                        <?php
                           // setcookie('ChangeAM','0');
                            $servername='localhost';
                            $username='root';
                            $password='';
                            $dbName='usersDataBase';
                            $usersTable='usersTable';//Table for any user
                            $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)

                            $categoriesNames=array();//List 
                            
                            //Create Connection

                            $conn = new mysqli($servername,$username,$password,$dbName);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            //Load CategoriesList
                            $sql = "SELECT * FROM $catgoryUsers";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    //array_push($categoriesNames,$row['Symbol']=>$row['catname'])
                                    $categoriesNames[$row['Symbol']]=$row['Catname'];
                                    //echo $categoriesNames[$row['Symbol']]."<br>";
                                }
                                //echo "<br>";
                            } else {
                                echo "0 results";
                            }


                            //Print Staff Table
                            echo "<table border='4' class='stats' cellspacing='0'>

                            <tr>
                            <td class='hed' colspan='8'>Διαθέσιμο Προσωπικό</td>
                            </tr>
                            <tr>
                            <th>Αριθμός Μητρώου (ΑΜ)</th>
                            <th>Ονοματεπώνυμο</th>
                            <th>Email</th>
                            <th>Τηλέφωνο</th>
                            <th>Κατηγορία</th>
                            <th>Επιλογή</th>

                            </tr>";

                            $sql = "SELECT * FROM $usersTable";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                
                                while($row = $result->fetch_assoc()) {
                                    $flname=$row['firstName']." ".$row['lastName'];
                                    echo "<tr>
                                    <td>".$row['AM']."</td>
                                    <td>".$flname."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['phoneNumber']."</td>
                                    <td>".$categoriesNames[$row['Category']]."</td>";
                                    if($row['Category']!="PRO"){
                                        echo "<td><button name='bs' value='".$row['AM']."'>Επιλογή</button></td>";
                                    }else{
                                        echo "<td style='color:red'>X</td>";
                                    }
                                    echo "</tr>";
                                }
                                
                            } else {
                                echo "0 results";
                            }
                            echo "</table>";
                            
                            $conn->close();
                        ?>
                    </form>
                </section>
            </article>
            
        </main>
    </body>
</html>