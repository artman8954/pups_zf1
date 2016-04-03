<?php

/** 
 * Controller class for default index page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 28th Aug 2013 
 */

class ClientController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		$auth		= Zend_Auth::getInstance(); 
		//check whether already logged in 
	    if(!$auth->hasIdentity()){
	      $this->_redirect('/index/index/invalid/sess');
	    }

    }

/** 
 * Function for index action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */
    public function indexAction()
    {
    	$page_sizes = array(10, 25, 50, 100, 'all');	
	    $page=$this->getParam('page',1);
	    $page_size = $this->getParam('page_size', 10);
		$search_key = $this->getParam('search_text');
		$column_name = $this->getParam('search_field');
		
		$project_id = $this->getParam('id');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name
			,  'page_size' => $page_size);
		
		if($project_id > 0){
			//create new object of project model
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject->getProjectDetails($project_id); 
			$projectName = $projectDetails[$project_id]['project_name'];
		}else{
			$projectName = 'All Projects';
		}
		
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> getClients($project_id,$search_key, $column_name, $page); 
		$result->setItemCountPerPage($page_size == 'all' ? 10000 : $page_size);
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('page_sizes',$page_sizes); 
		$this->view->assign('project_name',$projectName); 
		$this->view->assign('project_id',$project_id); 
		
		
    }

/** 
 * Function for index action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */
    public function primeAction()
    {
    	$page_sizes = array(10, 25, 50, 100, 'all');	
	    $page=$this->getParam('page',1);
	    $page_size = $this->getParam('page_size', 10);
		$search_key = $this->getParam('search_text');
		$column_name = $this->getParam('search_field');
		
		$project_id = $this->getParam('id');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name
			,  'page_size' => $page_size);
		
		if($project_id > 0){
			//create new object of project model
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject->getProjectDetails($project_id); 
			$projectName = $projectDetails[$project_id]['project_name'];
		}else{
			$projectName = 'All Projects';
		}
		
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> getPrimes($project_id,$search_key, $column_name, $page); 

		$result->setItemCountPerPage($page_size == 'all' ? 10000 : $page_size);
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('page_sizes',$page_sizes); 
		$this->view->assign('project_name',$projectName); 
		$this->view->assign('project_id',$project_id); 
    }    

/** 
 * Function for index action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */
    public function acesAction()
    {
    	$page_sizes = array(10, 25, 50, 100, 'all');	
	    $page=$this->getParam('page',1);
	    $page_size = $this->getParam('page_size', 10);
		$search_key = $this->getParam('search_text');
		$column_name = $this->getParam('search_field');
		
		$project_id = $this->getParam('id');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name
			,  'page_size' => $page_size);
		
		if($project_id > 0){
			//create new object of project model
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject->getProjectDetails($project_id); 
			$projectName = $projectDetails[$project_id]['project_name'];
		}else{
			$projectName = 'All Projects';
		}
		
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> getAces($project_id,$search_key, $column_name, $page); 

		$result->setItemCountPerPage($page_size == 'all' ? 10000 : $page_size);
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('page_sizes',$page_sizes); 
		$this->view->assign('project_name',$projectName); 
		$this->view->assign('project_id',$project_id); 
    }       


/** 
 * Function for new client import. 
 * @param None
 * @return None
 */
    public function newclientAction()
    {
			$request  = $this->getRequest();
			$id = $request->getParam('id'); 
			$prid = $request->getParam('prid'); 

			$exist_status = $request->getParam('e'); 
			

			$projectModelObject = new Application_Model_ProjectModel(); 
			$projects = $projectModelObject -> getProjects('','','',true); 

			$clientModelObject = new Application_Model_ClientModel(); 
		
			if($id > 0){
				$clientInfo = $clientModelObject -> getClientDetail($id); 
			}
			
			
			if($clientInfo[$id]['project_id'] > 0 ){
				$projectid = $clientInfo[$id]['project_id'];
			}else{
				$projectid = $prid;				
			}
			
			
			if($projectid > 0 ){
				$projectDetails = $projectModelObject->getProjectDetails($projectid); 
				$projectName = $projectDetails[$projectid]['project_name'];
			}
			
			$this->view->assign('project_name',$projectName); 
  		    $this->view->assign('projects',$projects); 
	        $this->view->assign('clientinfo',$clientInfo); 
			
			$this->view->assign('proj_client_id',$id); 
			
			$this->view->assign('prid',$prid); 
			
			
			if($exist_status == 's'){
			 	$this->view->assign('message',"Client with id " .$clientInfo[$id]['client_id'] ." is already existing ! "); 
			}

			
    }
	
	/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function saveAction() {
	
		//create new object of project model
		$clientModelObject = new Application_Model_ClientModel(); 
	
		$request 		= $this->getRequest();
		$client_id = $request->getParam('txtClientId');
		
		$data = array(
						'project_id' => $request->getParam('ddClient'),
				  	 	'client_name' => $request->getParam('txtClientName'),
			  	     	'client_id' => $request->getParam('txtClientId'),
						'client_id_group' => $request->getParam('txtClientIdGroup'),
						'status' => $request->getParam('txtStatus'),
						'sales_rep_id' => $request->getParam('txtSalesRepId'),
						'list_amount' => $request->getParam('txtListAmount'),
						'paid_amount' => $request->getParam('txtPaidAmount')				 
					);

		$projectId = $request->getParam('ddClient');
		
		$client = $clientModelObject -> checkExistingClientId($client_id, $projectId);
		
		$project_client_id = $client[0];
		
		if($project_client_id > 0){
			$this->_redirect('/client/newclient/id/' . $project_client_id.'/e/s');
		}

		$client = $clientModelObject -> getProjectClientId($client_id);  
		$project_client_id = $client[0];
		
		$client_id = $clientModelObject -> saveClient($project_client_id, $data); 
		
		$proj_client_id = $client_id['id'];
		
		$this->_redirect('/client/newclient/id/' . $proj_client_id );
		
    }


