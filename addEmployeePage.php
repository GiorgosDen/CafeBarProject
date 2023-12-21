<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <head>
        <h1>Προσθήκη Υπαλλήλου</h1>
        <a href='employeeManagerPage.php'>Επιστροφή</a>
        </head>
        <main>
            <article>
                <section>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <p>ΑΜ</p>
                        <input type='text' name='am'>
                        <p>Όνομα</p>
                        <input type='text' name='fn'>
                        <p>Επίθετο</p>
                        <input type='text' name='ln'>
                        <p>Email</p>
                        <input type='text' name='em'>
                        <p>Τηλέφωνο</p>
                        <input type='text' name='te'>
                        <p>Κωδικός</p>
                        <input type='text' name='co'>
                        <p>Κατηγορία</p>
                        <input type='text' name='ca'>
                        <br>
                        <br>
                        <input type='submit' value='Προσθήκη'>
                    </form>
                </section>
            </article>
        </main>
        <?php

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                //Flag 
                $F=FALSE;

                //Form stoixeia
                $ImportAM=$_POST['am'];
                $ImportFirstName=$_POST['fn'];
                $ImportLastName=$_POST['ln'];
                $ImportNumber=intval($_POST['te']);
                $ImportEmail=$_POST['em'];
                $ImportPassword=$_POST['co'];
                $ImportCategory=$_POST['ca'];


                //========================//
                $servername='localhost';
                $username='root';
                $password='';
                $dbName='usersDataBase';
                $usersTable='usersTable';//Table for any user
                $catgoryUsers='categoriesTable';//Table with category user (p.x EMP->employeer)

                $categoriesEmpNames=array();//List with categories names
                $categoriesEmpCodes=array();
                    
                //Create Connection

                $conn = new mysqli($servername,$username,$password,$dbName);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //Load all categories in list
                $sql ="SELECT * FROM categoriesTable";
                $result=$conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        array_push($categoriesEmpNames,$row['Catname']);
                        array_push($categoriesEmpCodes,$row['Symbol']);
                        echo $row['Symbol']." ";
                        
                    }
                    echo "<br>";
                } else {
                    echo "0 results";
                }

                //Check if categorie from form exist

                
                if(in_array($ImportCategory,$categoriesEmpCodes,TRUE)){
                    //Add new record/employeer
                    $sql="INSERT INTO $usersTable (AM,firstName,lastName,SystemPassword,phoneNumber,email,Category)
                    VALUES ('".$ImportAM."','".$ImportFirstName."','".$ImportLastName."','".$ImportPassword."',$ImportNumber,'".$ImportEmail."','".$ImportCategory."')";

                    if($conn->query($sql)===TRUE){
                        echo " Επιτυχής Προσθήκη Υπαλλήλου: ".$ImportFirstName." ".$ImportLastName;
                        $F=TRUE;
                    }else{
                        echo "Σφάλμα: ".$conn->error;
                    }
                }else{
                    echo "Λάθος Κατηγορία<br>";
                    echo $ImportCategory;
                }

                $conn->close();
                
                if($F){
                    //If have new employeer 
                    //Add to EmpPerfomance table (ordersdatabase)

                    $dbName='ordersDataBase';
                    $EmpPerf='EmpPerfomanceTable';//Table with daily employeers perfomance (*)

                    //Create Connection

                    $conn = new mysqli($servername,$username,$password,$dbName);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    //Import to perfomance table
                    $x=$ImportFirstName." ".$ImportLastName;
                    $sql ="INSERT INTO $EmpPerf (Uname, EmID, tips, total)
                    VALUES ('".$x."','".$ImportAM."',0,0)";

                    if($conn->query($sql)===TRUE){
                        echo " Επιτυχής Προσθήκη Υπαλλήλου: ".$ImportFirstName." ".$ImportLastName;
                    }else{
                        echo "Σφάλμα: ".$conn->error;
                    }
                }
                

            }
        ?>
    </body>
</html>