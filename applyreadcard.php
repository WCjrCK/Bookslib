<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
    
    $UNAME =  $_COOKIE['User'];
    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM NeceMessage WHERE username = '$UNAME' ";
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        $UId = $row['id'];
        $sql1 = "UPDATE NeceMessage SET nowtype ='0' WHERE id = '$UId' ";
        $dbh1->query($sql1);
    }
    echo "<script>alert('申请成功!借阅卡卡号为".($UId+100000)."');parent.location.href='personmess.php'; </script>";
?>