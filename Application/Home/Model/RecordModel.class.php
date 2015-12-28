<?php
namespace Home\Model;
use Think\Model;
class RecordModel extends Model{
	public function AddRecord(array $data){
		if(!$this->create($data,1)){
			return array(0,$this->getError());
		}else{
			$re=$this->add();
			if($this->getDbError()){
				return array(0,$this->getDbError());
			}else{
				return array(1,$re);
			}
		}
	}
	public function CountRecord($userid){
		return $this->where("`userid` = '{$userid}'")->count();
	}
	public function SaveRecord(array $data){
		if(!$this->create($data)){
			return array(0,$this->getError());
		}else{
			$re=$this->save();
			if($this->getDbError()){
				return array(0,$this->getDbError());
			}else{
				return array(1,$re); 
			}
		}
	}
	public function FindRecord($record_id,$userid){
		$result=$this->where("record_id='".$record_id."' and userid ='".$userid."'")->find();
		if(!$result['record_id']){
			return array(0);
		}else{
			return array(1,$result);
		}
	}
	public function FindAllRecord($userid){
		return $this->where("userid= '".$userid."'")->select();
	}
	public function DeleteRecord($record_id,$userid){
		$re=$this->where("record_id = '".$record_id."' and userid = '".$userid."'")->delete();
		if($this->getDbError()){
			return array(0,$this->getDbError());
		}else{
			return array(1,$re);
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