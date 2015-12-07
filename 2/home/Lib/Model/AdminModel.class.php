<?php
class AdminModel extends Model{
public function getConf($data){
return F($data);
}
public function saveConf($name,$data){
if(is_array($data)){
$data=json_encode($data);
}else{
$data=$data;
}
F($name,$data);
}
public function addConf($name,$data){
if(is_array($data)){
$data=json_encode($data);
}else{
$data=$data;
}
F($name,$data);
}
public function deleteConf($name){
F($name,null);
}
}

?>