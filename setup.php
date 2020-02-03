<?php

function setup(){
        
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
        
    // 创建连接
    $conn = new mysqli($servername, $username, $password);
    // 检测连接
    if ($conn->connect_error) {
        //die("连接失败: " . $conn->connect_error);
    } 
    
    // 创建数据库
    $sql = "CREATE DATABASE $myDB";
    if ($conn->query($sql) === TRUE) {
       // echo "数据库创建成功";
    } else {
        //echo "Error creating database: " . $conn->error;
    }
    
    $conn->close(); 
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $myDB);
    // 检测连接
    if ($conn->connect_error) {
        //die("连接失败: " . $conn->connect_error);
    } 
     
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE NeceMessage (
        id INT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        idcardnum VARCHAR(300) NOT NULL,
        studentnum VARCHAR(300) NOT NULL,
        major VARCHAR(300) NOT NULL,
        username VARCHAR(30),
        userpassword VARCHAR(300),
        adm BOOLEAN NOT NULL DEFAULT '0',
        mbtimes INT(5) NOT NULL DEFAULT '20',
        majorbook TEXT,
        umbtimes INT(5) NOT NULL DEFAULT '10',
        unmajorbook TEXT,
        nowtype INT(3) DEFAULT '-1',
        forbidentime VARCHAR(30) ,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )DEFAULT CHARSET=utf8";
    
    if ($conn->query($sql) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        //echo "创建数据表错误: " . $conn->error;
    }
     
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE BookMessage (
        id INT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        publictime VARCHAR(30) NOT NULL,
        author TEXT NOT NULL,
        press TEXT NOT NULL,
        identifier VARCHAR(100) NOT NULL,
        price INT(255) NOT NULL,
        cover TEXT,
        name TEXT NOT NULL,
        booknumber INT(255) NOT NULL,
        borrownumber INT(255) NOT NULL DEFAULT '0',
        major VARCHAR(300) NOT NULL,
        tags TEXT,
        isbn VARCHAR(30) NOT NULL,
        borrowtags TEXT,
        origin TEXT NOT NULL,
        summary TEXT,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )DEFAULT CHARSET=utf8";
     
    if ($conn->query($sql) === TRUE) {
      // echo "Table MyGuests created successfully";
    } else {
       //echo "创建数据表错误: " . $conn->error;
    }
     
    $conn->close();

}
setup();
?>