/** 
 * Function for new client import. 
 * @param None
 * @return None
 */
    public function importclientAction()   {

		$request 	= $this->getRequest();
		$projectId 	= $request->getParam('id');
		
			$projectModelObject = new Application_Model_ProjectModel(); 
		
			if($projectId > 0){
				$projectDetails = $projectModelObject -> getProjectDetails($projectId); 
				$this->view->assign('projectDetail',$projectDetails); 
			} 
		
			$projects = $projectModelObject -> getProjects('','','',true); 
  		    $this->view->assign('projectId',$projectId); 
  		    $this->view->assign('projects',$projects); 
			
			$status = $this->getRequest()->getParam('s');
			
			if($status == 'fail'){
				$message =  "File upload failed , please upload a valid csv file. " ; 
				$this->view->assign('message',$message); 
			}


    }// End of function 
	
/** 
 * Function for login action. 
 * @param None
 * @return None
 */
 
	public function mapcsvAction(){
			
		$projectId 	= $this->getRequest()->getParam('ddClient');
		
		$projectModelObject = new Application_Model_ProjectModel(); 
		$projectDetail = $projectModelObject->getProjectDetails($projectId);
		

		//Uploading files 
		if ($this->getRequest()->isPost()) {
	
			$config = new Zend_Config(require APPLICATION_PATH.'/configs/config.php' );
			$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->setDestination($config->csvUploadDir);
			$upload->addValidator('Extension', false, 'csv');
	
				if ($upload->receive()) { 
				
					$uploadedFilename = $upload->getFileName();
					$files = $upload->getFileInfo();
					$fileNameOnly = $files[fileCsvUpload][name]; 
					
					$ns = new Zend_Session_Namespace('FileUpload');
					$ns->filename = $upload->getFileName();
					$ns->filenameonly = $fileNameOnly;
					
					$databaseColumn = array(
										'' => 'Select A Column',
										'client_id' => 'Client Id',
										'client_id_group' => 'Client Id Group',
										'client_name' => 'Client Name',
										'status' => 'Status',
										'sales_rep_id' => 'Sales Rep Id',
										'list_amount' => 'List Amount',
										'paid_amount' => 'Paid Amount',
										'earned_amount' => 'Earned Amount',
										'age' => 'Age',
										'small_balance' => 'Small Balance Amount',
										'medium_balance' => 'Medium Balance Amount',
										'large_balance' => 'Large Balance Amount',
										'legal_fee_amount' => 'Legal Fee Amount',
										'legal_fee_amount_earned_us' => 'Legal Fee Earned Amount US ',
										'legal_fee_amount_earned_client' => 'Legal Fee Amount Earned Client',
										'legal_total_amount_earned' => 'Legal Total Amount Earned',
										'court_cost_fee' => 'Court Cost Fee',
										'attorney_fee' => 'Attorney Fee',
										'collection_fee' => 'Collection Fee',
										'principal_paid' => 'Principal Paid',
										'total_paid' => 'Total Paid',
										'aces_es1' => 'Aces Es1',
										'aces_es2' => 'Aces Es2',
										'aces_es3' => 'Aces Es3',
										'aces_esf' => 'Aces Esf',
										'aces_list_amount' => 'Aces List Amount',
										'aces_paid_amount' => 'Aces Paid Amount',
										'controlled_cost_accounts' => 'Controlled Cost Accounts',
										'average_age_acc' => 'Average Age Of Account'
										);
										
					$file = fopen($ns -> filename,"r");
					$header = fgetcsv($file);
					$firstrow = fgetcsv($file);
					fclose($file);
					
				}else {
					$this->_redirect('/client/importclient/id/' . $projectId . '/s/fail' ) ;
				}
	
			$this->view->assign('dbcolumns',$databaseColumn); 
			$this->view->assign('header',$header); 
			$this->view->assign('firstrow',$firstrow); 
			$this->view->assign('projectId',$projectId); 
			$this->view->assign('projectDetail',$projectDetail); 
	
		} // End of post request checking
	
	} // End of function 

