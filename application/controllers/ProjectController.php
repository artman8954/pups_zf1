<?php

/** 
 * Controller class for Projects
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 3rd Sept 2013 
 */

include('charts/class/FusionCharts_Gen.php');

class ProjectController extends Zend_Controller_Action
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
	    $page=$this->getParam('page',1);
		$search_key = $this->getParam('search_text');
		
		$status = $this->getParam('s'); 
		
		if($status == 'invalid'){
		    $message = "Please configure the project, before running pups prime calculations! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'success'){
		    $message = "Successfully run PUP Prime calculation! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'invalid_ace'){
		    $message = "Please configure the project, before running ace calculation ! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'success_ace'){
		    $message = "Successfully run ace calculation! ";
			$this->view->assign('message',$message); 
		}
	
		$column_name = $this->getParam('search_field');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		$result = $projectModelObject -> getProjects($search_key, $column_name, $page); 
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('page',$page); 
		
    }

/** 
 * Function for new action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */

    public function newAction()
    {
	
		$request 	= $this->getRequest();
		$projectId 	= $request->getParam('id');
		
		if($projectId > 0){
			$projectModelObject = new Application_Model_ProjectModel(); 
			$result = $projectModelObject -> getProjectDetails($projectId); 
  			$this->view->assign('data',$result); 
  		    $this->view->assign('projectId',$projectId); 
		} 	
		
    }

/** 
 * Function for copy action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */

    public function copyAction()
    {
	
		$request 	= $this->getRequest();
		$projectId 	= $request->getParam('id');
		
		if($projectId > 0){
			$projectModelObject = new Application_Model_ProjectModel(); 
			$result = $projectModelObject -> copyProject($projectId); 
  			$this->_redirect('/project');
		} 	
		
    }    
	
	/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function runprimeAction()
    {
	
		$request 		= $this->getRequest();
	    $projectId = $request->getParam('id'); 

		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		$result = $projectModelObject -> runprime("$projectId");
		
		if($result == 'invalid'){
			$this->_redirect('/project/projecthome/id/'.$projectId.'/s/invalid');
		} else {
			$this->_redirect('/project/projecthome/id/'.$projectId.'/s/success');
		}
		
    }

	/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function runaceAction()
    {
	
		$request 		= $this->getRequest();
	    $projectId = $request->getParam('id'); 

		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		
		$result = $projectModelObject->runace("$projectId");
		
		if($result == 'invalid'){
			$this->_redirect('/project/projecthome/id/'.$projectId.'/s/invalid_ace');
		} else {
			$this->_redirect('/project/projecthome/id/'.$projectId.'/s/success_ace');
		}
		
    }


