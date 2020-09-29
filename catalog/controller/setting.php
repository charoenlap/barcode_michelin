<?php 
	class SettingController extends Controller {
	    public function index() {
	    	$data = array();
	    	$data['title'] = "Setting";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;

	    	$data['date_wk'] = get('date_wk');
	    	$barcode = $this->model('barcode');
	    	$data['listDateWK'] = $barcode->listDateWK();
	    	$data_select_date_wk = array(
	    		'date' => ''
	    	);
	    	$data['listPrefixBarcode'] = $barcode->listPrefixBarcode($data_select_date_wk);

 	    	$this->view('setting/home',$data);
	    }
	}
?>