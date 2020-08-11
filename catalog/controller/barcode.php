<?php 
	class BarcodeController extends Controller {
	    public function index() {
	    	$data = array();
	    	$data['title'] = "List Barcode";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;

 	    	$this->view('barcode/list',$data);
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
	}
?>