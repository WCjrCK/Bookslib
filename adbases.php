<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
if($_COOKIE['abbases']==0){
    echo "parent.location.href='library.php'; </script>";
}
require_once("upload.class.php");
$servername = "localhost";
$username = "BigHomework";
$password = "20010326@Jiao";
$myDB ="BigHomework";

$dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
    PDO::ATTR_PERSISTENT=>true 
    )); 

if($_FILES["file"]['name']!=''){
    
    $myFile = new Upload($_FILES["file"]);

    $myFile->rename($_POST["new_name"]);//尝试重命名

    $limit_type=$myFile->limit();

    switch ($limit_type) {

        case 0:

            if($result = $myFile->upload()){
                $tmpress = "./picture/".$result;

                $sql1 = "INSERT INTO BookMessage (name,author,publictime,press,identifier,price,major,tags,isbn,origin,booknumber,cover) 
                values( \"".$_POST['new_name']."\", \"".$_POST['author']."\", \"".$_POST['publictime']."\",\" 
                ".$_POST['press']."\",\" ".$_POST['identifier']."\",\" ".$_POST['price']."\", \"
                ".$_POST['major']."\",\" ".$_POST['tags']."\",\" ".$_POST['isbn']."\",\" ".$_POST['origin']."\" ,\" ".$_POST['numbers']."\" ,\" ".$tmpress."\"
                 )";
                 //echo $sql1;
                setcookie('abbases',0);
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
}else{
    
    $sql1 = "INSERT INTO BookMessage (name,author,publictime,press,identifier,price,major,tags,isbn,origin,booknumber) 
    values( \"".$_POST['new_name']."\", \"".$_POST['author']."\", \"".$_POST['publictime']."\",\" 
    ".$_POST['press']."\",\" ".$_POST['identifier']."\",\" ".$_POST['price']."\", \"
    ".$_POST['major']."\",\" ".$_POST['tags']."\",\" ".$_POST['isbn']."\",\" ".$_POST['origin']."\" ,\" ".$_POST['numbers']."\"
     )";
    setcookie('abbases',0);
    $res = $dbh1->query($sql1);
}
    echo "<script>parent.location.href='library.php'; </script>";
?>