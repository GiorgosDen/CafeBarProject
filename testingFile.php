

<?php

    $servername='localhost';
    $username='root';
    $userpasword='';
    $databasename='TestDB';
    $tablename= 'TestTable';
    $tablename2='DateTestTable';

    // Create connection
    $conn = new mysqli($servername, $username, $userpassword, $databasename);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    /*
    // Create database
    $sql = "CREATE DATABASE $databasename";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    */
    
    //Create table

    /*
    $sql = "CREATE TABLE $tablename(
        id INT(10),
        price FLOAT(10),
        Fname VARCHAR(15)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    */

    //Import data
    /*
    $id=10;
    $price=10.5;
    $name="Product";

    $nPrice=12.0;
    $sql = "INSERT INTO $tablename (id,price,Fname)
        VALUES ($id,$price,'".$name."')";
    $sql = "UPDATE $tablename SET price=$nPrice WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record import successfully";
    } else {
        echo "Error importing data: " . $conn->error;
    }

    $sql = "SELECT id, Fname, price FROM $tablename";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<br>";
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo " <br> id: " . $row["id"]. " - Name: " . $row["Fname"]. " - Price: " .
            $row["price"]. "<br>";
        }
    } else {
        echo "0 results";
    }
*/

/*$number=0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "You choise numer: ".$_POST['s'];
        $number=$_POST['s'];
    }
*/

/*$sql = "CREATE TABLE $tablename2(
    id INT(10) primary key,
    Mera DATE not null
)";


if ($conn->query($sql)===TRUE){
    echo "create table";
}else{
    echo "error : ".$conn->error;
}*/

/*
$d=date("Y-m-d");
echo $d;

$sql ="INSERT INTO $tablename2 (id,Mera)
VALUES (4,CAST('".date("Y-m-d")."' AS DATE))";

if ($conn->query($sql)===TRUE){
    echo "import record";
}else{
    echo "error : ".$conn->error;
}

$sql = "SELECT * from $tablename2";
$result = $conn->  query($sql);

if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        echo "ID: ".$row['id']." Day: ".$row['Mera']."<br>";
    }
}*/
?>

<?php

$str1='Hello';
$str2='Hello';

if(strcmp($str1,$str2)==0){
    echo "sdunfsdisdi";
}
?>
              