/** 
 * Function for login action. 
 * @param None
 * @return None
 */
    public function importstatusAction() {
			
		$request 	= $this->getRequest();
		$id = $request -> getParam('id');
		$clientModelObject = new Application_Model_ClientModel(); 
		$ns = new Zend_Session_Namespace('FileUpload');
		$ns->filename;
		$file = fopen($ns -> filename,"r");

		$selectedColumns = $request -> getParam('ddSelect') ; 
		
		$currencyValues = array('list_amount','paid_amount','earned_amount',
			'legal_fee_amount', 'legal_fee_amount_earned_us', 'legal_fee_amount_earned_client','legal_total_amount_earned', 
			'court_cost_fee', 'attorney_fee' , 'collection_fee', 'principal_paid', 'total_paid','aces_list_amount', 'aces_paid_amount',
			'small_balance','medium_balance','large_balance',
			'controlled_cost_accounts','controlled_cost_accounts'
		 	);
		
		$integerValues = array('sales_rep_id','age','small_balance','medium_balance','large_balance','aces_es1', 'aces_es2' , 'aces_es3' , 'aces_esf');
		
		$selColArray = array();

		foreach($selectedColumns as $key => $value){
			if(strlen($value) > 0  ){ 
			$selColArray[$key] = $value;
			}
		}

		$created_count 	= 0; 
		$skipped_count 	= 0; 
		$total_count 	= 0; 
		$updated_count 	= 0; 

		$auth	= Zend_Auth::getInstance(); 
		$user   = $auth ->getIdentity();
		$userid  = $user ->user_id;

		$firstrow = fgetcsv($file);
		while(!feof($file)) {
		
			$row = fgetcsv($file);

			$data['project_id'] =  $id;
			$data['created_by'] =  $userid;
			$data['created_datetime'] =  date('Y-m-d H-i-s');
			
			
			foreach($selColArray as $keyhead => $val ){ 
				
				$filterArr = array("$",",");
				
				if( in_array($val, $currencyValues) ){
					$exactValue = round(str_replace($filterArr,"", $row[$keyhead]),2) ; 
				}else if( in_array($val, $integerValues) ) {
					$exactValue = round($row[$keyhead]) ; 
				}else{
					$exactValue = $row[$keyhead]; 
				}
				
				$data[$val]  = $exactValue;
				
			}
			
			$total_count++; 
			
			if($data['client_id'] > 0){
				$result = $clientModelObject -> saveClient('', $data,1); 
				
				if($result['id'] > 0 && $result['status'] == 'new'){
					$created_count++;
				}else if($result['id'] > 0 && $result['status'] == 'update') {
					$updated_count++; 
				}
				
			}else  {
				$skipped_count++; 
			}
			
		}
  
		fclose($file);

		$projectModelObject = new Application_Model_ProjectModel(); 
		$projectDetail = $projectModelObject->getProjectDetails($id);
		
		$sizeinbytes = filesize($ns->filename); 
		$sizeinkb = round( ($sizeinbytes/1024) , 2 ); 
		$docModel = new Application_Model_DocumentModel();
		$docModel -> saveDocument('', $id,"$ns->filenameonly","$sizeinkb"); 
		

		$this->view->assign('created_count',$created_count); 
		$this->view->assign('skipped_count',$skipped_count); 
		$this->view->assign('total_count',$total_count); 
		$this->view->assign('updated_count',$updated_count); 
		$this->view->assign('projectDetail',$projectDetail); 
		$this->view->assign('projectId',$id); 
		


}	// End of function 

/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function clienthomeAction(){
	
		$request  = $this->getRequest();
	    $id = $request->getParam('id'); 
		$status = $request->getParam('s'); 
		
		if($status == 'invalid'){
		    $message = "Please configure the project, before running pups ";
			$this->view->assign('message',$message); 
		}elseif($status == 'success'){
			$run = $request->getParam('run'); 
			$this->view->assign('run',$run); 
		}
		
		$clientModelObject = new Application_Model_ClientModel(); 
		$data = $clientModelObject -> getClientDetail("$id"); 
		
		$clientId = $data[$id]['client_id'];
		
		$pupDetails = $clientModelObject -> getPupCalcDetails($clientId); 
                $pupDetails[$clientId]['avg_age_of_account_p9_3'] = $data[$id]['age'];
                
		$acesDetails = $clientModelObject -> getAcesCalcDetails($clientId); 
                $acesDetails[$clientId]['avg_age_account_a9'] = $data[$id]['age'];
		
		$this->view->assign('pupprimedata',$pupDetails); 
		$this->view->assign('acesdata',$acesDetails); 

		$this->view->assign('data',$data); 
		$this->view->assign('id',$id); 
		$this->view->assign('client_id',$clientId); 
	}
	
