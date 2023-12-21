<?php

$servername='localhost';
$username='root';
$password='';
$dbName='ordersDataBase';
$EmpOrders='EmpOrdersTable';//Table for any Employeer daily order (X)
$FinEmpOrders = 'FinEmpOrdersTable';//Correct Table for any Employeer daily order (*)
$EmpPerf='EmpPerfomanceTable';//Table with daily employeers perfomance (*)
$Dorders='DailyOrdersTable';//Table with product order (*)
$AvTables ='AvailableTables';//Table with availiable tables(all tables generaly) (*)
$ProductsTable='ProductsTable';//Table with Basic products (*)
$VariationProductsTable='VariationProductsTable';//Table with variations products (*)
$CatProducts='CategoriesProducts';//Table wiht categories product (*)
$OrdSituations='OrderSituationsTable';//Table wiht order's situations (*)
$VariationsBaseProductsTable='VariationsBaseProductsTable';//Table who connect Variations with Basic Products(*)
$MaterialsTable='MaterialsTable';//Table with materials for production products(*)
$BasicProductsMaterialsTable='BasicProductsMaterialsTable';//Connection between basic Products & Materials(*)
$VariationsProductsMaterialsTable='VariationsProductsMaterialsTable';//Connection between Variations products & Materials(*)
$SalesTable='SalesTable';//Table with all sales, for any day(*)
$ZTable='ZTable';//Table with all Z, Z=daily earnings(*)
$SalesProductsTable='SalesProductsTable';//Table with all products sales(*)

//Create Connection

