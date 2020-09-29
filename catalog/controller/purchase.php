<?php 
	class PurchaseController extends Controller {
		
	    public function index() {
	    	$data = array();
	    	$barcode = $this->model('barcode');
	    	$data['start_group'] = get('start_group');
	    	$data['end_group'] = get('end_group');
	    	if(method_post()){
	    		$id_user = getSession('id_user');
	    		$qty = post('qty');
	    		$data_post = array(
	    			'qty' => $qty,
	    			'id_user' => $id_user,
	    		);
	    		$barcode->updateGroupCreateBarcode($data_post);
	    		$data['start_group'] 	= post('start_group');
	    		$data['end_group'] 		= post('end_group');
	    		$this->redirect('purchase&start_group='.$data['start_group'].'&end_group='.$data['end_group'].'&result=success');
	    	}
	    	$data['result'] = get('result');
	    	$data['title'] = "List Purchase";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;
	    	$data['date_wk'] = date('Y-m-d');
	    	$data_select_date_wk = array(
	    		'date' => $data['date_wk']
	    	);
	    	$data['listPrefixBarcode'] = $barcode->listPrefixBarcode($data_select_date_wk);

	    	$data_select = array(
	    		'start_group'	=> $data['start_group'],
				'end_group'		=> $data['end_group']
	    	);

	    	$data['getMapping'] = $barcode->getMapping($data_select);
	    	$data['date_first_3_year'] = date('Y-m-d', strtotime('-3 years'));
	    	$data['date_lasted_order'] = date('Y-m-d');

	    	$data['result_group'] = $barcode->getgroup();
	    	$data['action'] = route('purchase');
	    	$data['action_import_excel'] = route('listGroup');
	    	$data['date'] = (get('date')?get('date'):'');


	    	// $data['start_group'] = $result_group['start_group'];
	    	// $data['end_group'] = $result_group['end_group'];
	    	// var_dump($result_group);exit();
	    	// var_dump($data['listPrefixBarcode']);
 	    	$this->view('purchase/list',$data);
	    }
	    public function updateDefaultGroup(){
			$data = array();
			$barcode = $this->model('barcode');
			$value = get('value');
			$id_group = get('id_group');
			$type = get('type');
			$data_select = array(
				'value' => $value,
				'id_group' => $id_group,
				'type' => $type
			);
			$result = $barcode->updateDefaultGroup($data_select);
			$this->json($result);
		}
	    public function add() {
	    	$data = array();
	    	$this->view('purchase/form',$data);
	    }
	    public function edit() {
	    	$data = array();
	    	$this->view('purchase/form',$data);
	    }
	    public function delete() {
	    	$data = array();
	    	$this->view('purchase/form',$data);
	    }

	}
?>