/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function runpdfprimeAction()
    { 
		$request 		= $this->getRequest();
	    $projectId = $request->getParam('id'); 

		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		
		$result = $projectModelObject->runprimepdfreport("$projectId");

		$source = "public/report/project_prime_" . $projectId;
		
		$fullPath = "public/report/project_prime_" . $projectId . ".zip";
		
		if(file_exists($fullPath) ) {
			unlink($fullPath) ; 		
		}

		
		$filter = new Zend_Filter_Compress(
											array(
													'adapter' => 'Zip',
													'options' => array(
													'archive' => "public/report/project_prime_" . $projectId . ".zip"
												)
							)
					);
					
		$result = $filter->filter($source); 
		
		
		
		if ($fd = fopen ($fullPath, "r")) {
			
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			
			header("Content-type: application/zip");
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
		
		
    }

/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function runpdfaceAction()
    {
		$request 		= $this->getRequest();
	    $projectId = $request->getParam('id'); 

		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		
		$result = $projectModelObject->runacepdfreport("$projectId");
		

		$source = "public/report/project_ace_" . $projectId;
		
		$fullPath = "public/report/project_ace_" . $projectId . ".zip";
		
		if(file_exists($fullPath) ) {
			unlink($fullPath) ; 		
		}

		
		$filter = new Zend_Filter_Compress(
											array(
													'adapter' => 'Zip',
													'options' => array(
													'archive' => "public/report/project_ace_" . $projectId . ".zip"
												)
							)
					);
					
		$result = $filter->filter($source); 
		
		if ($fd = fopen ($fullPath, "r")) {
			
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			
			header("Content-type: application/zip");
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
		
		
    }

/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function saveAction()
    {
	
		$request 		= $this->getRequest();
		$projectName 	= $request->getParam('txtProjectName'); 
	    $projectId = $request->getParam('id'); 

		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		$result = $projectModelObject -> saveProject("$projectId","$projectName"); 
		$this->_redirect('/project');
    }
/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteAction()
    {
	
		$request 		= $this->getRequest();
	    $projectId = $request->getParam('id'); 
		
		//create new object of project model
		$projectModelObject = new Application_Model_ProjectModel(); 
		$result = $projectModelObject -> deleteProject("$projectId"); 
		$this->_redirect('/project');
    }


/** 
 * Function for home page of each project . 
 * @param None
 * @return None
 */
    public function projecthomeAction()
    {
		$request  = $this->getRequest();
	    $projectId = $request->getParam('id'); 
		
		$status = $this->getParam('s'); 
		
		if($status == 'invalid'){
		    $message = "Please configure the project, before running pups prime calculations! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'success'){
		    $message = "Successfully run PUP Prime calculation! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'invalid_ace'){
		    $message = "Please configure the project, before running ace calculation ! ";
			$this->view->assign('message',$message); 
		}elseif($status == 'success_ace'){
		    $message = "Successfully run ace calculation! ";
			$this->view->assign('message',$message); 
		}
		
		$projectModelObject = new Application_Model_ProjectModel(); 
		$data = $projectModelObject -> getProjectDetails("$projectId"); 
		$primeCalcStatusArr = $projectModelObject -> checkPrimeCalcStatus("$projectId");
		$aceCalcStatusArr = $projectModelObject -> checkAceCalcStatus("$projectId"); 
		$totalClientsArr = $projectModelObject -> totalClientsCount("$projectId"); 
		$totalPrimeRunClientsArr = $projectModelObject -> totalPrimeRunClients("$projectId"); 
		$totalAceRunClientsArr = $projectModelObject -> totalAceRunClients("$projectId");  
		$totalPrimeCcSumupArr = $projectModelObject -> totalPrimeCcSumup("$projectId"); 
		$totalPrimeAceSumupArr = $projectModelObject -> totalPrimeAceSumup("$projectId");  
		$totalProfitLoss = $projectModelObject -> totalProfitLoss("$projectId");

		$primeCalcStatus = $primeCalcStatusArr[0];
		$aceCalcStatus   = $aceCalcStatusArr[0]; 
		$totalClients 	 = $totalClientsArr[0];
		$totalPrimeRunClients = $totalPrimeRunClientsArr[0];
		$totalAceRunClients = $totalAceRunClientsArr[0];
		$totalPrimeCcSumup = $totalPrimeCcSumupArr[0]; 
		$totalPrimeAceSumup = $totalPrimeAceSumupArr[0];
		$PrimeTotals = $projectModelObject -> PrimeTotals($projectId);	  
		$AcesTotals = $projectModelObject -> AcesTotals($projectId);
		$ClientsTotals = $projectModelObject -> ClientsTotals($projectId);
		$this->view->assign('PrimeTotals',$PrimeTotals); 
		$this->view->assign('AcesTotals',$AcesTotals); 
		$this->view->assign('ClientsTotals',$ClientsTotals); 

		$this->view->assign('primeCalcStatus',$primeCalcStatus); 
		$this->view->assign('totalClients',$totalClients); 
		$this->view->assign('aceCalcStatus',$aceCalcStatus); 
		$this->view->assign('totalPrimeRunStatus',$totalPrimeRunClients); 
		$this->view->assign('totalAceRunStatus',$totalAceRunClients); 
		$this->view->assign('totalPrimeCcSumup',$totalPrimeCcSumup); 
		$this->view->assign('totalPrimeAceSumup',$totalPrimeAceSumup); 
		$this->view->assign('totalProfitLoss',$totalProfitLoss); 
		
		$this->view->assign('data',$data); 
		$this->view->assign('projectId',$projectId); 
		
		
		
				  //---------- Configuring Second Chart ----------//
  # Create another Column3D chart object
  $FC2 = new FusionCharts("Column3D","1000","300" ,"0");
  # set the relative path of the swf file
  $FC2->setSWFPath("/pups/public/includes/charts/");

  # Store chart attributes in a variable
  $strParam="caption=Top Client Report in USD;subcaption=;xAxisName=;yAxisName=Amount ;decimalPrecision=5";

  # Set chart attributes
  $FC2->setChartParams($strParam);
/*
  # Add chart values and category names for the second chart
  $FC2->addChartData("$noofusers","name=Registered Users");
  $FC2->addChartData("$noofresultfeedback","name=Feedbacks");
  $FC2->addChartData("$noofenquiry","name=Enquiries");
  $FC2->addChartData("$noofproducts","name=Products");
  $FC2->addChartData("$noofgroups","name=Groups");
  $FC2->addChartData("$noofoffers","name=Offers");
 */ 
  $FC2->addChartData("2700","name=Tupelo Eye Center");
  $FC2->addChartData("2927.59","name=North MS Pediatrics");
  $FC2->addChartData("1483.91","name=Mid-South Propane");
  $FC2->addChartData("1826.94","name=The Jackson Clinic ");
  $FC2->addChartData("938.05","name=KNS Medical, Inc");
  $FC2->addChartData("1826.94","name=The Jackson Clinic ");

 //$FC2->renderChart();

		$this->view->assign('fc2', $FC2); 
		
		
	}
/** 
 * Function to export CSV file for project details . 
 * @param $projectId
 * @return CSV
*/
    public function csvexportprimeAction()
    {
        $request = $this->getRequest();
	$projectId = $request->getParam('id'); 

	//create new object of project model
	$projectModelObject = new Application_Model_ProjectModel(); 
		
	$result = $projectModelObject->runprimecsvfile("$projectId");
    }
    
    /** 
 * Function to export CSV file for project details . 
 * @param $projectId
 * @return CSV
*/
    public function csvexportacesAction()
    { 
        $request = $this->getRequest();
	$projectId = $request->getParam('id'); 

	//create new object of project model
	$projectModelObject = new Application_Model_ProjectModel(); 
		
	$result = $projectModelObject->runacescsvfile("$projectId");
    }

}

