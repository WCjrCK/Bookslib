<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
if($_COOKIE['cbbases']==0){
    echo "parent.location.href='library.php'; </script>";
}
require_once("upload.class.php");
$servername = "localhost";
$username = "BigHomework";
$password = "20010326@Jiao";
$myDB ="BigHomework";

if($_POST['number']<=0){
    setcookie('cbbases',0);
    echo "<script> alert('修改后数量不合逻辑！本次修改无效!');parent.location.href='library.php'; </script>";
}

$dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
    PDO::ATTR_PERSISTENT=>true 
    )); 

    $sql1 = "SELECT * FROM BookMessage WHERE id =".$_POST['bookid'];
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        if($row['borrownumber']>$_POST['number']){
            setcookie('cbbases',0);
            echo "<script> alert('修改后数量小于在借阅数量！本次修改无效!');parent.location.href='library.php'; </script>";
        }
    }

if($_FILES["file"]['name']!=''){
    
    $myFile = new Upload($_FILES["file"]);

    $myFile->rename($_POST["new_name"]);//尝试重命名

    $limit_type=$myFile->limit();
    setcookie('cbbases',0);

    switch ($limit_type) {

        case 0:

            if($result = $myFile->upload()){
                $tmpress = "./picture/".$result;
                $sql1 = "UPDATE BookMessage SET cover = '$tmpress' WHERE id =".$_POST['bookid'];
                $res = $dbh1->query($sql1);

                echo "<script> alert('文件上传成功!');</script>";

            }else{

                echo "<script> alert('文件上传失败!本次修改无效!');parent.location.href='library.php'; </script>";

            }

            break;
        
        case 2:

            echo "<script> alert('上传失败：文件过大(最大为20000kb)本次修改无效!');parent.location.href='library.php'; </script>";

            break;

        case 3:

            echo "<script> alert('上传失败：你正在上传经过伪装的文件！本次修改无效!');parent.location.href='library.php'; </script>";

            break;

        case 4:

            echo "<script> alert('上传失败：不允许上传该文件类型！本次修改无效!');parent.location.href='library.php'; </script>";

            break;
            
        default:

            echo "<script> alert('上传失败：文件不合法！本次修改无效!');parent.location.href='library.php'; </script>";

            break;

    }
}
    $sql1 = "UPDATE BookMessage SET name =".$_POST['name'].", 
    author =".$_POST['author'].", 
    publictime =".$_POST['publictime'].",
    press =".$_POST['press'].", 
    identifier =".$_POST['identifier'].", 
    price =".$_POST['price'].", 
    major =".$_POST['major'].", 
    tags =".$_POST['tags'].", 
    isbn =".$_POST['isbn'].", 
    origin =".$_POST['origin']."
     WHERE id =".$_POST['bookid'];
    $res = $dbh1->query($sql1);
    setcookie('cbbases',0);
    echo "<script>parent.location.href='library.php'; </script>";
?>