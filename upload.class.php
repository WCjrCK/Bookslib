<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
class Upload{
    //以下函数可以增加，成员变量可以自由增删，我只是给出了一个比较可行的例子，只要你写的类能根据upload_file.php的逻辑实现文件的上传就行了
    var $type;//上传文件后缀
    var $root_type;//文件大类(是图片还是其它文件)
    var $name;//上传文件名
    var $size;//文件大小
    var $realFile;//这是保存文件的变量，提示，它可以直接由php提供的$_FILES变量赋值
    static $maxSize = 20480000;//最大尺寸10000kb
    //允许的上传文件类型，实际上应该从数据库中读取，这里写死，请改用数据库
    static $permit_type = array(
            0 => 'jpg',
            1 => 'png',
            2 => 'gif',
            3 => 'jpeg'
    );
    static $permit_type_len = array(0,0);

    public function resize_image($filename, $tmpname,$targimg, $xmax, $ymax){
    $ext = explode(".", $filename);
    $ext = $ext[count($ext)-1];
 
    if($ext == "jpg" || $ext == "jpeg")
        $im = imagecreatefromjpeg($tmpname);
    elseif($ext == "png")
        $im = imagecreatefrompng($tmpname);
    elseif($ext == "gif")
        $im = imagecreatefromgif($tmpname);
 
    $x = imagesx($im);
    $y = imagesy($im);
 
    if($x <= $xmax && $y <= $ymax)
        return $im;
 
    if($x >= $y) {
        $newx = $xmax;
        $newy = $newx * $y / $x;
    }
    else {
        $newy = $ymax;
        $newx = $x / $y * $newy;
    }
 
    $im2 = imagecreatetruecolor($newx, $newy);
    imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

    if($ext == "jpg" || $ext == "jpeg")
        imagejpeg($im2,$targimg);
    elseif($ext == "png")
        imagepng($im2,$targimg);
    elseif($ext == "gif")
        imagegif($im2,$targimg);
    }

    public function inarray($lastname){//done

        $permit_type = array(
            0 => 'jpg',
            1 => 'png',
            2 => 'gif',
            3 => 'jpeg'
        );

        for($i=0; $i<4; $i++){

            echo $permit_type[$i]." ".$lastname."<br>";
            if(strcmp(strval($permit_type[$i]),strval($lastname))==0){

                return true;

            }

        }

        return false;

    }

    public function __construct($realFile) {//done

        global $name,$size,$root_type,$type,$maxSize;

        $name=str_replace(strrchr($_FILES["file"]['name'], "."),"",$_FILES["file"]['name']);

        $size=$_FILES["file"]['size'];

        if(str_replace(strrchr($_FILES["file"]['type'], "/"),"",$_FILES["file"]['type'])=="image"){

            $root_type=1;

        }else{

            $root_type=0;

        }

        $type=str_replace($_FILES["file"]['type'],"",strrchr($_FILES["file"]['type'], "/"));

        $type=str_replace("/","",$type);

        $maxSize = 20480000;

        //构造函数，用于创建一个上传请求的对象
    }

    public function upload(){//done
        
        global $root_type, $type, $name;

        
        $uper=$_SERVER["REMOTE_ADDR"];

        $uperc=str_replace(":",".",strval($uper));
        
        $name1=$_FILES["file"]['name'];

        $tas=0;

            $filedir="picture/";

            if(!is_dir($filedir)){

                mkdir($filedir,0777,true);

            }
        
            while(1){

                $name1=$filedir.$name."_".$tas.".".$type;

                if (file_exists($name1)){

                    $tas++;

                    continue;
            
                }else{
                // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    $this->resize_image($name."_".$tas.".".$type,$_FILES["file"]["tmp_name"],$name1,200,200);
                    //move_uploaded_file($_FILES["file"]["tmp_name"], $name1);

                    break;

                }
            
            }

            $name1=$name."_".$tas.".".$type;

        return $name1;
        //对当前对象执行上传的操作,提示：上传后文件的信息至少应当存在数据库的某个表中√，要求图片和其他类型的文件能被分类到files和pictures两个目录中，命名格式自行发挥
        //返回值要求上传失败返回false即可，上传成功可以返回一个文件存储信息的json
    }

    public function limit(){//done

        global $size, $maxSize, $name, $root_type, $type;

        if($size > $maxSize){

            return 2;

        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mimetype = finfo_file($finfo, $_FILES["file"]['tmp_name']);

        /*$mimetype=str_replace($mimetype,"",strrchr($mimetype, "/"));

        $mimetype=str_replace("/","",$mimetype);*/

        finfo_close($finfo);
        
        if(strcmp($mimetype,'application/zip')==0){

            $mimetype='application/x-zip-compressed';

        }

        if(strcmp($mimetype,'application/x-rar')==0){
            $mimetype='application/octet-stream';
        }
        
        $lastname = str_replace($_FILES["file"]['name'],"",strrchr($_FILES["file"]['name'], "."));

        $lastname = str_replace(".","",$lastname);

        $type=$lastname;

        if($mimetype!=$_FILES["file"]['type']){

            return 3;

        }

        if(!$this->inarray($lastname)){

            return 4;

        }

        return 0;

        //上传限制的方法，主要用于检测文件的各项合法(如大小)，如果你能考虑到更多安全的因素(不仅是文件类型)，那么更能体现你的NB,至于
        //返回值默认只要合法返回true,不合法返回false，如果想分类错误类型，那么请优秀的你自行修改我upload_file.php里的逻辑以便更好地报错
    }

    public function rename($rename){ //done

        global $name,$root_type;

        if($rename==""){

            return false;

        }

        $name=$rename;

        return true;

        //修改上传文件名的方法，传入name则改名，不传则不改名
        //改名返回true，未修改返回false
    }

}