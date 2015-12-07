<?php
	namespace Admin\Model;
	use Think\Model;
	class CheckModel extends Model {
		public function AddCode($id){
			$salt=rand();
			$data["code"]=md5($salt.$id).md5($salt);
			$data["id"]=$id;
			if($this->add($data)){
				return 1;
			}else{
				return $this->getDbError();
			}
		}
		public function CheckCode($id,$code){
			if(!($result=$this->where("`id`=".$id." and `code`=".$code."")->find())){
				return 0;
			}else{
				return $result["id"];
			}
		}
		public function DeleteCode($id){
			$this->where("`id`=".$id)->delete();
		}
		public function DeleteAllCode(){
			if($this->where("`id` > 0")->delete()){
				return 1;
			}else{
				return 0;
			}
	}
?>