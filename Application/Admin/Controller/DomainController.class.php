<?php
	namespace Admin\Controller;
	use Think\Controller;
	class DomainController extends Controller{
		public function add_domain(){
			R('Admin/yz');
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function ajax_add_domain(){
			R('Admin/yz');
			$first_domain = I('post.first_domain');
			$domain_conf['token_id'] = I('post.token_id');
			$domain_conf['token'] = I('post.token');
			$domain_conf['domain_id'] = I('post.domain_id');
			if($first_domain && $domain_conf['token'] && $domain_conf['token_id'] && $domain_conf['domain_id']){
				$Admin = D('Admin');
				$conf_first_domain=json_decode($Admin->getConf('first_domain'),true);
				$conf_first_domain[$first_domain]=$first_domain;
				$conf_id=$Admin->getId('first_domain');
				if($Admin->saveConf('first_domain',$conf_first_domain,$conf_id)){
					$data['domain_id']=$domain_conf['domain_id'];
					$data['token_id']=$domain_conf['token_id'];
					$data['token']=$domain_conf['token'];
					$Admin->addConf('domain_info_'.$first_domain,$data,null);
					$this->ajaxReturn("1","eval");
				}else{
					$this->ajaxReturn("数据库错误，请重试,错误：".$Admin->getDbError(),"eval");
				}
			}else{
				$this->ajaxReturn("信息不完整","eval");
			}
		}
		public function ajax_get_domainid(){
			R('Admin/yz');
			$domain_conf['first_domain'] = I('post.first_domain');
			$domain_conf['token_id'] = I('post.token_id');
			$domain_conf['token'] = I('post.token');
			$Dnspod = new \Org\Util\Dnspod($domain_conf);
			$Dnspod->dns_getinfo($domain_conf['first_domain']);
			$result = $Dnspod->result;
			if($result['status']['code'] == "1"){
				$result = array(1,$result['domain']['id']);
			}else{
				$result = array(0,$result['status']['message']);
			}
			$this->ajaxReturn($result,'json');
		}
		public function domain_list(){
			R('Admin/yz');
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function ajax_get_domain_list(){
			R('Admin/yz');
			$Admin = D('Admin');
			$domain = $Admin->getConf('first_domain');
			$domain = json_decode($domain,true);
			$Record = D('Record');
			foreach($domain as $vo){
				$domain_info = $Admin->getConf('domain_info_'.$vo);
				$domain_info = json_decode($domain_info,true);
				$count = $Record->CountDomainRecord($vo);
				$domain_list[] = array(
					'domain' => $vo,
					'domain_id' => $domain_info['domain_id'],
					'token_id' => $domain_info['token_id'],
					'domain_count' => $count
				);
			}
			$this->ajaxReturn($domain_list,'json');
		}
		public function ajax_change_domain(){
			R('Admin/yz');
			$domain = I('post.domain');
			$domain_id = I('post.domain_id');
			$token = I('post.token');
			$token_id = I('post.token_id');
			$Admin = D('Admin');
			$data = array(
				'domain_id' => $domain_id,
				'token' => $token,
				'token_id' => $token_id
			);
			if($Admin->saveConf('domain_info_'.$domain,$data)){
				$this->ajaxReturn("1",'eval');
			}else{
				$this->ajaxReturn("0",'eval');
			}
		}
		public function ajax_delete_domain(){
			R('Admin/yz');
			$domain_id = I('post.domain_id');
			$domain = I('post.domain');
			$Admin = D('Admin');
			$conf_first_domain=json_decode($Admin->getConf('first_domain'),true);
			unset($conf_first_domain[$domain]);
			$conf_id=$Admin->getId('first_domain');
			if($Admin->saveConf('first_domain',$conf_first_domain,$conf_id)){
				$Admin->deleteConf('domain_info_'.$domain);
				$this->ajaxReturn("1",'eval');
			}else{
				$this->ajaxReturn("数据库错误，请重试,错误：".$Admin->getDbError(),'eval');
			}
		}
		public function ajax_get_domain(){
			R('Admin/yz');
			$domain = I('post.domain');
			$Admin = D('Admin');
			$domain_conf = json_decode($Admin->getConf('domain_info_'.$domain),true);
			$this->ajaxReturn($domain_conf,'json');
		}
		//old
		public function entry(){
			R('Admin/yz');
			$this->tittle="域名管理";
			$conf=D('Admin');
			$this->domain=json_decode($conf->getConf('first_domain'),true);
			$this->display();
		}
		public function deletedomain($first_domain){
			R('Admin/yz');
			$conf=D('Admin');
			$conf->deleteConf('domain_info_'.$first_domain);
			$con=json_decode($conf->getConf('first_domain'),true);
			unset($con[$first_domain]);
			$conf->saveConf('first_domain',$con);
			$this->tittle="后台管理";
			$this->display('Index/contents');
		}
		public function renewdomain($first_domain){
			R('Admin/yz');
			$this->tittle="更新域名";
			$this->first_domain2=$first_domain;
			$conf=D('Admin');
			$this->id=$conf->getId('domain_info_'.$first_domain);
			$p=I('post.');
			if($p['submit']){
				$data['domain_id']=$p['domain_id'];
				$data['token_id']=$p['token_id'];
				$data['token']=$p['token'];
				$conf->saveConf('domain_info_'.$first_domain,$data,$p['id']);
				$this->result="完成";
			}
			$this->first_domain=json_decode($conf->getConf('domain_info_'.$first_domain),true);
			$this->display();
		}
		public function adddomain(){
			R('Admin/yz');
			$this->tittle="添加域名";
			$p=I('post.');
			if($p['submit']){
				$conf=D('Admin');
				$conf_first_domain=json_decode($conf->getConf('first_domain'),true);
				$conf_first_domain[$p['first_domain']]=$p['first_domain'];
				$conf_id=$conf->getId('first_domain');
				$conf->saveConf('first_domain',$conf_first_domain,$conf_id);
				$data['domain_id']=$p['domain_id'];
				$data['token_id']=$p['token_id'];
				$data['token']=$p['token'];
				$conf->addConf('domain_info_'.$_POST['first_domain'],$data,null);
				$this->result="完成";
			}
			$this->display();
		}
	}
?>