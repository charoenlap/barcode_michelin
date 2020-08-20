<?php 
	class PurchaseController extends Controller {
	    public function index() {
	    	$data = array();
	    	$data['title'] = "List Purchase";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;

 	    	$this->view('purchase/list',$data);
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