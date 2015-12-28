<?php
/**
 * record_id
 * sub_domain
 * first_domain
 * record_type
 * mx
 * ttl
 * value
 * userid
 */
namespace Admin\Model;
use Think\Model;
class RecordModel extends Model{
	public function AddRecord(array $data){
		if(!$this->create($data,1)){
			return array(0,$this->getError());
		}else{
			$re=$this->add($data);
			if($this->getDbError()){
				return array(0,$this->getDbError());
			}else{
				return array(1,$re);
			}
		}
	}
	public function CountDomainRecord($domain){
		return $this->where("`first_domain` = '{$domain}'")->count();
	}
	public function CountUserRecord($id){
		return $this->where("`userid` = {$id}")->count();
	}
	public function SaveRecord(array $data){
		if(!$this->create($data)){
			return array(0,$this->getError());
		}else{
			$re=$this->save($data);
			if($this->getDbError()){
				return array(0,$this->getDbError());
			}else{
				return array(1,$re);
			}
		}
	}
	public function RecycleRecord($data){
		foreach($data as &$vo){
			if($this->where("`record_id` = '{$vo}'")->setField('userid',0)){
				$vo = array(1);
			}else{
				$vo = array(0,$this->getDbError());
			}
		}
		return $data;
	} 
	public function FindRecord($record_id){
		$result=$this->where("record_id= '{$record_id}'")->find();
		if(!$result['record_id']){
			return array(0,$this->getDbError());
		}else{
			return array(1,$result);
		}
	}
	public function GetRecord($p){
		return $this->where("`userid` != '0'")->page("{$p},10")->order("record_id")->order("record_id")->select();
	}
	public function GetRecycleRecord($p){
		return $this->where("`userid` = '0'")->order("record_id")->page("{$p},10")->order("record_id")->select();
	}
	public function FindUserAllRecord($userid){
		return $this->where("userid= '{$userid}'")->select();
	}
	public function DeleteRecord($record_id){
		$re=$this->where("record_id = '{$record_id}'")->delete();
		if($this->getDbError()){
			return array(0,$this->getDbError());
		}else{
			return array(1);
		}
	}
	public function CheckRecord($data){
		if($this->where($data)->find()){
			return false;
		}else{
			return true;
		}
	}
	public function AdminRecord($id){
		if($id){
			return $this->where("userid= '".$id."'")->select();
		}else{
			return $this->select();
		}
	}
}
?>