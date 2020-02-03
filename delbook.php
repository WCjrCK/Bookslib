<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
    mb_regex_encoding('utf-8');
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM BookMessage WHERE id = ".$_GET['bookid'];
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        $sql1 = "SELECT * FROM NeceMessage WHERE majorbook like '%".$row['name']."%'";
        $res1 = $dbh1->query($sql1);
        foreach($res1 as $row1){
            $sql1 = "UPDATE NeceMessage SET mbtimes =  ".($row1['mbtimes']+1).",majorbook = '".str_replace($row['name'],'',$row1['majorbook'])."' WHERE id =".$row1['id'];
            $dbh1->query($sql1);
        }
    }
    $sql1 = "DELETE FROM BookMessage  WHERE id =".$_GET['bookid'];
    $res = $dbh1->query($sql1);

    echo "<script>parent.location.href='library.php'; </script>";
?>