/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function runpupAction(){
	
		$request  = $this->getRequest();
	    $proj_clientId = $request->getParam('id'); 
		$clientModelObject = new Application_Model_ClientModel(); 
		
		$status =  $clientModelObject -> runPupProcess("$proj_clientId"); 
		$this->_redirect('/client/clienthome/id/' . $proj_clientId . '/run/prime/s/' . $status ) ;
		
	
	}


	


/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function exportpupprimepdfAction(){
		
		$request  = $this->getRequest();
		
	    $proj_clientId = $request->getParam('id'); 
		
		$clientModelObject = new Application_Model_ClientModel(); 
		
		$fullPath = $clientModelObject->saveClientPrimeReport($proj_clientId); 
	
		if ($fd = fopen ($fullPath, "r")) {
			
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			
			header("Content-type: application/pdf");
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");            
			header("Content-length: $fsize");
			header("Cache-control: private");
			
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
			
		}

		fclose ($fd);
		exit;


 		$this->_redirect('/client/clienthome/id/' . $proj_clientId . '/s/' . $status ) ;

}
	
	
/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function exportpupacespdfAction(){
		
		$request  = $this->getRequest();
		
	    $proj_clientId = $request->getParam('id'); 
		
		$clientModelObject = new Application_Model_ClientModel(); 
		
		$fullPath = $clientModelObject->saveClientAceReport($proj_clientId); 

	
		if ($fd = fopen ($fullPath, "r")) {
			
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			
			header("Content-type: application/pdf");
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");            
			header("Content-length: $fsize");
			header("Cache-control: private");
			
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
			
		}

		fclose ($fd);
		exit;


 $this->_redirect('/client/clienthome/id/' . $proj_clientId . '/s/' . $status ) ;
 

}
	
/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
 /*
    public function exportpdfAction(){

		$request  = $this->getRequest();
	    $proj_clientId = $request->getParam('id'); 
		
		$pdf = new Zend_Pdf();
		
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); 
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA); 
		
		$page->setFont($font,24)
			->drawText("Application testing with zend fw" , 72, 720)
			->drawText("Second line " , 72, 630); 
			
		$pdf->pages[] = $page; 
		
		$pdf->save("public/report/test/example.pdf");			
		
		$pdf->save("public/report/test/example2.pdf");	
		
		$source = "public/report/test";
		
		$filter = new Zend_Filter_Compress(
								array(
										'adapter' => 'Zip',
										'options' => array(
										'archive' => 'public/report/test.zip'
									)
							)
		
					);
					
$result = $filter->filter($source); 
$fullPath = "public/report/test.zip";
					
					

if ($fd = fopen ($fullPath, "r")) {

    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);

    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");            
    header("Content-length: $fsize");
    header("Cache-control: private");

    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}

fclose ($fd);
exit;



		$this->_redirect('/client/clienthome/id/' . $proj_clientId . '/s/' . $status ) ;


	}
	*/
	
	
/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function runacesAction(){
	
		$request  = $this->getRequest();
	    $proj_clientId = $request->getParam('id'); 
		$clientModelObject = new Application_Model_ClientModel(); 
		
		$status =  $clientModelObject -> runAcesProcess("$proj_clientId"); 
		$this->_redirect('/client/clienthome/id/' . $proj_clientId . '/run/ace/s/' . $status ) ;
	
	}
	
/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteAction() {
	
		$request 		= $this->getRequest();
	    $projectClientId = $request->getParam('id'); 
		
		//create new object of project model
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> deleteClient("$projectClientId"); 
		$this->_redirect('/client/index');
    }


/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function saveajaxAction() {
	
		$request 		= $this->getRequest();
	    $projectClientId = $request->getParam('id'); 
		$columnName = $request->getParam('colname'); 
		$data = $request->getParam('data'); 
		
		// makes disable renderer
        $this->_helper->viewRenderer->setNoRender();

        //makes disable layout
        $this->_helper->getHelper('layout')->disableLayout();


		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> saveajax("$projectClientId","$columnName","$data"); 


		echo  $result ; exit; 

    }
	
	/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteajaxAction() {
		// makes disable renderer
        $this->_helper->viewRenderer->setNoRender();
        //makes disable layout
        $this->_helper->getHelper('layout')->disableLayout();
		
		$request 		= $this->getRequest();
	    $projectClientId = $request->getParam('id'); 
		
		//create new object of project model
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> deleteClient("$projectClientId"); 

		echo  $result ; exit; 


    }


} // End of class

