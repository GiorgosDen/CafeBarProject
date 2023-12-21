<?php
/*This file print all tables from ordersDataBase.php */

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


$sql = "SELECT * FROM $FinEmpOrders";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='6'>".$FinEmpOrders."</td>
    </tr>";
    echo "<tr>
            <th>Order ID</th>
            <th>Table Number</th>
            <th>Total Ammount</th>
            <th>Situation</th>
            <th>Comments</th>
            <th>Employee ID</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['OrdID']."</td>
        <td>".$row['tableNumber']."</td>
        <td>".$row['totalAmmount']."</td>
        <td>".$row['situation']."</td>
        <td>".$row['comments']."</td>
        <td>".$row['EmpID']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//



$sql = "SELECT * FROM $EmpPerf";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='4'>".$EmpPerf."</td>
    </tr>";
    echo "<tr>
            <th>Emp Name</th>
            <th>Emp ID</th>
            <th>Tips</th>
            <th>Total</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['Uname']."</td>
        <td>".$row['EmID']."</td>
        <td>".$row['tips']."</td>
        <td>".$row['total']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//===========================================================//



$sql = "SELECT * FROM $Dorders";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='5'>".$Dorders."</td>
    </tr>";
    echo "<tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>tPrice</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['OrdID']."</td>
        <td>".$row['product']."</td>
        <td>".$row['category']."</td>
        <td>".$row['quantity']."</td>
        <td>".$row['tPrice']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//


$sql = "SELECT * FROM $AvTables";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='3'>".$AvTables."</td>
    </tr>";
    echo "<tr>
            <th>TableNumber</th>
            <th>TableAvailability</th>
            <th>TableCapacity</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['TableNumber']."</td>
        <td>".$row['TableAvailability']."</td>
        <td>".$row['TableCapacity']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//


$sql = "SELECT * FROM $ProductsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='5'>".$ProductsTable."</td>
    </tr>";
    echo "<tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Category</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['ProductID']."</td>
        <td>".$row['ProductName']."</td>
        <td>".$row['ProductCategory']."</td>
        <td>".$row['ProductPrice']."</td>
        <td>".$row['ProductQuantity']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//


$sql = "SELECT * FROM $CatProducts";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='3'>".$CatProducts."</td>
    </tr>";
    echo "<tr>
            <th>CategoryNumber</th>
            <th>CategoryName</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['CategoryNumber']."</td>
        <td>".$row['CategoryName']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//




$sql = "SELECT * FROM $OrdSituations";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='2'>".$OrdSituations."</td>
    </tr>";
    echo "<tr>
            <th>Situation ID</th>
            <th>Situation Name</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['SituationID']."</td>
        <td>".$row['SituationName']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//




$sql = "SELECT * FROM $MaterialsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='7'>".$MaterialsTable."</td>
    </tr>";
    echo "<tr>
            <th>Material ID</th>
            <th>Material Name</th>
            <th>Material Quantity</th>
            <th>Material Min</th>
            <th>Material Max</th>
            <th>Material Mass</th>
            <th>Material Measurement Unit</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['MID']."</td>
        <td>".$row['MName']."</td>
        <td>".$row['MQuantity']."</td>
        <td>".$row['Mmin']."</td>
        <td>".$row['Mmax']."</td>
        <td>".$row['Mmass']."</td>
        <td>".$row['MmeasurementUnit']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//



$sql = "SELECT * FROM $BasicProductsMaterialsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='4'>".$BasicProductsMaterialsTable."</td>
    </tr>";
    echo "<tr>
            <th>ID</th>
            <th>Basic Product ID</th>
            <th>Material ID</th>
            <th>Ratio</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['ID']."</td>
        <td>".$row['PID']."</td>
        <td>".$row['MID']."</td>
        <td>".$row['Ratio']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//



$sql = "SELECT * FROM $VariationProductsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='4'>".$VariationProductsTable."</td>
    </tr>";
    echo "<tr>
            <th>Variation ID</th>
            <th>Variation Name</th>
            <th>Variation Price</th>
            <th>Variation Description</th>
            <th>Basic Product ID</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['VID']."</td>
        <td>".$row['VName']."</td>
        <td>".$row['VPrice']."</td>
        <td>".$row['VDescription']."</td>
        <td>".$row['BID']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//



$sql = "SELECT * FROM $VariationsBaseProductsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='5'>".$VariationsBaseProductsTable."</td>
    </tr>";
    echo "<tr>
            <th>ID</th>
            <th>Basic Product Name</th>
            <th>Basic Product ID</th>
            <th>Variation Name</th>
            <th>Variation ID</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['ID']."</td>
        <td>".$row['BName']."</td>
        <td>".$row['BID']."</td>
        <td>".$row['VName']."</td>
        <td>".$row['VID']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
//======================================================//

$sql = "SELECT * FROM $VariationsProductsMaterialsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='4'>".$VariationsProductsMaterialsTable."</td>
    </tr>";
    echo "<tr>
            <th>ID</th>
            <th>Variation ID</th>
            <th>Material ID</th>
            <th>Ratio</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['ID']."</td>
        <td>".$row['VID']."</td>
        <td>".$row['MID']."</td>
        <td>".$row['Ratio']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";


