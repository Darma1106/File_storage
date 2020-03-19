<?php
class UpHelper {
protected $flie_destination;
protected $dir;
public function save_upload_file(){
$flies = $this->format_upload_file();
foreach ($flies as $flie) {
    if ($flie['error'] == 0) {
        if (is_uploaded_file($flie['tmp_name'])) {
            $destination = $this->dir.'/'.time().mt_rand(1,9999).'.'.pathinfo($flie['name'])['extension'];
            $this->flie_destination = $destination;
            //存储文件
            move_uploaded_file($flie['tmp_name'], $destination);
        }
    }
}
}
private function format_upload_file():array{
    //创建文件夹
    $this->makeDir();
    $flies = [];
    //判断上传的是一个文件还是多个文件
foreach ($_FILES as $flied) {
    if (is_array($flied['name'])) {
        foreach ($flied['name'] as $id => $value) {
            $flies[] = [
                'name'=>$flied['name'][$id],
                'type'=>$flied['type'][$id],
                'tmp_name'=>$flied['tmp_name'][$id],
                'error'=>$flied['error'][$id],
                'size'=>$flied['size'][$id]
            ];
        }    
    }
    else {
        $flies[] = $flied;
    }
}
return $flies;
}
//如果不存在文件夹就创建
private function makeDir():bool{
    $dir_path = date('y/m');
    $this->dir = $dir_path;
  return  is_dir($dir_path)?:mkdir($dir_path,0755,true);
  //文件夹权限请看情况更改
}
public function get_destination(){
    return $this->flie_destination;
}

}
?>