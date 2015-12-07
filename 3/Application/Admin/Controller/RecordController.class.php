<?php
	namespace Admin\Controller;
	use Think\Controller;
	class RecordController extends Controller{
		public function importantsub(){
			R('Admin/yz');
			$conf=D('Admin');
			$this->id=$conf->getId('important_sub_domain');
			if(I('submit',false)){
				$data1=explode(",",I('post.important'));
				$conf->saveConf('important_sub_domain',$data1,I('post.id'));
				$this->result="成功";
			}
			$this->important=implode(',',json_decode($conf->getConf('important_sub_domain'),true));
			$this->tittle="修改域名前缀";
			$this->display();
		}
		public function entry($id=null){
			R('Admin/yz');
			$Record=M('Record');
			if($id){
				$sql='userid ='.$id;
			}else{
				$sql=1;
			}
			$list = $Record->where($sql)->order('record_id')->page(I('get.p',1).',25')->select();
			$count = $Record->where($sql)->count();
			$Page  = new \Think\Page($count,25);
			$this->show = $Page->show();
			$this->result=$list;
			$this->tittle='用户记录管理';
			$this->display();
		}
		public function seerecord($record_id){
			$this->tittle="查看域名";
			R('Admin/yz');
			$record=D('Record');
			$this->result=$record->where("record_id ='".$record_id."'")->find();
			$this->display();
		}
		public function delete($record_id){
			R('Admin/yz');
			$record=D('Record');
			$conf=D('Admin');
			$record_info=$record->where("record_id ='".$record_id."'")->find();
			$conf_domain_info=json_decode($conf->getConf('domain_info_'.$record_info['frist_domain']),true);
			$d=new \Org\Util\Dnspod($conf_domain_info);
			$d->record_id=I('get.record_id');
			$d->dns_delete();
			$re=$d->result;
			if($re['status']['code']!='1'){
				$this->result="错误！".$re['status']['message'];
			}else{
				$record->DeleteRecord($record_id,$record_info['userid']);
				$this->result="成功";
			}
			$this->tittle="删除域名";
			$this->display();
		}
	}

?>