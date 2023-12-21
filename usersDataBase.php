<?php

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


    //===========================================================================================//
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

    //============================================================================================//

    //Create usersTable

    /*
    $sql = "CREATE TABLE $usersTable(
        AM VARCHAR(15) PRIMARY KEY ,
        firstName VARCHAR(25) NOT NULL,
        lastName VARCHAR(25) NOT NULL,
        SystemPassword VARCHAR(50) NOT NULL,
        phoneNumber INT(15) NOT NULL,
        email VARCHAR(50),
        Category VARCHAR(5) NOT NULL 
    )";

    //Check create table

    if($conn->query($sql)===TRUE){
        echo 'Table usersTable create';
    }else{
        echo 'Error Fuck';
    }
    */
    //Import 2 Emplooyers in Table

    //First John Doe
    
    /*
    $sql = "INSERT INTO $usersTable (AM,firstname,lastname,SystemPassword,phoneNumber,email,Category)
        VALUES ('AM1234','John','Doe','AM1234','6999999','johnDoe@gmail.com','EMP')";
    
    if($conn->query($sql)===TRUE){
        echo 'John Doe import';
    }else{
        echo 'Error Fuck';
    }

    //Second George Denesidis
    $sql = "INSERT INTO $usersTable (AM,firstname,lastname,SystemPassword,phoneNumber,email,Category)
        VALUES ('AM5678','George','Denesidis','AM5678','6986335','georgeDen@gmail.com','EMP')";
    
    if($conn->query($sql)===TRUE){
        echo 'George Denesidis import';
    }else{
        echo 'Error Fuck';
    }
    */

    //Add 1 boss in usersTable
    /*
    $sql = "INSERT INTO $usersTable (AM,firstname,lastname,SystemPassword,phoneNumber,email,Category)
        VALUES ('BO1234','Big','Boss','Boss','6986336','bossBig@gmail.com','PRO')";
    if($conn->query($sql)===TRUE){
        echo 'Big Boss import';
    }else{
        echo 'Error Fuck';
    }
    */
    //===================================================================================================//
    
    //Create categoriesTable

    /*
    $sql = "CREATE TABLE $catgoryUsers(
        id INT(10) NOT NULL,
        Symbol VARCHAR(5) PRIMARY KEY,
        Catname VARCHAR(15) NOT NULL
    )";

    if($conn->query($sql)===TRUE){
        echo 'Table CREATE';
    }else{
        echo 'Error Fuck';
    }

    //Import categories

    $sql = "INSERT INTO $catgoryUsers (id,Symbol,Catname)
        VALUES (1,'EMP','Employeer')";

    if($conn->query($sql)===TRUE){
        echo 'Category import';
    }else{
        echo 'Error Fuck';
    }

    $sql = "INSERT INTO $catgoryUsers (id,Symbol,Catname)
        VALUES (2,'PRO','Afentiko')";

    if($conn->query($sql)===TRUE){
        echo 'Category import';
    }else{
        echo 'Error Fuck';
    }
    */
?>