<?php 
	class SettingController extends Controller {
	    public function index() {
	    	$data = array();
	    	$data['title'] = "Setting";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;

 	    	$this->view('setting/home',$data);
	    }
	}
?>