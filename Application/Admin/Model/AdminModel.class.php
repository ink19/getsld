<?php
	namespace Admin\Model;
	use Think\Model;
	class AdminModel extends Model{
		public function getId($data){
			$result=$this->where("name = '".$data."'")->find();
			return $result['id'];
		}
		public function getConf($data){
			$result=$this->where("name = '".$data."'")->find();
			return $result['value'];
		}
		public function saveConf($name,$data,$id=null){
			if(is_array($data)){
				$data=json_encode($data);
			}else{
				$data=$data;
			}
			$data=array('id' => $id,'name' => $name,'value' => $data);
			return $this->where("name ='".$data['name']."'")->save($data);
		}
		public function addConf($name,$data){
			if(is_array($data)){
				$data=json_encode($data);
			}else{
				$data=$data;
			}
			$data=array('name' => $name,'value' => $data);
			$this->add($data);
		}
		public function deleteConf($name){
			$this->where("name ='".$name."'")->delete();
		}
	}

?>