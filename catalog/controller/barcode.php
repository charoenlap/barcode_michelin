<?php 
	require_once DOCUMENT_ROOT.'/system/lib/simplexlsx-master/src/SimpleXLSX.php';
	class BarcodeController extends Controller {
	    public function index() {
	    	$data = array();
	    	if(method_post()){
	    		$file = $_FILES['file_import'];
	    		$path = 'uploads/import_group_barcode_xlsx/';
	    		$path_csv = 'uploads/convert_xlsx_barcode_csv/';
	    		$file_name = date('YmdHis');
	    		$name = $file_name.'_'.$file['name'];
	    		$full_path = $path.$name;
	    		$result_upload = upload($file,$path,$name);
	    		$id_user = $this->getSession('id_user');
	    		$date = (post('date')?post('date'):date('Y-m-d'));
	    		if($result_upload){
		    		// read xlsx
		    		if ( $xlsx = SimpleXLSX::parse($full_path) ) {
						$result_xlsx = $xlsx->rows();
						$result = $result_xlsx;
						// convert to csv file 
						$csv_file = $path_csv.$file_name.'.csv';
						$fp = fopen($csv_file, 'w');
						// $i=0;
						foreach ($result_xlsx as $fields) {
							$temp_array = array();
							$temp_array[0] = $id_user;   // id_user
							$temp_array[1] = $fields[0]; // barcode_prefix
							$temp_array[2] = $fields[1]; // barcode_code

							// remove last value date of array
							$data_now = date('Y-m-d H:i:s');
							// add column barcode use
							$temp_array[3] = 0; // barcode_status
							// convert format date 
							$date = date_f($date,'Y-m-d H:i:s');
							$temp_array[4] = 0; // barcode_flag
							// add date_added 
							$temp_array[5] = $data_now; // date_added
							// add date_modify
							$temp_array[6] = $data_now; // date_modify
							fputcsv($fp, $temp_array,',',chr(0));
						}
						fclose($fp);
						// import CSV to database 

						$barcode = $this->model('barcode');
						$data_barcode = array(
							'full_name' => $csv_file
						);
						$result_import_barcode_csv = $barcode->import_barcode($data_barcode);
						// $result = array(
						// 	'empty_date' 	=> $count_empty_date,
						// 	'fail'			=> $count_empty_date,
						// 	'success'		=> $count_success,
						// 	'total'			=> $count_empty_date+$count_success
						// );
					} else {
						$this->json(SimpleXLSX::parseError());
					}
		    	}
	    		$this->json($data);
	    		exit();
	    	}else{
		    	$data['title'] = "List Barcode";
		    	$style = array(
		    		'assets/home.css'
		    	);
		    	$data['style'] 	= $style;
		    	$data['date'] = (get('date')?get('date'):'');
		    	$data_select = array(
		    		'date' => $data['date']
		    	);
		    	$barcode = $this->model('barcode');
		    	$data['getBarcode'] = $barcode->getBarcode($data_select);
		    	$data['nums_row']	= $barcode->getNumsBarcode($data_select);
		    	$data['action'] = route('barcode/listGroup');
		    	$data['export_excel'] = route('barcode/export_excel&date='.$data['date']);
		    	// $data['import_excel'] = 
		    	$data['action_import_excel'] = route('barcode');

	 	    	$this->view('barcode/list',$data);
	 	    }
	    }
	    public function add_row_barcode(){
	    	$data = array();
	    	if(method_get()){
	    		$data['date_wk'] = get('date_wk');
		    	$barcode = $this->model('barcode');
		    	$array_insert = array(
					'size_product_code' => get('add_size'),
					'sum_product' => get('add_sum_prod'),
					'date_wk'	=> get('date_wk')
				);
		    	$data['listDateWK'] = $barcode->addRowBarcode($array_insert);
	    	}
	    	$this->json($data);
	    }
	    public function association() {
	    	$data = array();
	    	$data['date_wk'] = get('date_wk');
	    	$barcode = $this->model('barcode');
	    	$data['listDateWK'] = $barcode->listDateWK();
	    	$data_select_date_wk = array(
	    		'date' => $data['date_wk']
	    	);
	    	$data['listPrefixBarcode'] = $barcode->listPrefixBarcode($data_select_date_wk);
	    	$data['export_excel'] = route('barcode/export_excel_association&date_wk='.$data['date_wk']);
	    	// $data['getMapping'] = $barcode->getMapping();

	    	$this->view('barcode/association',$data);
	    }
	    public function export_excel_association(){
	    	$data['date_wk'] = (get('date_wk')?get('date_wk'):'');
	    	$barcode = $this->model('barcode');
	    	$data_select_date_wk = array(
	    		'date' => $data['date_wk']
	    	);
	    	$data['listPrefixBarcode'] = $barcode->listPrefixBarcode($data_select_date_wk);
	    	$temp = array();
	    	foreach($data['listPrefixBarcode'] as $val){
	    		$temp[] = array(
	    			$val['size_product_code'],
	    			$val['sum_product'],
	    			$val['group_code'],
	    			$val['remaining_qty'],
	    		);
	    	}

	    	$filename = "xls";
		    // $temp = $data['getBarcode'];
		    //header info for browser
		    header("Content-Type: application/xls");    
		    header("Content-Disposition: attachment; filename=$filename.xls");  
		    header("Pragma: no-cache"); 
		    header("Expires: 0");
		    /*******Start of Formatting for Excel*******/   
		    //define separator (defines columns in excel & tabs in word)
		    $sep = "\t"; //tabbed character
		    //start of printing column names as names of MySQL fields
		    // for ($i = 0; $i < mysql_num_fields($result); $i++) {
		    // echo mysql_field_name($result,$i) . "\t";
		    // }
		    print("\n");    
		    //end of printing column names  
		    //start while loop to get data
		    foreach( $temp as $row ){
		        $schema_insert = "";
		        for($j=0; $j<count($row);$j++){
		            if(!isset($row[$j])){
		                $schema_insert .= "NULL".$sep;
		            }
		            else if($row[$j] != ""){
		                $schema_insert .= "$row[$j]".$sep;
		            }
		            else{
		                $schema_insert .= "".$sep;
		            }
		        }
		        $schema_insert = str_replace($sep."$", "", $schema_insert);
		        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		        $schema_insert .= "\t";
		        print(trim($schema_insert));
		        print "\n";
		    }
	    }
	    public function export_excel(){
	    	$data['date'] = (get('date')?get('date'):'');
	    	$data_select = array(
	    		'date' => $data['date']
	    	);
	    	$barcode = $this->model('barcode');
	    	$data['getBarcode'] = $barcode->getExcelBarcode($data_select);

	    	$filename = "xls";
		    $temp = $data['getBarcode'];
		    //header info for browser
		    header("Content-Type: application/xls");    
		    header("Content-Disposition: attachment; filename=$filename.xls");  
		    header("Pragma: no-cache"); 
		    header("Expires: 0");
		    $sep = "\t";
		    print("\n");
		    foreach( $temp as $row ){
		        $schema_insert = "";
		        for($j=0; $j<count($row);$j++){
		            if(!isset($row[$j])){
		                $schema_insert .= "NULL".$sep;
		            }
		            else if($row[$j] != ""){
		                $schema_insert .= "$row[$j]".$sep;
		            }
		            else{
		                $schema_insert .= "".$sep;
		            }
		        }
		        $schema_insert = str_replace($sep."$", "", $schema_insert);
		        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		        $schema_insert .= "\t";
		        print(trim($schema_insert));
		        print "\n";
		    }
	    }
	    public function updateWkMapping(){
			$data = array();
			$data['date_wk'] = get('date_wk');
			$data['group'] = get('group');
			$data['size'] = get('size');

			$data['id_user'] = $this->getSession('id_user');
			$barcode = $this->model('barcode');
			$data_selct = array(
				'date_wk' => $data['date_wk'],
				'group' => $data['group'],
				'size' => $data['size'],
				'id_user' => $data['id_user']
			);
			$updateWkMapping = $barcode->updateWkMapping($data_selct);
			$this->json($data);
		}
	    public function deleteGroup(){
	    	$data = array();
	    	$barcode = $this->model('barcode');
	    	if(method_post()){
		    	$select = array(
		    		'id_group' => post('id_group')
		    	);
		    	$data['list_group'] = $barcode->deleteGroup($select);
		    }
	    	$this->json($data);
	    }
	    public function add() {
	    	$data = array();
	    	$this->view('barcode/form',$data);
	    }
	    public function edit() {
	    	$data = array();
	    	$this->view('barcode/form',$data);
	    }
	    public function delete() {
	    	$data = array();
	    	$this->view('barcode/form',$data);
	    }
	    public function export_excel_group(){
	    	$data['date'] = (get('date')?get('date'):'');
	    	$data_select = array(
	    		'date' => $data['date']
	    	);
	    	$barcode = $this->model('barcode');
	    	$data['getBarcode'] = $barcode->getExcelBarcode($data_select);

	    	$filename = "xls";
		    $temp = $data['getBarcode'];
		    //header info for browser
		    header("Content-Type: application/xls");    
		    header("Content-Disposition: attachment; filename=$filename.xls");  
		    header("Pragma: no-cache"); 
		    header("Expires: 0");
		    /*******Start of Formatting for Excel*******/   
		    //define separator (defines columns in excel & tabs in word)
		    $sep = "\t"; //tabbed character
		    //start of printing column names as names of MySQL fields
		    // for ($i = 0; $i < mysql_num_fields($result); $i++) {
		    // echo mysql_field_name($result,$i) . "\t";
		    // }
		    print("\n");    
		    //end of printing column names  
		    //start while loop to get data
		    foreach( $temp as $row ){
		        $schema_insert = "";
		        for($j=0; $j<count($row);$j++){
		            if(!isset($row[$j])){
		                $schema_insert .= "NULL".$sep;
		            }
		            else if($row[$j] != ""){
		                $schema_insert .= "$row[$j]".$sep;
		            }
		            else{
		                $schema_insert .= "".$sep;
		            }
		        }
		        $schema_insert = str_replace($sep."$", "", $schema_insert);
		        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		        $schema_insert .= "\t";
		        print(trim($schema_insert));
		        print "\n";
		    }
	    }
	    public function export_excel_range_barcode(){
	    	// $data['date'] = (get('date')?get('date'):'');
	    	// $data_select = array(
	    	// 	'date' => $data['date']
	    	// );
	    	// $barcode = $this->model('barcode');
	    	// $data['getBarcode'] = $barcode->getExcelListGroup($data_select);

	    	$filename = "xls";
		    // $temp = $data['getBarcode'];

	    	$barcode = $this->model('barcode');
	    	// $path = 'catalog/view/theme/pdf/PPDOrder';

	    	$data['start_group'] = get('start_group');
	    	$data['end_group'] = get('end_group');

	    	$data_select = array(
	    		'start_group'	=> $data['start_group'],
				'end_group'		=> $data['end_group']
	    	);

	    	$resultMapping = $barcode->getMapping($data_select);
	    	$html_data = array();
	    	$html_data[] = array(
	    		'No.',
	    		'Start',
				'End',
				'Count.',
	    	);
	    	foreach($resultMapping as $val){
	    		$html_data[] = array(
	    			$val['group_code'],
	    			sprintf('%06d', $val['start']),
	    			sprintf('%06d', $val['end']),
	    			$val['remaining_qty']
	    		);
	    	}
	   //  	$html_data[] = array(
	   //  		'No.',
	   //  		'Start',
				// 'End',
				// 'Count.',
	   //  	);
	    	// $style = "width: 180px;";
	    	// $temp_array_data = data_to_row_html($html_data,$style);


		    //header info for browser
		    header("Content-Type: application/xls");    
		    header("Content-Disposition: attachment; filename=$filename.xls");  
		    header("Pragma: no-cache"); 
		    header("Expires: 0");
		    /*******Start of Formatting for Excel*******/   
		    //define separator (defines columns in excel & tabs in word)
		    $sep = "\t"; //tabbed character
		    //start of printing column names as names of MySQL fields
		    // for ($i = 0; $i < mysql_num_fields($result); $i++) {
		    // echo mysql_field_name($result,$i) . "\t";
		    // }
		    print("\n");    
		    //end of printing column names  
		    //start while loop to get data
		    foreach( $html_data as $row ){
		        $schema_insert = "";
		        for($j=0; $j<count($row);$j++){
		            if(!isset($row[$j])){
		                $schema_insert .= "NULL".$sep;
		            }
		            else if($row[$j] != ""){
		                $schema_insert .= "$row[$j]".$sep;
		            }
		            else{
		                $schema_insert .= "".$sep;
		            }
		        }
		        $schema_insert = str_replace($sep."$", "", $schema_insert);
		        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		        $schema_insert .= "\t";
		        print(trim($schema_insert));
		        print "\n";
		    }
	    }
	    public function listGroup() {
	    	$data = array();
	    	if(method_post()){
	    		$file = $_FILES['file_import'];
	    		$path = 'uploads/import_range_barcode_xlsx/';
	    		$path_csv = 'uploads/convert_xlsx_range_barcode_csv/';
	    		$file_name = date('YmdHis');
	    		$name = $file_name.'_'.$file['name'];
	    		$full_path = $path.$name;
	    		$result_upload = upload($file,$path,$name);
	    		$id_user = $this->getSession('id_user');
	    		$date = (post('date')?post('date'):date('Y-m-d'));
	    		if($result_upload){
		    		// read xlsx
		    		if ( $xlsx = SimpleXLSX::parse($full_path) ) {
						$result_xlsx = $xlsx->rows();
						$result = $result_xlsx;
						// convert to csv file 
						$csv_file = $path_csv.$file_name.'.csv';
						$fp = fopen($csv_file, 'w');
						// $i=0;
						foreach ($result_xlsx as $fields) {
							$temp_array = array();
							$temp_array[0] = $id_user;   // id_user
							$temp_array[1] = $fields[0]; // group_code
							$temp_array[2] = $fields[1]; // start
							$temp_array[3] = $fields[2]; // end
							$temp_array[4] = $fields[3]; // remaining_qty

							// remove last value date of array
							$data_now = date('Y-m-d H:i:s');
							// convert format date 
							$date = date_f($date,'Y-m-d H:i:s');
							// add date_added 
							$temp_array[5] = $data_now; // date_added
							// add date_modify
							$temp_array[6] = $data_now; // date_modify
							fputcsv($fp, $temp_array,',',chr(0));
						}
						fclose($fp);
						// import CSV to database 

						$barcode = $this->model('barcode');
						$data_barcode = array(
							'full_name' => $csv_file,
							'date'	=> $date
						);
						$result_import_barcode_csv = $barcode->import_range_barcode($data_barcode);
						// $result = array(
						// 	'empty_date' 	=> $count_empty_date,
						// 	'fail'			=> $count_empty_date,
						// 	'success'		=> $count_success,
						// 	'total'			=> $count_empty_date+$count_success
						// );
					} else {
						$this->json(SimpleXLSX::parseError());
					}
		    	}
	    		$this->json($data);
	    		exit();
	    	}else{ 
		    	$data['title'] = "List Barcode";
		    	$style = array(
		    		'assets/home.css'
		    	);
		    	$data['style'] 	= $style;
		    	$data['date'] = (get('date')?get('date'):'');
		    	$data_select = array(
		    		'date' => $data['date']
		    	);
		    	$data['action'] = route('barcode/listGroup');
		    	$barcode = $this->model('barcode');
		    	$data['list_group'] = $barcode->getListGroup($data_select);
		    	$data['action_import_excel'] = route('listGroup');
	 	    	$this->view('barcode/listGroup',$data);
	 	    }
	    }
	    public function PPDOrder(){
	    	$barcode = $this->model('barcode');
	    	$path = 'catalog/view/theme/pdf/PPDOrder';

	    	$data['start_group'] = get('start_group');
	    	$data['end_group'] = get('end_group');

	    	$data_select = array(
	    		'start_group'	=> $data['start_group'],
				'end_group'		=> $data['end_group']
	    	);

	    	$resultMapping = $barcode->getMapping($data_select);
	    	$html_data = array();
	    	$html_data[] = array(
	    		'No.',
	    		'Start',
				'End',
				'Count.',
	    	);
	    	foreach($resultMapping as $val){
	    		$html_data[] = array(
	    			$val['group_code'],
	    			sprintf('%06d', $val['start']),
	    			sprintf('%06d', $val['end']),
	    			$val['remaining_qty']
	    		);
	    	}
	    	$html_data[] = array(
	    		'No.',
	    		'Start',
				'End',
				'Count.',
	    	);
	    	$style = "width: 180px;";
	    	$temp_array_data = data_to_row_html($html_data,$style);
	    	$replace = array(
				'{$row_data}' => $temp_array_data
			);
	    	$html = $this->getHtmlFilePDF($path,$replace);

	    	$path_dir = DOCUMENT_ROOT.'uploads/PPDOrder/';
	    	if (!file_exists($path_dir)) {
			    mkdir($path_dir, 0777, true);
			}
			$file_name = 'PPDOrder_'.date('Y_m_d_His');
			$path = DOCUMENT_ROOT.'uploads/PPDOrder/'.$file_name.'.pdf';
	    	$data_pdf = array(
	    		'file_name' => $file_name,
	    		'path' 		=> $path
	    	);
	    	$result_pdf = $this->downloadPdf($html,$data_pdf);
	    	header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename=".$file_name);
			readfile($path);
	    }
	}
?>