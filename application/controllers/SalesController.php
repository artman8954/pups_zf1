<?php

/** 
 * Controller class for Projects
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 3rd Sept 2013 
 */


class SalesController extends Zend_Controller_Action
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
		
		$column_name = $this->getParam('search_field');
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		//create new object of project model
		$salesModelObject = new Application_Model_SalesModel(); 
		$result = $salesModelObject -> getSales($search_key, $column_name, $page); 
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

    public function newsalesAction()
    {
	
		$request 	= $this->getRequest();
		$id 	= $request->getParam('id');
		
		if($id > 0){
		
			$salesModelObject = new Application_Model_SalesModel(); 
			$result = $salesModelObject -> getSsalesDetails($id); 
  			$this->view->assign('data',$result); 
  		    $this->view->assign('id',$id); 
			
		} 	
		
    }
	

/** 
 * Function for save action of new/edit Project . 
 * @param None
 * @return None
 */
    public function saveAction()
    {
	
		$request 		= $this->getRequest();
		$salesId 	= $request->getParam('txtSalesId'); 
		$salesPercentage 	= $request->getParam('txtSalesPercentage');
		$notes 	= $request->getParam('txtNotes'); 
	    $id = $request->getParam('id'); 

		//create new object of sales model
		$salesModelObject = new Application_Model_SalesModel(); 
		$result = $salesModelObject -> saveSales($id,$salesId,$salesPercentage,$notes); 
		$this->_redirect('/sales');
    }



/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteAction(){
	
		$request 		= $this->getRequest();
	    $id = $request->getParam('id'); 
		
		//create new object of project model
		$salesModelObject = new Application_Model_SalesModel(); 
		$result = $salesModelObject -> deleteSales("$id"); 
		
		$this->_redirect('/sales');
		
    }

}

