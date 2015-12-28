<?php
	namespace Org\Util;
	class Dnspod{
		protected $api_addr;			//API接口地址
		protected $api_data=array();	//POST的数据
		public $result=array();			//结果，数组形式
		public $record_type;			//记录类型
		public $value;					//记录的值
		public $sub_domain;				//下级域
		public $ttl;					//TTL值
		public $record_line;			//线路
		public $record_id;				//记录ID
		public $mx;						//mx优先值
		function __construct(array $domain_info){
			$this->api_data["login_token"]=$domain_info['token_id'].','.$domain_info['token'];
			if(isset($domain_info['domain_id'])){
				$this->api_data["domain_id"]=$domain_info['domain_id'];
			}
			$this->api_data["format"]="json";
			$this->api_data["lang"]="zh";
			$this->api_data["error_on_empty"]="no";
		}
		//集合curl的一个函数
		protected function dns_curl(){
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,"https://dnsapi.cn/".$this->api_addr);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($this->api_data));
			curl_setopt($ch,CURLOPT_USERAGENT,POST_UA);
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
			$result=curl_exec($ch);
			curl_close($ch);
			return json_decode($result,"true");
			$this->api_data=array();
		}
		//查询记录
		public function dns_cx(){
			$this->api_addr="Record.List";
			$this->result=$this->dns_curl();
		}
		//添加记录
		public function dns_add(){
			$this->api_addr="Record.Create";
			$this->api_data["record_type"]=$this->record_type;
			$this->api_data["sub_domain"]=$this->sub_domain;
			$this->api_data["record_line"]=$this->record_line;
			$this->api_data["value"]=$this->value;
			$this->api_data["mx"]=$this->mx;
			$this->api_data["ttl"]=$this->ttl;
			$this->result=$this->dns_curl();
		}
		//更新记录
		public function dns_updata(){
			$this->api_addr="Record.Modify";
			$this->api_data["record_type"]=$this->record_type;
			$this->api_data["sub_domain"]=$this->sub_domain;
			$this->api_data["record_line"]=$this->record_line;
			$this->api_data["value"]=$this->value;
			$this->api_data["mx"]=$this->mx;
			$this->api_data["ttl"]=$this->ttl;
			$this->api_data["record_id"]=$this->record_id;
			$this->result=$this->dns_curl();
		}
		//删除记录
		public function dns_delete(){
			$this->api_addr="Record.Remove";
			$this->api_data["record_id"]=$this->record_id;
			$this->result=$this->dns_curl();
		}
		public function dns_getinfo($domain){
			$this->api_addr = "Domain.Info";
			unset($this->api_data['domain_id']);
			$this->api_data['domain'] = $domain;
			$this->result=$this->dns_curl();
		}
		public function dns_recycle($data){
			$this->api_addr = "Batch.Record.Modify";
			$this->api_data['record_id'] = implode(',',$data);
			unset($this->api_data["domain_id"]);
			$this->api_data['change'] = 'status';
			$this->api_data['change_to'] = 'disabled';
			$this->result = $this->dns_curl();
		}
	}
?>