<html>
    <head>
        <script> 
          function PreviewImage(imgFile) {
            var path;
            if (document.all) {//IE 
                imgFile.select();
                path = document.selection.createRange().text;
                document.getElementById("imgPreview").innerHTML = "";
                document.getElementById("imgPreview").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='scale',src=\"" + path + "\")";//使用滤镜效果 
            } else {//FF 
                path = URL.createObjectURL(imgFile.files[0]);
                document.getElementById("imgPreview").innerHTML = "<img src='"+path+"' height=\"200px\" width=\"200px\" />";
            }
          }
        </script>
    </head>
<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
} 
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM BookMessage WHERE id =".$_POST['bookid'];
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        echo "<body>
        <a href='library.php'><button>返回主界面</button></a>
        <form action=\"cbbases.php\" method=\"post\" enctype=\"multipart/form-data\">
            <input style=\"display:none\" type=\"text\" name=\"bookid\" value=".$_POST['bookid']." />
            <div style=\"border:1px solid;\">
                <table>
                    <tr>
                        <td rowspan=\"5\">
                            <div style=\"padding:20px\">
                                <div>选择封面图</div>
                                <input type=\"file\" name='file' accept=\"image/*\" onchange='PreviewImage(this)'/>
                                <input style=\"display:none\" type=\"text\" name=\"new_name\" value=".$row['name']." />
                                <div id=\"imgPreview\" style='width: 200px; height: 200px;'>
                                    <img src=";
        if($row['cover']!=""){
            echo $row['cover'];
        }else{
            echo "./picture/default.png";
        }              
        echo " height=\"200px\" width=\"200px\" />
                                </div>
                            </div>
                        </td>
                        <td style=\"height:40px;padding:10px\"><div><b>书名：</b></div><input required name=\"name\" value=".$row['name']."></td>
                    </tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>作者：</div><input required name=\"author\" value=".$row['author']."></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>出版社：</div><input required name=\"press\" value=".$row['press']."><div>出版日期：</div><input required name=\"publictime\" value=".$row['publictime']."></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>ISBN码：</div><input required name=\"isbn\" value=".$row['isbn']."><div>价格：</div><input required name=\"price\" value=".$row['price']."><div>索书号：</div><input required name=\"identifier\" value=".$row['identifier']."></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>来源：</div><input required name=\"origin\" value=".$row['origin']."></td></tr>
                    <tr><td></td><td>简介：<input class=\"summary\" name=\"summary\" value=".$row['summary']."></td></tr>
                </table>
                <div style=\"padding:20px\">相关专业：<input required name=\"major\" value=".$row['major']."></div>
                <div style=\"padding:20px\">标签：<input name=\"tags\" value=".$row['tags']."></div>
                <div style=\"padding:20px\">数量：<input name=\"number\" value=".$row['booknumber']."></div>
                <button style=\"margin:20px\"><font color=red>修改</font></button>
            </div>
        </form>
    </body>
    </html>";
    }
?>