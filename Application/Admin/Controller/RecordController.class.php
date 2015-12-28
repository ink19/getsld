<?php
namespace Admin\Controller;
use Think\Controller;
class RecordController extends Controller{
	public function record_list(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function recycle(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function important_words(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function ajax_get_record_list(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$p = (int)(I('post.p')?I('post.p'):1);
		$Record = D('Record');
		$result = $Record->GetRecord($p);
		foreach($result as &$vo) {
			unset($result['mx']);
			unset($result['ttl']);
		}
		$all = ceil($Record->count()/10);
		$result = array('page' =>array(
				'all' => $all,
				'now' => $p
			),'content' => $result);
		$this->ajaxReturn($result,'json');
	}
	public function ajax_delete_record(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$record_id = I('post.record_id');
		if($record_id){
			$Record = D("Record");
			$record_info = $Record->FindRecord($record_id);
			if($record_info[0]){
				$Admin = D('Admin');
				$domain_conf = json_decode($Admin->getConf("domain_info_{$record_info[1]['first_domain']}"),true);
				//var_dump($Admin->getLastSql());
				$Dnspod = new \Org\Util\Dnspod($domain_conf);
				$Dnspod->record_id = $record_id;
				$Dnspod->dns_delete();
				if($Dnspod->result['status']['code'] != 1){
					$this->ajaxReturn(array(0,"DNSPOD删除域名失败，原因：".$Dnspod->result['status']['message']),'json');
				}else{
					$result = $Record->DeleteRecord($record_id);
					if($result[0]){
						$this->ajaxReturn(array(1,$record_id),'json');
					}else{
						$this->ajaxReturn(array(0,"删除失败，原因：".$result[1]),'json');
					}
				}
			}else{
				$this->ajaxReturn(array(0,"域名不存在"),'json');
			}
		}else{
			$this->ajaxReturn(array(0,"未获取记录ID"),'json');
		}
	}
	public function ajax_put_recycle(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$record_id = I('post.record_id');
		if($record_id){
			$Record = D("Record");
			$record_info = $Record->FindRecord($record_id);
			if($record_info[0]){
				$Admin = D('Admin');
				$domain_conf = json_decode($Admin->getConf("domain_info_{$record_info[1]['first_domain']}"),true);
				$Dnspod = new \Org\Util\Dnspod($domain_conf);
				$Dnspod->dns_recycle(array($record_id));
				if($Dnspod->result['status']['code'] != 1){
					$this->ajaxReturn(array(0,"DNSPOD回收域名失败，原因：".$Dnspod->result['status']['message']),'json');
				}else{
					$result = $Record->RecycleRecord(array($record_id));
					if($result[0][0]){
						$this->ajaxReturn(array(1,$record_id),'json');
					}else{
						$this->ajaxReturn(array(0,$result[0][1]),'json');
					}
				}
			}else{
				$this->ajaxReturn(array(0,"域名不存在"),'json');
			}
		}else{
			$this->ajaxReturn(array(0,"未获取记录ID"),'json');
		}
	}
	public function ajax_important_words(){
		R('Admin/yz');
		$conf = D('Admin');
		$important_words = I('post.important_words');
		if($important_words){
			$data=explode(",",$important_words);
			if($conf->saveConf('important_sub_domain',$data)){
				$this->ajaxReturn(array(1,$data),'json');
			}else{
				$this->ajaxReturn(array(0,json_decode($conf->getConf('important_sub_domain'))),'json');
			}
		}else{
			$this->ajaxReturn(json_decode($conf->getConf('important_sub_domain')),'json');
		}
	}
	public function ajax_get_recycle_list(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$p = (int)(I('post.p')?I('post.p'):1);
		$Record = D('Record');
		$result = $Record->GetRecycleRecord($p);
		foreach($result as &$vo) {
			unset($result['mx']);
			unset($result['ttl']);
		}
		$all = ceil($Record->where("`userid` = '0'")->count()/10);
		$result = array('page' =>array(
				'all' => $all,
				'now' => $p
			),'content' => $result);
		$this->ajaxReturn($result,'json');
	}
}
?>