<?php 
            setcookie("userFnLog","None");//Cookie me to onoma tou atomou pou sundeetai
            setcookie("userLnLog","None");//Cookie me to epitheto tou atomou pou sundeetai
            setcookie("userId",0);//Cookie me to ID tou atomou pou sundeetai
            $uc='EMP';
        ?>
<!DOCTYPE html>
<?php
        //Otan sumplirwthei i forma
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                
                // collect value of input field
                $name = $_POST['fname'];
                $Upassword=$_POST['Password'];

                if (empty($name)) {
                    echo "Name is empty";
                } else {
                    //Sundesi me basi dedomenwn kai elegxos an uparxei o xristis
                    $servername="localhost";
                    $username ="root";
                    $password="";
                    $dataBase = "usersDataBase";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password,$dataBase);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    //Epilogi olwn twn xristwn idias katigorias
                    $sql = "SELECT AM, firstName, lastName ,SystemPassword,Category  FROM usersTable ";
                    $result = $conn->query($sql);

                    
                    $fn=$ln="";
                    $N=0;
                    //Elegxos an uparxei o xristis (einai ta stoixeia ortha)
                    if ($result->num_rows > 0) {//1h Sunthiki , uparxei xristis sugkekrimenis Katigorias
                        $N=1;
                        while($row = $result->fetch_assoc()) {
                            $fn=$row['firstName'];
                            $ln=$row['lastName'];
                            $id=$row['AM'];
                            $ps=$row['SystemPassword'];
                            $uc=$row['Category'];
                            //An einai idio password kai to onoma
                            if($fn==$name && $ps==$Upassword){//2h Sunthiki, uparxei xristis me ta stoixeia formas
                                $N=2;
                                setcookie("userFnLog",$fn);
                                setcookie("userLnLog",$ln);
                                setcookie("userId",$id);
                                setcookie("userPs",$ps);
                                setcookie("userCat",$uc);
                                
                                break;
                            }
                        }
                    }else{
                        echo "<p style='color:green'>User Not Found, Try Again :( </p>";
                    }
                    //An dixtis $N<2, den uparxei o xristis/ den plirountai oi 2 sunthikes
                    if($N<2){
                        echo "<p style='color:red'>User Not Found, Try Again :( </p>";
                        $conn->close();
                    }else{
                        if($uc=="EMP"){
                            $conn->close();
                            echo $uc;
                            header("Location: empCentralPage.php");//Emfanisi stin alli selida an ola einai kala
                        }else if($uc=="PRO"){
                            $conn->close();
                            header("Location: bossCentralPage.php");
                            echo $uc;
                        }else{
                            echo "";
                        }
                    }
                
                }
            }

        ?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Είσοδος σελίδα/Login page</title>
        <link rel="stylesheet" href="logStyle.css">
        <link rel="stylesheet" href="ButtonsStyle.css">
    </head>
    <body>
        <!--Epikefalida selidas-->
        <header>
            <h1>Login/Είσοδος</h1>
        </header>
        <main>
            <!-- Kwdikas Formas-->
            <article>
                <h1>Εισαγωγή στοιχείων</h1>
                <section id="forma">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        Name:<br><input type="text" name="fname"><br>
                        Password:<br><input type="password" name="Password"><br><br>
                        <input type="submit" name="Login">
                    </form>
                </section>
                
                <a href="FirstPage.html">Επιστροφή</a>
                
            </article>
        </main>
    
    </body>
</html>