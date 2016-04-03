<?php

/** 
 * Controller class for default index page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 28th Aug 2013 
 */

class DocumentController extends Zend_Controller_Action
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
		$column_name = $this->getParam('search_field');

		$projectId = $this->getParam('id');
		
		$projectModelObject = new Application_Model_ProjectModel(); 
		$projectDetail = $projectModelObject->getProjectDetails($projectId);
		
		$projectName = $projectDetail[$projectId]['project_name'];

		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		//create new object of project model
		$documentModelObject = new Application_Model_DocumentModel(); 
		$result = $documentModelObject -> getDocuments($projectId, $search_key, $column_name, $page,true); 
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('projectname',$projectName); 
		$this->view->assign('project_id',$projectId); 
		
		
    }
	
/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteAction()
    {
	
		$request 		= $this->getRequest();
	    $docId = $request->getParam('id'); 
		$projId = $request->getParam('prid'); 
		
		//create new object of project model
		$documentModelObject = new Application_Model_DocumentModel(); 
		$result = $documentModelObject -> deleteDocument("$docId"); 
		$this->_redirect('/document/index/id/' . $projId );
    }

/** 
 * Function for downloading file. 
 * @param None
 * @return None
 */
    public function downloadAction()
    {
	
		$request 		= $this->getRequest();
	    $docId = $request->getParam('id'); 
		
		//create new object of project model
		$documentModelObject = new Application_Model_DocumentModel(); 
		$result = $documentModelObject -> getProjectDetails("$docId"); 
		
		$config = new Zend_Config(require '/application/configs/config.php' );
		$fullPath = $config->csvUploadDir . $result[$docId][doc_name]; 
		
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
    }

} // End of class

