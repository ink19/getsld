<?php
class InstallAction extends Action{
public function index(){
if(file_exists('./lock.lock')){
die('if you are administrator,please delete the file(lock.lock) ,then try again');
}
$prefix=C('DB_PREFIX');
$sql=M() or die(mysql_error());
$sql->query('CREATE TABLE '.$prefix.'user 
(
id int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
name text,
password varchar(32),
email text,
create_time int,
login_time int
)');
/*
if($sql->getDbError()){die($sql->getDbError());}
*/
$sql->query("CREATE TABLE ".$prefix."admin 
(
name text not null,
value text
)");
$sql->query("CREATE TABLE ".$prefix."record 
(
record_id int NOT NULL, 
PRIMARY KEY(record_id),
sub_domain varchar(15) NOT NULL,
frist_domain text NOT NULL,
record_type set('A','CNAME','AAAA') NOT NULL,
mx int,
ttl int NOT NULL,
value varchar(15) NOT NULL,
userid int NOT NULL
)");
$sql=D('Admin');
$data='admin@admin';
$sql->addConf('admin',$data);
$sql->addConf('frist_domain',null);
$sql->addConf('important_sub_domain',array('wap','3g','@'));
file_put_contents('lock.lock','lock.lock');
echo 'succeed';
}

}



?>