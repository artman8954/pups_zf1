<?php

/** 
 * Controller class for config
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 28th Aug 2013 
 */

class ConfigController extends Zend_Controller_Action
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
 * Function for index action. 
 * @param None
 * @return None
 */
    public function indexAction()
    {

    }

/** 
 * Function for new configuration. 
 * @param None
 * @return None
 */
    public function newconfigAction()
    {
		$auth		= Zend_Auth::getInstance();     	
		$user    = $auth ->getIdentity();
		if(! $user->isadmin)
		{
			$this->_redirect('/home');	
		}

		$request 	= $this->getRequest();
		$projectId 	= $request->getParam('id');
		
		if($projectId > 0){
			$configModelObject = new Application_Model_ConfigModel(); 
			$result = $configModelObject -> getConfigDetails($projectId); 
			
			$projectModelObject = new Application_Model_ProjectModel(); 
			$projectDetails = $projectModelObject -> getProjectDetails($projectId); 
			
			$salesModel = new Application_Model_SalesModel();
			
			$salesList = $salesModel-> getSalesList(); 
			$session = new Zend_Session_Namespace('session');
  		    if (isset($session->config))
  		    	$this->view->assign('saved_projectId',$session->config); 

  			$this->view->assign('data',$result); 
  		    $this->view->assign('projectId',$projectId); 
			$this->view->assign('projectDetail',$projectDetails); 
			$this->view->assign('salesdata',$salesList); 
			unset($session->config);
		} 	
		


    }// End of function 
	
	/** 
 * Function for save action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */
    public function saveAction()
    {

		//create new object of project model
		$configModelObject = new Application_Model_ConfigModel(); 

		$request 		= $this->getRequest();

		$id 	= $request->getParam('id'); 
	    $primeAccNo = $request->getParam('txtPrimeAccNo'); 
		$cntrCostNo = $request->getParam('txtContrCostNo'); 
		$primeLaborCost = $request->getParam('txtPrimeLaborCost');
		
		$config = $configModelObject -> getConfigId($id);  
		$config_id = $config[0];
		
		 $data = array(	'project_id' 			=> $request->getParam('id'),
	                	'prime_account_no' 		=> $request->getParam('txtPrimeAccNo'),
	                	'controlled_cost_no' 	=> $request->getParam('txtContrCostNo'),
	                	'prime_labor_cost' 		=> $request->getParam('txtPrimeLaborCost'),
						'cc_med_labor_cost' 	=> $request->getParam('txtCcMedLaborCost'),
						'prime_benefit_cost' 	=> $request->getParam('txtPrimeBenCost'),
						'cc_med_benefit_cost' 	=> $request->getParam('txtCcBenefitCost'),
						'prime_statement_cost' 	=> $request->getParam('txtPrimeStatementCost'),
						'sm_med_cont_aces_stmnt_cost' => $request->getParam('txtSmMedConStetementCost'),
						'prime_other_direct_cost' => $request->getParam('txtPrimeOtherDirectCost'),
						'cc_other_direct_cost' => $request->getParam('txtCcOtherDirectCost'),
						'indirect_cost' => $request->getParam('txtIndirectCost'),
						'total_comp_fee_collected' => $request->getParam('txtTotalCompFee'),
						'total_legal_expense' => $request->getParam('txtLegalExpense'),
						'total_legal_earned' => $request->getParam('txtLegalEarned'),
						'active_client_no' => $request->getParam('txtNoOfActiveClients'),
						'small_bal_acc_cost' => $request->getParam('txtSmallBalanceAccCost'),
						'total_fee_income_for_the_year' => $request->getParam('txtFeeIncomeYear'),	
						'aces_total_acc_no' => $request->getParam('txtTotalAcesAccounts'),	
						'aces_labor_cost' => $request->getParam('txtAcesLaborCost'),	
						'aces_benefit_cost' => $request->getParam('txtAcesBenefitCost'),
						'aces_statement_cost' => $request->getParam('txtAcesStatementCost'),
						'aces_other_direct_cost' => $request->getParam('txtAcesOtherDirectCost'),
						'aces_indirect_cost' => $request->getParam('txtAcesIndirectCost'),
						'aces_total_com_fee_collected' => $request->getParam('txtAcesTotalCompFee'),
						'sales_bonus_id' => $request->getParam('ddSalesBonus'),
						'aces_sales_bonus_id' => $request->getParam('ddAcesSalesBonus')
	                );
		
		
		$result = $configModelObject -> saveConfig($config_id,$data); 
		$session = new Zend_Session_Namespace('session');
		$session->config = $id;	
		$this->_redirect('/config/newconfig/id/' . $request->getParam('id') );
		
    }



} // End of class

