<?php

/** 
 * Controller class for default index page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 28th Aug 2013 
 */

class GroupController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		$auth = Zend_Auth::getInstance(); 
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
		
		$project_id = $this->getParam('id');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		
		if($project_id > 0){
			//create new object of project model
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject->getProjectDetails($project_id); 
			$projectName = $projectDetails[$project_id]['project_name'];
		}else{
			$projectName = 'All Projects';
		}
		
		$groupModelObject = new Application_Model_GroupModel(); 
		$result = $groupModelObject -> getClientGroups($project_id,$search_key, $column_name, $page); 
		
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('project_name',$projectName); 
		$this->view->assign('project_id',$project_id); 
		
		
    }


/** 
 * Function for new client import. 
 * @param None
 * @return None
 */
    public function clientpopupAction(){
	
       // Setting seperate layout for login 
	    Zend_Layout::getMvcInstance()->setLayout('popuplayout');
		
		
		$page=$this->getParam('page',1);
		$search_key = $this->getParam('search_text');
		$column_name = $this->getParam('search_field');
		
		$project_id = $this->getParam('id');
		 
		 		
		if($project_id > 0){
			//create new object of project model
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject->getProjectDetails($project_id); 
			$projectName = $projectDetails[$project_id]['project_name'];
		}else{
			$projectName = 'All Projects';
		}

		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		
		$clientModelObject = new Application_Model_ClientModel(); 
		$result = $clientModelObject -> getClientsForGroup($project_id,$search_key, $column_name, $page); 
		
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		$this->view->assign('project_name',$projectName); 
		$this->view->assign('project_id',$project_id); 


			
			
    }
	
	/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function saveAction() {
	
		//create new object of project model
		$groupModelObject = new Application_Model_GroupModel(); 
	
		$request 	= $this->getRequest();
		
		$id = $request->getParam('contactidlist');
		
		$client_ids = $request->getParam('contactidlist');
		
		$client_id_array = explode(";",$client_ids);
		$projectId = $request->getParam('id'); 
				
		$client_id = $groupModelObject -> saveGroup( $client_id_array, $projectId ); 


		
		/*
		$client = $clientModelObject -> checkExistingClientId($client_id, $projectId);
		
		$project_client_id = $client[0];
		
		if($project_client_id > 0){
			$this->_redirect('/client/newclient/id/' . $project_client_id.'/e/s');
		}

		$client = $clientModelObject -> getProjectClientId($client_id);  
		$project_client_id = $client[0];
		
		$client_id = $clientModelObject -> saveClient($project_client_id, $data); 
		
		$proj_client_id = $client_id['id'];
*/

		$this->_redirect('/group/index/id/' . $projectId );
		
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
	



} // End of class

