<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
    
    $UId = $_POST['id'];

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "UPDATE NeceMessage SET Adm ='0' WHERE id = '$UId' ";
    $dbh1->query($sql1);
    echo "<script>parent.location.href='newadm.php'; </script>";
?>