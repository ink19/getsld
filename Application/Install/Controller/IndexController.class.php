<?php
	namespace Install\Controller;
	use Think\Controller;
	class IndexController extends Controller{
		public function index(){
			if(file_exists('./lock.lock')){
				die('if you are administrator,please delete the file(lock.lock) ,then try again');
			}
			$this->display();
		}
		public function install(){
			if(!(($admin['name'] = I('post.admin_name')) and ($admin['password'] = I('post.admin_password')) and ($email['mail']=I('post.email_account')) and ($email['password'] = I('post.email_password')) and ($email['user'] = I('post.email_user')) and ($email['address'] = I('post.email_address')) and ($email['port'] = I('post.email_port')) and ($userlock = I('post.userlock')) and ($website = I('post.website')))){
				die('please finish all configure');
			}
			if(file_exists('./lock.lock')){
				die('if you are administrator,please delete the file(lock.lock) ,then try again');
			}
			$prefix=C('DB_PREFIX');
			$sql=M() or die(mysql_error());
			$sql->execute('CREATE TABLE '.$prefix.'user 
(
id int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
name text,
password varchar(32),
email text,
create_time int,
login_time int
)');
			if($sql->getDbError()){die($sql->getDbError());}
			$sql->execute("CREATE TABLE ".$prefix."admin 
(
id int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
name text not null,
value text
)");
			$sql->execute("CREATE TABLE ".$prefix."record 
(
record_id int NOT NULL, 
PRIMARY KEY(record_id),
sub_domain varchar(15) NOT NULL,
first_domain text NOT NULL,
record_type set('A','CNAME','AAAA') NOT NULL,
mx int,
ttl int NOT NULL,
value varchar(15) NOT NULL,
userid int NOT NULL
)");
			if($sql->getDbError()){die($sql->getDbError());}
			$sql->execute("CREATE TABLE ".$prefix."check 
(
num int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(num),
id text not null,
code text
)");
			if($sql->getDbError()){die($sql->getDbError());}
			$sql=D('Admin');
			$data=$admin['name'].'@'.$admin['password'];
			$sql->addConf('admin',$data);
			$sql->addConf('first_domain',null);
			$sql->addConf('important_sub_domain',array('wap','3g','@'));
			$sql->addConf('mail_info',$email);
			$sql->addConf('userlock',$userlock);
			$sql->addConf('website_address',$website);
			$sql->addConf('limit_number',0);
			$sql->addConf('admin_info',null);
			$sql->addConf('announcement',null);
			$sql->addConf('day',date('d'));
			file_put_contents('lock.lock','lock.lock');
			echo 'installed successfully,you can enter ./admin.php to manage your website.';
		}

	}
?>