$conn = new mysqli($servername,$username,$password,$dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//setcookie("orderNumber",1);//Προσωρινη αποθήκευση αριθμού παραγγελίας
//====================================================================//
//Create DB
   /* 
$sql = "CREATE DATABASE $dbName";

//Check Create Base

if($conn->query($sql)===TRUE){
    echo 'DB create';
}else{
    echo 'ERROR FUCK';
}
*/
//============================================================================//
    

//Create EmpOrdersTable
/*
$sql = "CREATE TABLE $EmpOrders(
    OrdID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tableNumber INT(10) UNSIGNED NOT NULL,
    totalAmmount FLOAT(15) UNSIGNED NOT NULL,
    situation VARCHAR(20) NOT NULL,
    comments VARCHAR(100),
    EmpID VARCHAR(15)
)";

//Check create
if($conn->query($sql)===TRUE){
    echo 'EmpOrdersTable create';
}else{
    echo 'ERROR FUCK';
}
*/
//=============================================================================//

//Create EmpPerfomanceTable
//  AM===EmID
//  Uname== firstName LastName
//  tips==mpourmpouar
//  total == sunolika esoda apo paraggelies
/*
$sql = "CREATE TABLE $EmpPerf(
    Uname VARCHAR(50) NOT NULL,
    EmID VARCHAR(15) PRIMARY KEY,
    tips FLOAT(10) UNSIGNED NOT NULL,
    total FLOAT(15) UNSIGNED NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo 'EmpPerfomanceTable create';
}else{
    echo 'ERROR FUCK';
}

//Import 2 Users in Perfomance table

$sql= "INSERT INTO $EmpPerf (Uname,EmID,tips,total)
    VALUES ('John Doe','AM1234',0,0)";

//Check import
if($conn->query($sql)===TRUE){
    echo 'John Doe Perfomance import';
}else{
    echo 'ERROR FUCK';
}

$sql= "INSERT INTO $EmpPerf (Uname,EmID,tips,total)
    VALUES ('George Denesidis','AM5678',0,0)";

//Check import
if($conn->query($sql)===TRUE){
    echo 'George Denesidis Perfomance import';
}else{
    echo 'ERROR FUCK';
}
*/

//=============================================================================//

//Create DailyOrdersTable

/*
$sql = "CREATE TABLE $Dorders(
    OrdID INT(10) NOT NULL,
    product VARCHAR(20) NOT NULL,
    category VARCHAR(20) NOT NULL,
    quantity INT(5) UNSIGNED NOT NUll,
    tPrice FLOAT(10) UNSIGNED NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo 'DailyOrdersTable create';
}else{
    echo 'ERROR FUCK';
}
*/

//===========================================================================//

//Create AvailableTables table            // Check connection
            //if ($conn->connect_error) {
              //  die("Connection failed: " . $conn->connect_error);
            //}
/*
$sql = "CREATE TABLE $AvTables(
    TableNumber VARCHAR(5) PRIMARY KEY,
    TableAvailability VARCHAR(5) NOT NULL,
    TableCapacity INT(5) NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo 'DailyOrdersTable create';
}else{
    echo 'ERROR FUCK';
}

//Import Tables
$N=0;

$sql = "INSERT INTO $AvTables (TableNumber,TableAvailability,TableCapacity) VALUES ('A01','YES',4)";
if($conn->query($sql)===TRUE){
    $N+=1;
}

$sql = "INSERT INTO $AvTables (TableNumber,TableAvailability,TableCapacity) VALUES ('A02','YES',4)";
if($conn->query($sql)===TRUE){
    $N+=1;
}

$sql = "INSERT INTO $AvTables (TableNumber,TableAvailability,TableCapacity) VALUES ('A03','YES',4)";
if($conn->query($sql)===TRUE){
    $N+=1;
}

$sql = "INSERT INTO $AvTables (TableNumber,TableAvailability,TableCapacity) VALUES ('A04','YES',4)";
if($conn->query($sql)===TRUE){
    $N+=1;
}

$sql = "INSERT INTO $AvTables (TableNumber,TableAvailability,TableCapacity) VALUES ('A05','YES',4)";
if($conn->query($sql)===TRUE){
    $N+=1;
}

if($N<5){
    echo "ERROR FUCK!!!";
}
*/

//======================================================================================================//

//Create ProductsCategories Table
/*
$sql ="CREATE TABLE $CatProducts(
    CategoryNumber INT(5) PRIMARY KEY,
    CategoryName VARCHAR(20) NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo $CatProducts.' create';
}else{
    echo 'ERROR FUCK';
}
*/

//Import Catefories
/*
$Ν=0;
$sql ="INSERT INTO $CatProducts (CategoryNumber,CategoryName)
    VALUES (1,'Καφέδες')";
    if($conn->query($sql)===TRUE){
        $N+=1;
    }
$sql ="INSERT INTO $CatProducts (CategoryNumber,CategoryName)
VALUES (2,'Χυμοί')";
if($conn->query($sql)===TRUE){
    $N+=1;
}
$sql ="INSERT INTO $CatProducts (CategoryNumber,CategoryName)
VALUES (3,'Ροφήματα')";
if($conn->query($sql)===TRUE){
    $N+=1;
}
$sql ="INSERT INTO $CatProducts (CategoryNumber,CategoryName)
VALUES (4,'Κοκτέιλ')";
if($conn->query($sql)===TRUE){
    $N+=1;
}

if($N<4){
    echo "ERROR FUCK!!!";
}
*/

//==============================================================================//

//Create ProductsTable

/*
$sql = "CREATE TABLE $ProductsTable (
    ProductID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ProductName VARCHAR(25) NOT NULL,
    ProductCategory INT(5) NOT NULL,
    ProductPrice FLOAT(10) NOT NULL,
    ProductQuantity INT(10) NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo $ProductsTable.' create';
}else{
    echo 'ERROR FUCK';
}

//import First central product

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Ελληνικός',1,2.5,100)";

if($conn->query($sql)===TRUE){
    echo 'Product import';
}else{
    echo 'ERROR FUCK';
}
*/

//============================================================================================================//

//Create Variations Products Table
/*
$sql = "CREATE TABLE $VariationProductsTable(
    VariationID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    CentralProductID INT(10) UNSIGNED NOT NULL,
    VariationName VARCHAR(25) NOT NULL,
    VariationPrice FLOAT(10) NOT NULL
)";

//Check create
if($conn->query($sql)===TRUE){
    echo $VariationProductsTable.' create';
}else{
    echo 'ERROR FUCK';
}
*/
//Import Variations Products
/*
$N=0;

$sql = "INSERT INTO $VariationProductsTable(CentralProductID,VariationName,VariationPrice)
    VALUES (1,'Σκέτος',2.5)";
    if($conn->query($sql)===TRUE){
        $N+=1;
    }
$sql = "INSERT INTO $VariationProductsTable(CentralProductID,VariationName,VariationPrice)
    VALUES (1,'Μέτριος',2.5)";
    if($conn->query($sql)===TRUE){
        $N+=1;
    }
$sql = "INSERT INTO $VariationProductsTable(CentralProductID,VariationName,VariationPrice)
    VALUES (1,'Γλυκός',2.5)";
    if($conn->query($sql)===TRUE){
        $N+=1;
    }
    if($N<3){
        echo "ERROR";
    }else{
        echo "Complete";
    }
*/

/*
$sql ="SELECT * FROM $VariationProductsTable";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo " <br> id: " . $row["VariationID"]. " - Name: " . $row["VariationName"]. " " .
$row["VariationPrice"]. "<br>";
}
} else {
echo "0 results";
}
*/
//==========================================================================================================//

//Create OrderSituations Table
/*
$sql ="CREATE TABLE $OrdSituations(
    SituationID INT(5) PRIMARY KEY,
    SituationName VARCHAR(25) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "OrderSituationsTable create successfully";
    } else {
    echo "Error ";
    }
*/
/*
$sql = "INSERT INTO $OrdSituations(SituationID,SituationName)
    VALUES (0,'Προς Εκτέλεση')";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }
$sql = "INSERT INTO $OrdSituations(SituationID,SituationName)
    VALUES (1,'Προς Πληρωμή')";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }
$sql = "INSERT INTO $OrdSituations(SituationID,SituationName)
    VALUES (2,'Ολοκληρωμένη')";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }
$sql = "INSERT INTO $OrdSituations(SituationID,SituationName)
    VALUES (3,'Άκυρη')";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }

$sql = "SELECT * FROM $OrdSituations";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()){
        echo "id: ".$row['SituationID']." name: ".$row['SituationName']."<br>";
    }}*/




    //==========================================================================================//

//Import more Central products in dataBase

/*
//1.Coffies
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Espresso',1,2.0,100)";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Freddo Espresso',1,2.7,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Cappuccino',1,2.0,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Double Cappuccino',1,2.7,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Freddo Cappuccino',1,2.7,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Φραπές',1,2.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}

//2.Juices
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Χυμός Βύσσινο',2,2.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Χυμός Πορτοκάλι',2,2.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Χυμός Ανανάς',2,2.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Χυμός Ανάμεικτος',2,2.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
//3.Ροφιματα

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Ζεστή Σοκολάτα',3,3.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Κρύα Σοκολάτα',3,3.5,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Λευκή Ζεστή Σοκολάτα',3,3.7,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Λευκή Κρύα Σοκολάτα',3,3.7,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
//4. Κοκκτειλσς

$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Mojito',4,8.0,100)";
if($conn->query($sql)===FALSE){
    echo "ERROR";
}
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Mai Tai',4,8.5,100)";
    if($conn->query($sql)===FALSE){
        echo "ERROR";
    }
/*
$sql = "INSERT INTO $ProductsTable (ProductName,ProductCategory,ProductPrice,ProductQuantity)
    VALUES ('Martini',4,8.0,100)";

    echo "dusnodsfskf[ps";


$sql = "SELECT * FROM $ProductsTable";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo " <br> id: " . $row["ProductID"]. " - Name: " . $row["ProductName"]. " " .
            $row["ProductCategory"]. "<br>";
        }
    } else {
    echo "0 results";
    }*/

    //$sql ="DROP TABLE $ProductsTable";

//==============================================================================================================//

    //Create FinEmpOrdersTable, beacause the first table is shit and i dont deleted it
    /*
    $sql = "CREATE TABLE $FinEmpOrders(
        OrdID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tableNumber VARCHAR(25) NOT NULL,
        totalAmmount FLOAT(15) UNSIGNED NOT NULL,
        situation VARCHAR(20) NOT NULL,
        comments VARCHAR(100),
        EmpID VARCHAR(15)
    )";

if ($conn->query($sql) === TRUE) {
    echo $FinEmpOrders." create successfully";
    } else {
    echo "Error ";
    }
    */

    //=====================================================================================================================//

    //Print Data from FinEmpPerfomance tabl and from DailyOrdersTable
    /*
    $sql = "SELECT * FROM $FinEmpOrders";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo " <br> id: " . $row["OrdID"]. " - Table: " . $row["tableNumber"]. " - TotalAmmount " .
            $row["totalAmmount"]. "<br>";
    }
    } else {
        echo "0 results";
    }

    $sql1 ="INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice) 
        VALUES (23,'Fake','Null',10,10)";
        $sql ="INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice) 
        VALUES (23,'Fake','Null',10,10)";
        $sql ="INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice) 
        VALUES (23,'Fake','Null',10,10)";
        $sql ="INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice) 
        VALUES (23,'Fake','Null',10,10)";
        $sql ="INSERT INTO $Dorders (OrdID,product,category,quantity,tPrice) 
        VALUES (23,'Fake','Null',10,10)";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
    $sql = "SELECT * FROM $Dorders";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo " <br> id: " . $row["OrdID"]. " - Product: " . $row["product"]. "<br>";
    }
    } else {
        echo "0 results";
    }
    */
    //==========================================================================================//

    //Create A ules tmima

    //Delete old VariationsProductsTable
    /*
    $delete="DROP TABLE ".$VariationProductsTable."";

    if($conn->query($delete)===TRUE)
    {
    echo("This table has been deleted.");
    }else{
    echo("This table has not been deleted.");
    }*/

    /*
    $sql="CREATE TABLE $VariationProductsTable (
        VID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        VName VARCHAR(25) NOT NULL,
        VPrice FLOAT(10) NOT NULL,
        VDescription VARCHAR(100),
        BID INT(10) NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo $VariationProductsTable." create";
    }else{
        echo "Error: ".$conn->error;
    }

    //Import some variations products
    
    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Μέτριος',0,'Μια κουταλιά ζάχαρη',1)";
    if($conn->query($sql)===TRUE){
        echo "Imort 1 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Σκέτος',0,'Χωρίς ζάχαρη',1)";
    if($conn->query($sql)===TRUE){
        echo "Imort 2 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Γλυκός',0,'Δύο κουταλιές ζάχαρη',1)";
    if($conn->query($sql)===TRUE){
        echo "Imort 3 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
    VALUES('Γλυκός Καστανή',0,'Δύο κουταλιές Καστανή ζάχαρη',1)";
if($conn->query($sql)===TRUE){
    echo "Imort 4 <br>";
}

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Μέτριος',0,'Μια κουταλιά ζάχαρη',4)";
    if($conn->query($sql)===TRUE){
        echo "Imort 1 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Σκέτος',0,'Χωρίς ζάχαρη',4)";
    if($conn->query($sql)===TRUE){
        echo "Imort 2 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Γλυκός',0,'Δύο κουταλιές ζάχαρη',4)";
    if($conn->query($sql)===TRUE){
        echo "Imort 3 <br>";
    }

    $sql ="INSERT INTO $VariationProductsTable (VName,VPrice,VDescription,BID)
        VALUES('Γλυκός Καστανή',0,'Δύο κουταλιές Καστανή ζάχαρη',4)";
    if($conn->query($sql)===TRUE){
        echo "Imort 4 <br>";
    }

    //Create VariationsBaseProductsTable
    
    /*
    $sql ="CREATE TABLE $VariationsBaseProductsTable(
        ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        BName VARCHAR(25) NOT NULL,
        BID INT(10) NOT NULL,
        VName VARCHAR(25) NOT NULL,
        VID INT(10) NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo "Create Table";
    }else{
        echo $conn->error;
    }*/

    //Import some connections
   /*
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Ελληνικός',1,'Μέτριος',1)";
    if($conn->query($sql)===TRUE){
        echo "Import Ελληνικός Μέτριος<br>";
    }
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Ελληνικός',1,'Σκέτος',2)";
    if($conn->query($sql)===TRUE){
        echo "Import Ελληνικός Σκέτος<br>";
    }
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Ελληνικός',1,'Γλυκός',3)";
    if($conn->query($sql)===TRUE){
        echo "Import Ελληνικός Γλυκός<br>";
    }

    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Espesso',4,'Μέτριος',1)";
    if($conn->query($sql)===TRUE){
        echo "Import Espesso Μέτριος<br>";
    }
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Espesso',4,'Σκέτος',2)";
    if($conn->query($sql)===TRUE){
        echo "Import Espesso Σκέτος<br>";
    }
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Espesso',4,'Γλυκός',3)";
    if($conn->query($sql)===TRUE){
        echo "Import Espesso Γλυκός<br>";
    }
    */
    /*
    $sql = "INSERT INTO $VariationsBaseProductsTable (BName,BID,VName,VID)
    VALUES ('Espesso',4,'Γλυκός Καστανή',4)";
    if($conn->query($sql)===TRUE){
        echo "Import Espesso Γλυκός Kastani<br>";
    }*/

    //Create MaterialsTable
    /*
    $sql = "CREATE TABLE $MaterialsTable (
        MID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        MName VARCHAR(35) NOT NULL,
        MQuantity INT(10) UNSIGNED NOT NULL,//Suskeuasies
        Mmin INT(10) UNSIGNED NOT NULL,
        Mmax INT(10) UNSIGNED NOT NULL,
        Mmass FLOAT(10) UNSIGNED NOT NULL,//Mias siskeuasias
        MmeasurementUnit VARCHAR(5) NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo "Create Table<br>".$MaterialsTable;
    }*/

    //Import some materials
    /*
    $sql="INSERT INTO $MaterialsTable(MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
        VALUES ('Lavazza',5,2,10,1,'kg')";
    if($conn->query($sql)===TRUE){
        echo "Import Lavazza 1kg<br>";
    }

    $sql="INSERT INTO $MaterialsTable(MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
        VALUES ('Lavazza',2,1,5,3,'kg')";
    if($conn->query($sql)===TRUE){
        echo "Import Lavazza 3kg<br>";
    }

    $sql="INSERT INTO $MaterialsTable(MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
        VALUES ('Λουμίδης',7,3,15,2,'kg')";
    if($conn->query($sql)===TRUE){
        echo "Import Λουμίδης 2kg<br>";
    }

    $sql="INSERT INTO $MaterialsTable(MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
        VALUES ('Ζάχαρη',5,3,10,2,'kg')";
    if($conn->query($sql)===TRUE){
        echo "Import Ζάχαρη 2kg<br>";
    }*/

    /*$sql="INSERT INTO $MaterialsTable(MName,MQuantity,Mmin,Mmax,Mmass,MmeasurementUnit)
        VALUES ('Ζάχαρη Καστανή',5,3,10,2,'kg')";
    if($conn->query($sql)===TRUE){
        echo "Import Ζάχαρη Kastani 2kg<br>";
    }*/

    //Create BasicProductsMaterialsTable
    /*
    $sql = "CREATE TABLE $BasicProductsMaterialsTable(
        ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        PID INT(10) UNSIGNED NOT NULL,
        MID INT(10) UNSIGNED NOT NULL,
        Ratio FLOAT(15) UNSIGNED NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo "Create table<br>".$BasicProductsMaterialsTable;
    }*/

    //Import some records in BasicProductsMaterialsTable
    //Ratio = Quantity_For_Product/ Material_Mass
    /*
    $sql="INSERT INTO $BasicProductsMaterialsTable (PID,MID,Ratio)
        VALUES (1,3,0.075)";
     if($conn->query($sql)===TRUE){
        echo "Αναλογία Ελληνικός-Λουμίδης <br>";
    }

    $sql="INSERT INTO $BasicProductsMaterialsTable (PID,MID,Ratio)
        VALUES (4,1,0.05)";
     if($conn->query($sql)===TRUE){
        echo "Αναλογία Espresso-Lavazza(1kg) <br>";
    }

    $sql="INSERT INTO $BasicProductsMaterialsTable (PID,MID,Ratio)
        VALUES (1,4,0)";
     if($conn->query($sql)===TRUE){
        echo "Αναλογία Ellinkos-Zaxari(1kg) <br>";
    }

    $sql="INSERT INTO $BasicProductsMaterialsTable (PID,MID,Ratio)
        VALUES (4,4,0)";
     if($conn->query($sql)===TRUE){
        echo "Αναλογία Espresso-Zaxari(1kg) <br>";
    }
    $sql="INSERT INTO $BasicProductsMaterialsTable (PID,MID,Ratio)
        VALUES (4,6,0)";
     if($conn->query($sql)===TRUE){
        echo "Αναλογία Espresso-Zaxarik(1kg) <br>";
    }

    //Create VariationsProductsMaterialsTable

    /*
    $sql = "CREATE TABLE $VariationsProductsMaterialsTable(
        ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        VID INT(10) UNSIGNED NOT NULL,
        MID INT(10) UNSIGNED NOT NULL,
        Ratio FLOAT(10) UNSIGNED NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo "Create Table <br>".$VariationsProductsMaterialsTable;
    }*/

    //Import some connections

    /*
    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(1,4,0.025)";
    if($conn->query($sql)===TRUE){
        echo "Import Μέτριο-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(2,4,0)";
    if($conn->query($sql)===TRUE){
        echo "Import Σκέτο-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(3,4,0.05)";
    if($conn->query($sql)===TRUE){
        echo "Import Γλυκό-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(4,5,0.05)";
    if($conn->query($sql)===TRUE){
        echo "Import Γλυκό-Ζαχαρη k<br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(5,4,0.025)";
    if($conn->query($sql)===TRUE){
        echo "Import Μέτριο-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(6,4,0)";
    if($conn->query($sql)===TRUE){
        echo "Import Σκέτο-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(7,4,0.05)";
    if($conn->query($sql)===TRUE){
        echo "Import Γλυκό-Ζαχαρη <br>";
    }

    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
        VALUES(8,5,0.05)";
    if($conn->query($sql)===TRUE){
        echo "Import Γλυκό-Ζαχαρη k<br>";
    }
    $sql = "INSERT INTO $VariationsProductsMaterialsTable (VID,MID,Ratio)
    VALUES(8,6,0.05)";
if($conn->query($sql)===TRUE){
    echo "Import Γλυκό-Ζαχαρη k<br>";
}*/

    
    /*$sql = "SELECT * FROM $VariationsBaseProductsTable";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo " <br> id: " . $row["VID"]. " - Product: " . $row["BName"]. "<br>";
    }
    } else {
        echo "0 results";
    }*/


    /*
    //Create Table with all Sales
    $sql = "CREATE TABLE $SalesTable (
        ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        OrderID INT(10) UNSIGNED NOT NULL,
        TableNumber VARCHAR(10) NOT NULL,
        TotalAmmount FLOAT(15) UNSIGNED NOT NULL,
        OrderSituation VARCHAR(20) NOT NULL,
        OrderComments VARCHAR(100),
        EmployeeID VARCHAR(20) NOT NULL,
        OrderDay DATE
    )";

    if ($conn->query($sql)===TRUE){
        echo "Create Table ".$SalesTable;
    }else{
        echo "error : ".$conn->error;
    }*/

    //Create Table with Z
    /*
    $sql = "CREATE TABLE $ZTable (
        ZID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        TotalAmmount FLOAT(15) UNSIGNED NOT NULL,
        ZDay DATE,
        UserID VARCHAR(25) NOT NULL
    )";

    if ($conn->query($sql)===TRUE){
        echo "Create Table ".$ZTable;
    }else{
        echo "error : ".$conn->error;
    }*/

    //Create SalesProductsTable
    /*    $sql="CREATE TABLE $SalesProductsTable (
        ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ProductName VARCHAR(25) NOT NULL,
        ProductCategory VARCHAR(25) NOT NULL,
        DailyQuantity INT(10) UNSIGNED NOT NULL,
        SaleDay DATE
    )";

    if ($conn->query($sql)===TRUE){
        echo "Create Table ".$SalesProductsTable;
    }else{
        echo "error : ".$conn->error;
    }*/
?>