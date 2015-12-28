<?php
	namespace Home\Controller;
	use Think\Controller;
	class RecordController extends Controller{
		public function myrecord(){
			$UserInfo=isLogin();
			C('LAYOUT_ON',false);
			$record=D('Record');
			$this->record=$record->FindAllRecord($UserInfo['id']);
			$this->UserInfo=$UserInfo;
			$this->display();
		}
		public function addrecord(){
			C('LAYOUT_ON',false);
			$UserInfo = isLogin();
			$conf = D('Admin');
			$this->conf_first_domain = json_decode($conf->getConf('first_domain'),true);
			$this->display();
		}
		public function ajax_add(){
			$UserInfo=isLogin();
			$verify = new \Think\Verify();
			if(!$verify->check(I('post.verify'))){
				die('验证码错误');
			}
			$first_domain = I('post.first_domain');
			$sub_domain = I('post.sub_domain');
			$record_type = I('post.record_type');
			$value = I('post.value');
			$conf = D('Admin');
			$conf_first_domain = json_decode($conf->getConf('first_domain'),true);
			$conf_important_sub_domain = json_decode($conf->getConf('important_sub_domain'),true);
			$record = D('Record');
			if(!($limit_number = $conf->getConf('limit_number'))){
				$limit = 0;
			}else{
				$limit = 1;
			}
			if(!in_array($first_domain,$conf_first_domain)){
				die('顶级域错误');
			}elseif(in_array($sub_domain,$conf_important_sub_domain)){
				die('域名前缀被保留');
			}elseif(!$record->CheckRecord(array("sub_domain" => $sub_domain,"first_domain" => $first_domain))){
				die('域名前缀已被使用');
			}elseif(($record->CountRecord($UserInfo['id']) >= $limit_number) and $limit){
				die('域名数超过限制');
			}else{
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$first_domain),true);
				$d=new \Org\Util\Dnspod($conf_domain_info);
				$d->record_type=$record_type;
				$d->sub_domain=$sub_domain;
				$d->value=$value;
				$d->record_line="默认";
				$d->dns_add();
				$result=$d->result;
				if($result['status']['code']!="1"){
					die("API错误！".$result['status']['message']);
				}else{
					$data=array(
						"record_id" => $result['record']['id'],
						"sub_domain" => $sub_domain,
						"first_domain" => $first_domain,
						"record_type" => $record_type,
						"value" => $value,
						"userid" => $UserInfo['id'],
						"ttl" => '600'
					);
					$re=$record->AddRecord($data);
					if(!$re[0]){
						die($re[1]);
					}else{
						die('1');
					}
				}
			}
		}
		public function changemyrecord(){
			$record_id = I('post.id');
			$record_type = I('post.type');
			$record_value = I('post.value');
			$UserInfo=isLogin();
			$record=D('Record');
			$record_info=$record->FindRecord($record_id,$UserInfo['id']);
			if(!$record_info[0]){
				die('这个域名不是你的');
			}else{
				$conf=D('Admin');
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$record_info[1]['first_domain']),true);
				$d= new \Org\Util\Dnspod($conf_domain_info);
				$d->record_id=$record_info[1]['record_id'];
				$d->record_line="默认";
				$d->record_type=$record_type;
				$d->sub_domain=$record_info[1]['sub_domain'];
				$d->mx='1';
				$d->value=$record_value;
				$d->dns_updata();
				$result=$d->result;
				if($result['status']['code']!=1){ 
					die("失败".$result['status']['message']); 
				}else{
					$data=array(
						"record_id" => $result['record']['id'],
						"record_type" => $_POST['record_type'],
						"value" => $_POST['value']
					);
					$sql_result = $record->SaveRecord($data);
					if($sql_result[0]){
						die("1");
					}else{
						die("0");
					}
				}
			}
		}
		public function deletemyrecord(){
			$record_id = I("post.id");
			$UserInfo=isLogin();
			$record=D('Record');
			$conf=D('Admin');
			$record_info=$record->FindRecord($record_id,$UserInfo['id']);
			if(!$record_info[0]){
				die('这个域名不是你的');
			}else{
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$record_info[1]['first_domain']),true);
				$d=new \Org\Util\Dnspod($conf_domain_info);
				$d->record_id = $record_id;
				$d->dns_delete();
				$re=$d->result;
				if($re['status']['code']!='1'){
					die("错误！".$re['status']['message']);
				}else{
					$record->DeleteRecord($record_id,$UserInfo['id']);
					die("1");
				}
			}
		}
	}
?>