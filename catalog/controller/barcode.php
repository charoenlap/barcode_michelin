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
	    public function listGroup() {
	    	$data = array();
	    	$data['title'] = "List Barcode";
	    	$style = array(
	    		'assets/home.css'
	    	);
	    	$data['style'] 	= $style;

 	    	$this->view('barcode/listGroup',$data);
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
	    public function association() {
	    	$data = array();
	    	$this->view('barcode/association',$data);
	    }
	    public function PPDOrder(){
	    	$path = 'catalog/view/theme/pdf/PPDOrder';
	    	$replace = array(
				'{$text_sum_tax}'					=> '-',
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