<?php 
	class BarcodeModel extends db {
		public function addRowBarcode($data=array()){
			$result = array();
			$array_insert = array(
				'size_product_code' => $data['size_product_code'],
				'sum_product' => $data['sum_product'],
				'date_wk'	=> $data['date_wk']
			);
			$result_insert = $this->insert('product',$array_insert);
			return $result_insert;
		}
		public function deleteGroup($data = array()){
			$result = array();
			$id_group = (int)$data['id_group'];

			$sql = "DELETE FROM ".PREFIX."group WHERE id_group = '".$id_group."'";
			$result_delete = $this->query($sql);

			$sql = "DELETE FROM ".PREFIX."barcode WHERE id_group = '".$id_group."'";
			$result_delete = $this->query($sql);
			$result = array(
				'result' => 'success'
			);
			return $result;
		}
		public function getListBarcode($data = array()){
			$result = array();
			$date = $data['date'];

			$sql = "SELECT *,".PREFIX."barcode.date_added AS date_added 
			FROM ".PREFIX."barcode 
			LEFT JOIN ".PREFIX."user ON ".PREFIX."barcode.id_user = ".PREFIX."user.id_user
			WHERE DATE(".PREFIX."barcode.date_added) = '".$date."'"; 
			$result_group = $this->query($sql);
			$result = $result_group->rows;
			return $result;
		}
		public function getListGroup($data = array()){
			$result = array();
			$date = $data['date'];

			$sql = "SELECT *,".PREFIX."group.date_added AS date_added 
			FROM ".PREFIX."group 
			LEFT JOIN ".PREFIX."user ON ".PREFIX."group.id_user = ".PREFIX."user.id_user
			WHERE DATE(".PREFIX."group.date_added) = '".$date."'"; 
			$result_group = $this->query($sql);
			$result = $result_group->rows;
			return $result;
		}
		public function import_barcode($data=array()){
			$result = array();
			$full_name = $data['full_name'];
			$sql = "LOAD DATA LOCAL INFILE '" . $full_name . "' INTO TABLE ".PREFIX."barcode FIELDS TERMINATED BY ',' 
			LINES TERMINATED BY '\n' IGNORE 1 ROWS ( id_user,barcode_prefix,barcode_code,date_added,date_modify);";
			$this->query($sql);
			$date_now = date('Y-m-d H:i:s');
			$sql_update_date = "UPDATE ".PREFIX."barcode SET 
			date_added = '".$date_now."',
			date_modify = '".$date_now."' 
			 WHERE date_added = '0000-00-00 00:00:00'";
			$this->query($sql_update_date);
			$result = array(
				'result' => 'success'
			);
			return $result;
		}
		public function import_range_barcode($data=array()){
			$result = array();
			$full_name = $data['full_name'];
			$date = $data['date'];

			$sql = "LOAD DATA LOCAL INFILE '" . $full_name . "' INTO TABLE ".PREFIX."group FIELDS TERMINATED BY ',' 
			LINES TERMINATED BY '\n' IGNORE 1 ROWS ( id_user,group_code,start,end,remaining_qty);";
			$this->query($sql);
			$date_now = date('Y-m-d H:i:s');
			$sql_update_date = "UPDATE ".PREFIX."group SET 
			date_wk = '".$date."',
			date_added = '".$date."',
			date_modify = '".$date."' 
			 WHERE date_added = '0000-00-00 00:00:00' OR date_added IS NULL";
			$this->query($sql_update_date);
			$result = array(
				'result' => 'success'
			);
			return $result;
		}
		public function updateGroupCreateBarcode($data=array()){
			$result = array();
			$data_insert_barcode = array();
			foreach($data['qty'] as $group_code => $val){
				$start = 0;
				$end = 0;
				$qty = $val;
				$id_user = $data['id_user'];
				// $group_code = $data['group_code'];
				$date_now = date('Y-m-d H:i:s');
				$id_group = 0;
				$result_get_start_end = $this->query("SELECT * FROM ".PREFIX."group WHERE group_code = '".$group_code."'");
				if($result_get_start_end->num_rows>0){
					$start 	= $result_get_start_end->row['start'];
					$end 	= $result_get_start_end->row['end'];
					$id_group = $result_get_start_end->row['id_group'];
				}
				$start 	= $start+$qty;
				$end 	= 0;//$end+($qty+$qty);

				$data_update_group_code = array(
					'remaining_qty' => 	$val,
					'start'			=> 	$start,
					'end'			=>	$end
				);
				$result_update = $this->update('group',$data_update_group_code,"group_code = '".$group_code."'");
				for($i=$start;$i<=$end;$i++){
					$data_insert_barcode[] = array(
						'id_user' => $id_user,
						'id_group'=> $id_group,
						'barcode_prefix' => $group_code,
						'barcode_code'	=> $i,
						'barcode_status' => 0,
						'barcode_flag'	=>	0,
						'date_added' => $date_now,
						'date_modify' => $date_now
					);
					// $result_insert_barcode = $this->insert('barcode',$data_insert_barcode);
				}
			}
			$path_file = DOCUMENT_ROOT.'uploads/import_barcode_csv/';
			$file_name = date('YmdHis').'.csv';
			$full_name = $path_file.$file_name;

			$fp = fopen($full_name, 'w');
			foreach ($data_insert_barcode as $fields) {
			    fputcsv($fp, $fields);
			}
			fclose($fp);

			$sql = "LOAD DATA LOCAL INFILE '" . $full_name . "' INTO TABLE ".PREFIX."barcode FIELDS TERMINATED BY ',' 
			LINES TERMINATED BY '\n'  ( id_user,id_group,barcode_prefix,barcode_code,barcode_status,barcode_flag,date_added,date_modify);";
			$this->query($sql);
			$date_now = date('Y-m-d H:i:s');
			$sql_update_date = "UPDATE ".PREFIX."barcode SET date_added = '".$date_now."', date_modify = '".$date_now."' WHERE date_added = '0000-00-00 00:00:00'";
			$this->query($sql_update_date);
			$result = array(
				'result' => 'success'
			);
			return $result;
		}
		public function updateDefaultGroup($data = array()){
			$result = array();
			$type = $data['type'];
			if($type=="default_start"){
				$sql = "UPDATE ".PREFIX."group SET ".$data['type']." = '".$data['value']."' 
				WHERE id_group='".$data['id_group']."'";
				$result_update_group = $this->query($sql);

			}
			if($type=="default_end"){
				$sql = "UPDATE ".PREFIX."group SET ".$data['type']." = '".$data['value']."' 
				WHERE id_group='".$data['id_group']."'";
				$result_update_group = $this->query($sql);

			}
			if($type=="default_range"){
				$sql = "UPDATE ".PREFIX."group SET ".$data['type']." = '".$data['value']."' 
				WHERE id_group='".$data['id_group']."'";
				$result_update_group = $this->query($sql);

			}
			return $result;
		}
		public function getgroup($data = array()){
			$result = array();
			$sql = "SELECT * FROM ".PREFIX."group ";
			$result_group = $this->query($sql);
			$result = $result_group->rows;
			// $result = array(
			// 	'start_group' 	=> $result_group->row['group_code'],
			// 	'end_group' 	=> $result_group->row['end_group']
			// );
			return $result;
		}
		public function updateWkMapping( $data = array() ){
			$result = array();
			$group = $data['group'];
			$id_user = $data['id_user'];
			$date_wk = $data['date_wk'];
			$size = $data['size'];

			$id_group = 0;

			$sql_check_have_group = "SELECT * FROM ".PREFIX."group WHERE group_code = '".$group."'";
			$result_query_check_have_group = $this->query($sql_check_have_group);
			$data_now = date('Y-m-d H:i:s');
			// if not have group
			if($result_query_check_have_group->num_rows == 0 ){
				$data_insert = array(
					'group_code' 	=> $group,
					'id_user'		=> $id_user,
					'date_wk'		=> $date_wk,
					'date_added'	=> $data_now,
					'barcode_use'	=> 0,
					'start'			=> 0,
					'end'			=> 0,
					'default_start'	=> 0,
					'default_end'	=> 0,
					'default_range'	=> 0,
					'remaining_qty' => 0
				);
				$id_group = $this->insert('group',$data_insert);
			}else{
				$id_group = $result_query_check_have_group->row['id_group'];
			}
			$data_update_product = array(
				'id_group' => $id_group
			);
			$update_size = $this->update('product',$data_update_product,"size_product_code = '".$size."'");
			$data_update_group = array(
				'date_modify' => $data_now
			);
			$update_size = $this->update('group',$data_update_group,"id_group='".$id_group."'");
			$result = array(
				'result' => 'success'
			);
			return $result;
		}
		public function listDateWK( $data = array() ){
			$result = array();
			$sql = "SELECT *,DATE(date_wk) AS date_wk  FROM ".PREFIX."product GROUP BY DATE(date_wk)";
			$result_query = $this->query($sql);
			$result = $result_query->rows;
			return $result;
		}
		public function listPrefixBarcode( $data = array() ){
			$result = array();
			$date = $data['date'];
			$where = '';
			if(!empty($date)){
				$where = " WHERE DATE(".PREFIX."product.date_wk) = '".$date."' ";
			}
			$sql = "SELECT *  FROM ".PREFIX."product 
			LEFT JOIN ".PREFIX."group ON ".PREFIX."product.id_group = ".PREFIX."group.id_group 
			".$where." ORDER BY ".PREFIX."product.size_product_code ASC";
			$result_query = $this->query($sql);
			$result = $result_query->rows;
			return $result;
		}
		public function getMapping($data = array()){
			$result = array();
			$start_group = $data['start_group'];
			$end_group = $data['end_group'];

			$sql = "SELECT * FROM mb_master_group WHERE group_code BETWEEN '".$start_group."' AND '".$end_group."'";
			// echo $sql;
			// exit();
			$result_query = $this->query($sql);
			$result = $result_query->rows;
			// foreach($result_query->rows as $val){
			// 	$result[$val['size']] = $val['group_code'];
			// }
			return $result;
		}
		public function getBarcode($data = array()){
			$result = array();
			$date = $data['date'];
			$sql = "SELECT *,mb_master_barcode.date_added AS date_added FROM mb_master_barcode 
			LEFT JOIN mb_master_user ON mb_master_barcode.id_user = mb_master_user.id_user 
			WHERE DATE(mb_master_barcode.date_added) = '".$date."' limit 0,10";
			$result_query = $this->query($sql);
			return $result_query->rows;
		}
		public function getNumsBarcode($data = array()){
			$result = array();
			$date = $data['date'];
			$sql = "SELECT *,mb_master_barcode.date_added AS date_added FROM mb_master_barcode 
			LEFT JOIN mb_master_user ON mb_master_barcode.id_user = mb_master_user.id_user 
			WHERE DATE(mb_master_barcode.date_added) = '".$date."'";
			$result_query = $this->query($sql);
			return $result_query->num_rows;
		}
		public function getExcelBarcode($data = array()){
			$result = array();
			$date = $data['date'];
			$sql = "SELECT barcode_prefix,barcode_code,mb_master_barcode.date_added AS date_added,username FROM mb_master_barcode 
			LEFT JOIN mb_master_user ON mb_master_barcode.id_user = mb_master_user.id_user 
			WHERE DATE(mb_master_barcode.date_added) = '".$date."'";
			$result_query = $this->query($sql);
			$header = array(
				'Prefix',
				'Barcode',
				'Date added',
				'Create by'
			);
			$result[] = $header;
			foreach($result_query->rows as $val){
				// $result[] = $val;
				$temp = array();
				foreach($val as $v){
					$temp[] = $v; 
				}
				$result[] = $temp;
			}
			return $result;
		}
		public function getExcelListGroup($data = array()){
			$result = array();
			$date = $data['date'];

			$sql = "SELECT ".PREFIX."group.group_code,".PREFIX."group.start,".PREFIX."group.end,".PREFIX."group.remaining_qty 
			FROM ".PREFIX."group 
			LEFT JOIN ".PREFIX."user ON ".PREFIX."group.id_user = ".PREFIX."user.id_user
			WHERE DATE(".PREFIX."group.date_added) = '".$date."'"; 
			$result_query = $this->query($sql);
			$header = array(
				'Prefix',
				'Barcode',
				'Date added',
				'Create by'
			);
			$result[] = $header;
			foreach($result_query->rows as $val){
				// $result[] = $val;
				$temp = array();
				foreach($val as $v){
					$temp[] = $v; 
				}
				$result[] = $temp;
			}
			return $result;
		}
	}
?>