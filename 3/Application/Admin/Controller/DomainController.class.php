<?php
	namespace Admin\Controller;
	use Think\Controller;
	class DomainController extends Controller{
		public function entry(){
			R('Admin/yz');
			$this->tittle="域名管理";
			$conf=D('Admin');
			$this->domain=json_decode($conf->getConf('frist_domain'),true);
			$this->display();
		}
		public function deletedomain($frist_domain){
			R('Admin/yz');
			$conf=D('Admin');
			$conf->deleteConf('domain_info_'.$frist_domaim);
			$con=json_decode($conf->getConf('frist_domain'),true);
			unset($con[$frist_domain]);
			$conf->saveConf('frist_domain',$con);
			$this->tittle="后台管理";
			$this->display('Index/contents');
		}
		public function renewdomain($frist_domain){
			R('Admin/yz');
			$this->tittle="更新域名";
			$this->frist_domain2=$frist_domain;
			$conf=D('Admin');
			$this->id=$conf->getId('domain_info_'.$frist_domain);
			$p=I('post.');
			if($p['submit']){
				$data['domain_id']=$p['domain_id'];
				$data['token_id']=$p['token_id'];
				$data['token']=$p['token'];
				$conf->saveConf('domain_info_'.$frist_domain,$data,$p['id']);
				$this->result="完成";
			}
			$this->frist_domain=json_decode($conf->getConf('domain_info_'.$frist_domain),true);
			$this->display();
		}
		public function adddomain(){
			R('Admin/yz');
			$this->tittle="添加域名";
			$p=I('post.');
			if($p['submit']){
				$conf=D('Admin');
				$conf_frist_domain=json_decode($conf->getConf('frist_domain'),true);
				$conf_frist_domain[$p['frist_domain']]=$p['frist_domain'];
				$conf_id=$conf->getId('frist_domain');
				$conf->saveConf('frist_domain',$conf_frist_domain,$conf_id);
				$data['domain_id']=$p['domain_id'];
				$data['token_id']=$p['token_id'];
				$data['token']=$p['token'];
				$conf->addConf('domain_info_'.$_POST['frist_domain'],$data,null);
				$this->result="完成";
			}
			$this->display();
		}
	}
?>