$sql = "SELECT * FROM $SalesTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='8'>".$SalesTable."</td>
    </tr>";
    echo "<tr>
            <th>OrderID</th>
            <th>TableNumber</th>
            <th>TotalAmmount</th>
            <th>OrderSituation</th>
            <th>OrderComments</th>
            <th>EmployeeID</th>
            <th>OrderDay</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['OrderID']."</td>
        <td>".$row['TableNumber']."</td>
        <td>".$row['TotalAmmount']."</td>
        <td>".$row['OrderSituation']."</td>
        <td>".$row['OrderComments']."</td>
        <td>".$row['EmployeeID']."</td>
        <td>".$row['OrderDay']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";


$sql = "SELECT * FROM $SalesProductsTable";
$result = $conn->query($sql);
echo "<table border='4' cellspacing='0' >";
    echo "<tr>
        <td colspan='8'>".$SalesProductsTable."</td>
    </tr>";
    echo "<tr>
            <th>ID</th>
            <th>ProductName</th>
            <th>ProductCategory</th>
            <th>DailyQuantity</th>
            <th>SaleDay</th>
        </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo"<tr>
        <td>".$row['ID']."</td>
        <td>".$row['ProductName']."</td>
        <td>".$row['ProductCategory']."</td>
        <td>".$row['DailyQuantity']."</td>
        <td>".$row['SaleDay']."</td>
        </tr>";
    }
    
} else {
   //echo "0 results";
}
echo "</table>";

echo "<br><br><br>";

//======================================================//
//======================================================//

$sqlb="SELECT * FROM ProductsTable
                INNER JOIN BasicProductsMaterialsTable 
                ON BasicProductsMaterialsTable.PID=ProductsTable.ProductID WHERE BasicProductsMaterialsTable.MID=6";
$result=$conn->query($sqlb);
echo "<table border='4' cellspacing='0' >";
echo "<tr>
    <td colspan='9'>".$ProductsTable."+".$BasicProductsMaterialsTable."</td>
</tr>";
echo "<tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Category</th>
        <th>Product Price</th>
        <th>Product Quantity</th>

        <th>ID</th>
        <th>Material ID</th>
        <th>Product ID</th>
        <th>Ratio</th>
    </tr>";
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
    echo"<tr>
    <td>".$row['ProductID']."</td>
    <td>".$row['ProductName']."</td>
    <td>".$row['ProductCategory']."</td>
    <td>".$row['ProductPrice']."</td>
    <td>".$row['ProductQuantity']."</td>
    <td>".$row['ID']."</td>
    <td>".$row['MID']."</td>
    <td>".$row['PID']."</td>
    <td>".$row['Ratio']."</td>
    </tr>";
}

} else {
//echo "0 results";
}
echo "</table>";

echo "<br><br><br>";


$sql ="SELECT * FROM VariationProductsTable
        INNER JOIN 
        VariationsProductsMaterialsTable 
        ON VariationProductsTable.VID=VariationsProductsMaterialsTable.VID
        WHERE VariationsProductsMaterialsTable.MID=4 AND VariationProductsTable.BID=1";


$result=$conn->query($sql);
echo "<table border='4' cellspacing='0' >";
echo "<tr>
    <td colspan='9'>".$VariationProductsTable."+".$VariationsProductsMaterialsTable."</td>
</tr>";
echo "<tr>
        <th>Variation ID</th>
        <th>Variation Name</th>
        <th>Variation Price</th>
        <th>Variation Description</th>
        <th>Product ID</th>

        <th>ID</th>
        <th>Material ID</th>
        <th>Variation ID</th>
        <th>Ratio</th>
    </tr>";
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
    echo"<tr>
    <td>".$row['VID']."</td>
    <td>".$row['VName']."</td>
    <td>".$row['VPrice']."</td>
    <td>".$row['VDescription']."</td>
    <td>".$row['BID']."</td>
    <td>".$row['ID']."</td>
    <td>".$row['MID']."</td>
    <td>".$row['VID']."</td>
    <td>".$row['Ratio']."</td>
    </tr>";
}

} else {
//echo "0 results";
}
echo "</table>";

echo "<br><br><br>";
$conn->close();
echo "=====================================================";
echo "<h1>UsersDataBase</h1>";


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

    $sql ="SELECT * FROM $usersTable";
    $result= $conn->query($sql);

    echo "<table border='4' cellspacing='0' >";
echo "<tr>
    <td colspan='9'>".$usersTable."</td>
</tr>";
echo "<tr>
        <th>AM</th>
        <th>firstName</th>
        <th>lastName</th>
        <th>SystemPassword</th>
        <th>phoneNumber</th>
        <th>email</th>
        <th>Category</th>
    </tr>";

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['AM']."</td>";
            echo "<td>".$row['firstName']."</td>";
            echo "<td>".$row['lastName']."</td>";
            echo "<td>".$row['SystemPassword']."</td>";
            echo "<td>".$row['phoneNumber']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['Category']."</td>";
            echo "</tr>";
        }
    }


?>