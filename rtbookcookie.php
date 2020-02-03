<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
setcookie('rtbook',1);
echo "<script>parent.location.href='rtbook.php?bookid=".$_GET['bookid']."'; </script>";
?>