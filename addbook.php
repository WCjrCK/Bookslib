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

    setcookie('abbases',1);
        echo "<body>
        <a href='library.php'><button>返回主界面</button></a>
        <form action=\"adbases.php\" method=\"post\" enctype=\"multipart/form-data\">
            <div style=\"border:1px solid;\">
                <table>
                    <tr>
                        <td rowspan=\"5\">
                            <div style=\"padding:20px\">
                                <div>选择封面图</div>
                                <input type=\"file\" name='file' accept=\"image/*\" onchange='PreviewImage(this)'/>
                                <div id=\"imgPreview\" style='width: 200px; height: 200px;'>
                                    <img src=";
        echo "./picture/default.png";     
        echo " height=\"200px\" width=\"200px\" />
                                </div>
                            </div>
                        </td>
                        <td style=\"height:40px;padding:10px\"><div><b>书名：</b></div><input required name=\"new_name\"></td>
                    </tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>作者：</div><input required name=\"author\"></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>出版社：</div><input required name=\"press\"><div>出版日期：</div><input required name=\"publictime\"></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>ISBN码：</div><input required name=\"isbn\"><div>价格：</div><input required name=\"price\"><div>索书号：</div><input required name=\"identifier\"></td></tr>
                    <tr><td style=\"height:40px;padding:10px\"><div>来源：</div><input required name=\"origin\"></td></tr>
                    <tr><td></td><td>简介：<input class=\"summary\" name=\"summary\"></td></tr>
                </table>
                <div style=\"padding:20px\">相关专业：<input required name=\"major\"></div>
                <div style=\"padding:20px\">标签：<input name=\"tags\"></div>
                <div style=\"padding:20px\">数量：<input name=\"numbers\"></div>
                <button style=\"margin:20px\">添加</button>
            </div>
        </form>
    </body>
    </html>";
?>