<?php 
	class UserModel extends db {
		public function login($data=array()){
			$result = array();
			$user_email 	= $this->escape(pure_text($data['user_email']));
			$user_password 	= $this->escape($data['user_password']);
			$id_user_fb		= $this->escape($data['id_user_fb']);
			if(!empty($id_user_fb)){
				$sql = "SELECT * FROM com_user WHERE id_user_fb = '".$id_user_fb."' limit 0,1";
			}else{
				$sql = "SELECT * FROM com_user WHERE user_email = '".$user_email."' AND user_password = '".md5($user_password)."' limit 0,1";
			}
			$result_user = $this->query($sql); 
			if($result_user->num_rows > 0){
				$id_user 			= $result_user->row['id_user'];
				$user_key 			= $result_user->row['user_key'];
				$result 			= $result_user->row;
				$result['token'] 	= encode($id_user,$user_key);
			}
			return $result;
		}
		public function register($data=array()){
			$result = array();
			$email 			= !empty($data['user_email']) ? $this->escape($data['user_email']) : '' ;
			$user_password 	= !empty($data['user_password']) ? $this->escape($data['user_password']) : '' ;
			$user_name 		= !empty($data['user_name']) ? $this->escape($data['user_name']) : '' ;
			$user_lastname 	= !empty($data['user_lastname']) ? $this->escape($data['user_lastname']) : '' ;
			$id_user_fb 	= !empty($data['id_user_fb']) ? $this->escape($data['id_user_fb']) : '' ;
			$user_phone		= !empty($data['user_phone']) ? $this->escape($data['user_phone']) : '' ;

			if(!empty($id_user_fb)){
				$sql_check_dupplicate_if_fb = "SELECT * FROM com_user WHERE id_user_fb = '".$id_user_fb."'";
				$query_check = $this->query($sql_check_dupplicate_if_fb);
				if($query_check->num_rows > 0){
					$result['status'] 	= 'success';
					$result['desc'] 	= 'ไม่สมัครใหม่ เนื่องจากมี email ในระบบแล้ว';
					return $result;
				}
			}
			if(!empty($email)){
				$sql_check_dupplicate_email = "SELECT * FROM com_user WHERE user_email = '".$email."'";
				$query_check = $this->query($sql_check_dupplicate_email);
				if($query_check->num_rows == 0){
					$data_insert_user = array(
						'user_email' 		=> $email,
						'user_password' 	=> md5($user_password),
						'user_name'			=> $user_name,
						'user_lastname'		=> $user_lastname,
						'user_key'			=> rand(10000,99999),
						'user_date_create'	=> date('Y-m-d H:i:s'),
						'id_user_fb'		=>	$id_user_fb,
						'user_phone'		=> 	$user_phone
					);
					$id_user = $this->insert('user',$data_insert_user);
					$result['status'] 	= 'success';
					$result['desc'] 	= '';
					return $result;
				}else{
					$result['status'] 	= 'fail';
					$result['desc']		= 'Email นี้มีอยู่ในระบบแล้ว';
					return $result;
				}
			}else{
				$result['status'] 	= 'fail';
				$result['desc']		= 'Email เป็นค่าว่าง';
				return $result;
			}
		}
		public function findEamil($email) {
			$this->where('user_email', $email);
			$result = $this->get('user');
			return $result->num_rows;
		}
	}
?>