<?php
	namespace Home\Controller;
	use Think\Controller;
	class RecordController extends Controller{
		public function add(){
			$UserInfo=isLogin();
			$this->tittle='添加记录';
			$conf=D('Admin');
			$this->conf_frist_domain=json_decode($conf->getConf('frist_domain'),true);
			$this->display();
		}
		public function adding(){
			$UserInfo=isLogin();
			$this->tittle="添加结果";
			$conf=D('Admin');
			$conf_frist_domain=json_decode($conf->getConf('frist_domain'),true);
			$conf_important_sub_domain=json_decode($conf->getConf('important_sub_domain'),true);
			$record=D('Record');
			if(!in_array($_POST['frist_domain'],$conf_frist_domain)){
				$this->result=array(0,'顶级域错误');
			}elseif(in_array($_POST['sub_domain'],$conf_important_sub_domain)){
				$this->result=array(0,'域名前缀被保留');
			}elseif(!$record->CheckRecord(array("sub_domain" => $_POST['sub_domain'],"frist_domain" => $_POST['frist_domain']))){
				$this->result=array(0,'域名前缀已被使用');
			}else{
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$_POST['frist_domain']),true);
				$d=new \Org\Util\Dnspod($conf_domain_info);
				$d->record_type=$_POST['record_type'];
				$d->sub_domain=$_POST['sub_domain'];
				$d->value=$_POST['value'];
				$d->record_line="默认";
				$d->dns_add();
				$result=$d->result;
				if($result['status']['code']!="1"){
					$this->result=array(0,"API错误！".$result['status']['message']);
				}else{
					$data=array(
						"record_id" => $result['record']['id'],
						"sub_domain" => $_POST['sub_domain'],
						"frist_domain" => $_POST['frist_domain'],
						"record_type" => $_POST['record_type'],
						"value" => $_POST['value'],
						"userid" => $UserInfo['id']
					);
					$re=$record->AddRecord($data);
					if(!$re[0]){
						$this->result=array(0,$re[1]);
					}else{
						$this->result=array(1,'添加成功');
					}
				}
			}
			$this->display();
		}
		public function update($record_id){
			$UserInfo=isLogin();
			$this->tittle="更新域名";
			$record=D('Record');
			$this->record_info=$record->FindRecord($record_id,$UserInfo['id']);
			$this->display();
		}
		public function updating($record_id){
			$this->tittle="更新域名";
			$UserInfo=isLogin();
			$record=D('Record');
			$record_info=$record->FindRecord($record_id,$UserInfo['id']);
			if(!$record_info[0]){
				$this->result='这个域名不是你的';
			}else{
				$conf=D('Admin');
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$record_info[1]['frist_domain']),true);
				$d= new \Org\Util\Dnspod($conf_domain_info);
				$d->record_id=$record_info[1]['record_id'];
				$d->record_line="默认";
				$d->record_type=$_POST['record_type'];
				$d->sub_domain=$record_info[1]['sub_domain'];
				$d->mx='1';
				$d->value=$_POST['value'];
				$d->dns_updata();
				$result=$d->result;
				if($result['status']['code']!=1){ $this->result="失败".$result['status']['message']; }else{
					$data=array(
						"record_id" => $result['record']['id'],
						"record_type" => $_POST['record_type'],
						"value" => $_POST['value']
					);
				$this->result='成功';
				}
			}
			$this->display();
		}
		public function delete($record_id){
			$UserInfo=isLogin();
			$record=D('Record');
			$conf=D('Admin');
			$record_info=$record->FindRecord($record_id,$UserInfo['id']);
			if(!$record_info[0]){
				$this->result='这个域名不是你的';
			}else{
				$conf_domain_info=json_decode($conf->getConf('domain_info_'.$record_info[1]['frist_domain']),true);
				$d=new \Org\Util\Dnspod($conf_domain_info);
				$d->record_id=$_GET['record_id'];
				$d->dns_delete();
				$re=$d->result;
				if($re['status']['code']!='1'){
					$this->result="错误！".$re['status']['message'];
				}else{
					$record->DeleteRecord($record_id,$UserInfo['id']);
					$this->result="成功";
				}
			}
			$this->tittle="删除域名";
			$this->display();
		}
	}
?>