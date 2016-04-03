<?php

/** 
 * Model class for proejct
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 28th Aug 2013 
 */

class Application_Model_ProjectModel extends Zend_Db_Table
{
    protected $_name = 'tbl_projects';
    protected $_primary = 'project_id';



/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getProjects($search_key,$column_name,$page,$avoidSearch = false)
    {
	
        $sql = $this-> select()
        			-> setIntegrityCheck(false)
        			-> from(array('p'=>'tbl_projects'), array('p.*'))
        			-> joinLeft(array('u'=>'tbl_users'), 'u.user_id = p.created_by', array('username'))
        			-> joinLeft(array('c'=>'tbl_clients'), 'p.project_id = c.project_id', 
        						array('count(c.proj_client_id) as client_count'))
        			-> where('p.deleted = 0')
        			-> order('p.created_time DESC')
        			-> group('p.project_id');
        			
		if($search_key != ''){
			$sql-> where('p.'.$column_name.' like "%.'.$search_key.'%" ');
		}
        //print $sql;	

  		$result = $this->fetchAll($sql);

    	$paginator = Zend_Paginator::factory($result);
		
		if($avoidSearch == true){
			$countPerPage = $paginator->getTotalItemCount();
		}else{
			$countPerPage = 25;
		}
		
    	$paginator->setItemCountPerPage($countPerPage);
    	$paginator->setCurrentPageNumber($page);
		return $paginator;
    }

/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function copyProject($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		$auth       = Zend_Auth::getInstance();
    	$user       = $auth ->getIdentity();
    	$userid   	= $user ->user_id;		
  		$result = $DB->query("CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM tbl_projects WHERE project_id = $projectId;");
  		$result = $DB->query("UPDATE tmptable_1 set project_id = 0, project_name=concat(project_name, '_copy'), created_time=NOW()
  				, last_updated_time=now(),last_updated_by  = $userid,created_by  = $userid;");
  		$result = $DB->query("INSERT INTO tbl_projects SELECT * FROM tmptable_1;");
  		$result = $DB->query("DROP TEMPORARY TABLE IF EXISTS tmptable_1;");
		$id 	= $DB->fetchOne('SELECT LAST_INSERT_ID();');
  		$result = $DB->query("CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM tbl_config WHERE project_id = $projectId AND deleted = 0 LIMIT 1;");
  		$result = $DB->query("UPDATE tmptable_1 set config_id=0, project_id = $id, created_time=NOW()
  				, last_updated_time=now(),last_updated_by  = $userid,created_by  = $userid;");
  		$result = $DB->query("INSERT INTO tbl_config SELECT * FROM tmptable_1;");
  		$result = $DB->query("DROP TEMPORARY TABLE IF EXISTS tmptable_1;");  		

		return $result;
    }

/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function getProjectDetails($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT prj.project_id,project_name,config.config_id FROM `tbl_projects` as prj 
		left join tbl_config as config on config.project_id = prj.project_id WHERE prj.`deleted` = 0 AND prj.project_id = $projectId ";
  		$result = $DB->fetchAssoc($sql);
		return $result;
    }
	
	
/** 
 * Function for save project details
 * @param None
 * @return None
 */
    public function saveProject($projectId,$projectName)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$auth       = Zend_Auth::getInstance();
    	$user       = $auth ->getIdentity();
    	$userid   	= $user ->user_id;

		$created_datetime = date("Y-m-d h:i:s");
		 
		if($projectId > 0){
					   
		   $data = array('project_name' => $projectName,
		  'last_updated_by' => $userid ,
		  'last_updated_time' => $created_datetime );

			$DB->update('tbl_projects', $data,"project_id = $projectId");
			
		}else{
		
			$data = array('project_name' => $projectName,
		 			'created_by' => $userid ,
					'created_time' => $created_datetime );
		
			$DB->insert('tbl_projects', $data);
			
		}
		
		return $result;
    }

/** 
 * Function for delete project details
 * @param None
 * @return None
 */
    public function deleteProject($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		if($projectId > 0){
			$data = array('deleted' => 1 ); 
			$DB->update('tbl_projects', $data," project_id = $projectId");
		}
		
		return $result;
    }
	
	/** 
 * Function for delete project details
 * @param None
 * @return None
 */
    public function runprime($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		$clientModelObject = new Application_Model_ClientModel(); 
		$status = $clientModelObject->checkValidityPupProcess($projectId);

		if(trim($status) != "valid"){
			return 'invalid';
		}

        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  		$result = $DB->fetchAssoc($sql);

		foreach($result as $item){
			$proj_client_id = $item['proj_client_id']; 
			$status =  $clientModelObject -> runPupProcess("$proj_client_id"); 
		}
		
		
    }
	
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function checkPrimeCalcStatus($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT COUNT(proj_client_id) as cnt FROM tbl_clients WHERE project_id = $projectId AND deleted = 0 
				AND (aces_es1 = 0 AND aces_es2 = 0 AND aces_es3 = 0 AND aces_esf = 0 ) 
				AND client_id NOT IN (SELECT DISTINCT client_id FROM tbl_prime_cc_calc  WHERE project_id =  $projectId ) ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }


/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function checkAceCalcStatus($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT COUNT(proj_client_id) as cnt FROM tbl_clients WHERE project_id = $projectId AND deleted = 0 
				AND (aces_es1 > 0 OR aces_es2 > 0 OR aces_es3 > 0 OR aces_esf > 0 )
				AND client_id NOT IN (SELECT DISTINCT client_id FROM tbl_aces_calc  WHERE project_id =  $projectId ) ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }


	
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalClientsCount($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT COUNT(proj_client_id) as cnt FROM tbl_clients WHERE project_id = $projectId AND deleted = 0 ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalPrimeCcSumup($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT SUM(total_fees_p12) as TOTAL_P12 FROM tbl_prime_cc_calc WHERE project_id = $projectId AND deleted = 0 ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }

/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function PrimeTotals($projectId)
    {
        $sql = $this-> select()
        			-> setIntegrityCheck(false)
        			-> from(array('a'=>'tbl_prime_cc_calc'), 
        				array('SUM(total_fees_p12) as TOTAL_P12' 
        					  , 'SUM(total_profit_loss_incl_indirect_p40) as total_profit_loss_incl_indirect'
        					  , 'SUM(total_labor_cost_p17) as total_labor_cost'
        					  , 'SUM(total_benefit_cost_p20) as total_benefit_cost'
        					  , 'SUM(total_statement_cost_p23) as total_statement_cost'
        					  , 'SUM(other_direct_cost_total_p28) as total_other_direct_cost'
        					  , 'SUM(indirect_cost_per_customer_p39) as total_indirect_cost'))
        			-> where('a.deleted = 0')
        			-> where('a.project_id = ?', $projectId);
	
  		$result = $this->fetchRow($sql);
		return $result;
    }
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function AcesTotals($projectId)
    {
        $sql = $this-> select()
        			-> setIntegrityCheck(false)
        			-> from(array('a'=>'tbl_aces_calc'), 
        				array('SUM(total_profit_loss_indirect_a24) as total_profit_loss_incl_indirect'
        					  , 'SUM(labor_cost_a13) as total_labor_cost'
        					  , 'SUM(benefit_cost_a14) as total_benefit_cost'
        					  , 'SUM(statement_cost_a15) as total_statement_cost'
        					  , 'SUM(other_direct_cost_a17) as total_other_direct_cost'
        					  , 'SUM(indirect_cost_per_company_a23) as total_indirect_cost'))
        			-> where('a.deleted = 0')
        			-> where('a.project_id = ?', $projectId);
	
  		$result = $this->fetchRow($sql);
		return $result;
    }
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function ClientsTotals($projectId)
    {
        $sql = $this-> select()
                    -> setIntegrityCheck(false)
                    -> from(array('a'=>'tbl_clients'), 
                        array('SUM(small_balance) as small_balance'
                              , 'SUM(medium_balance) as medium_balance'
                              , 'SUM(large_balance) as large_balance'
                              , 'SUM(ifnull(controlled_cost_accounts,0)) as controlled_cost_accounts'
                              , 'SUM(aces_es1) as aces_es1'
                              , 'SUM(aces_es2) as aces_es2'
                              , 'SUM(aces_es3) as aces_es3'
                              , 'SUM(aces_esf) as aces_esf'))
                    -> where('a.deleted = 0')
                    -> where('a.project_id = ?', $projectId);
        
        $result = $this->fetchRow($sql);
        return $result;
    }    
	/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalPrimeAceSumup($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT SUM(total_fees_a12) as TOTAL_A12 FROM tbl_aces_calc WHERE project_id = $projectId AND deleted = 0 ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }

/**
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalProfitLoss($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT SUM(total_profit_loss_p37) as TOTAL_A12 FROM tbl_prime_cc_calc WHERE project_id = $projectId AND deleted = 0 ";
  		$result = $DB->fetchOne($sql);
        $sql = "SELECT SUM(total_profit_lost_a21) as TOTAL_A12 FROM tbl_aces_calc WHERE project_id = $projectId AND deleted = 0 ";
  		$result2 = $DB->fetchOne($sql);
		return ($result+$result2);
    }    


/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalPrimeRunClients($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = " SELECT COUNT( DISTINCT client_id )  FROM tbl_prime_cc_calc  WHERE project_id =  $projectId ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }

/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function totalAceRunClients($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = " SELECT COUNT( DISTINCT client_id )  FROM tbl_aces_calc  WHERE project_id =  $projectId ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }

		
/** 
 * Function for delete project details
 * @param None
 * @return None
 */
 
    public function runace($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		$clientModelObject = new Application_Model_ClientModel(); 
		$status = $clientModelObject->checkValidityAcesProcess($projectId);

		if(trim($status) != "valid"){
			return 'invalid';
		}

        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  		$result = $DB->fetchAssoc($sql);

		foreach($result as $item){
			$proj_client_id = $item['proj_client_id']; 
			$status =  $clientModelObject -> runAcesProcess("$proj_client_id"); 
		}
		
    }

/** 
 * Function for delete project details
 * @param None
 * @return None
 */
 
    public function runprimepdfreport($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];


        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  		$result = $DB->fetchAssoc($sql);

		$clientModelObject = new Application_Model_ClientModel(); 
		
		foreach($result as $item){
			$proj_client_id = $item['proj_client_id']; 
			
			$status =  $clientModelObject -> saveClientPrimeReport("$proj_client_id"); 
		}
		
    }

/** 
 * Function for delete project details
 * @param None
 * @return None
 */
 
    public function runacepdfreport($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];


        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  		$result = $DB->fetchAssoc($sql);

		$clientModelObject = new Application_Model_ClientModel(); 
		
		foreach($result as $item){
			$proj_client_id = $item['proj_client_id']; 
			
			$status =  $clientModelObject -> saveClientAceReport("$proj_client_id"); 
		}
		
    }
    
    public function runprimecsvfile($projectId)
    {
        $registry = Zend_Registry::getInstance();
	$DB  = $registry['DB'];


        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  	$result = $DB->fetchAssoc($sql);

	$clientModelObject = new Application_Model_ClientModel(); 
	$totalData = array();	
	foreach($result as $item){
	  $proj_client_id = $item['proj_client_id']; 			
	  $status =  $clientModelObject -> saveProjectPrimeFile("$proj_client_id");   
          $totalData[] = $status;
	}
      
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$projectId.'_PrimeData.csv"');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array('Client Name', 'Client Id', 'Group Id', 'Large Balance Account','Medium Balance Account', 'Small Balance Account', 'Controlled Cost Account', 'Total Dollar Volume', 'Non Legal Dollar Recovered', 'Legal Dollar Recovered', 'Total Dollar Recovered', 'Average Age of Account', 'Average Balance', 'Recovery Rate', 'Fee Rate', 'Non Legal Fees', 'cc Attorney Fees', 'Total Fees', 'Average Fee Per Account', 'Labor Cost for Collector Contractor', 'Labor Cost for Collector Prime', 'Total Labor Cost', 'Benefit Cost ccmed', 'Benefit Cost Prime', 'Total Benefit Cost', 'Statement Cost ccmed', 'Statement Cost Prime', 'Total Statement Cost', 'Sales Bonus', 'Small Balance Account Cost', 'Other direct Cost Prime', 'Other Direct Cost ccmed', 'Other Direct Cost Total', 'Total Direct Cost', 'Client Legal Amount Earned', 'Total Legal Amount Earned', 'Legal Expenses Customer', 'Number of Active Customers', 'Average Cost Per Account', 'Total Cost of Collections', 'Total Profit Loss', 'Indirect Cost Per Customer', 'Total Profit Loss Include Indirect'));
        
        foreach ($totalData as $data){
            fputcsv($output, $data);
        }
        die();
		
    }
    
    public function runacescsvfile($projectId)
    {
        $registry = Zend_Registry::getInstance();
	$DB  = $registry['DB'];


        $sql = "SELECT proj_client_id FROM tbl_clients WHERE project_id = $projectId AND `deleted` = 0 ";
  	$result = $DB->fetchAssoc($sql);

	$clientModelObject = new Application_Model_ClientModel(); 
	$totalData = array();	
	foreach($result as $item){
	  $proj_client_id = $item['proj_client_id']; 			
	  $status =  $clientModelObject -> saveProjectAcesFile("$proj_client_id");   
          $totalData[] = $status;
	}
      
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$projectId.'_AcesData.csv"');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array('Client Name', 'Client Id', 'es1_a3', 'es1_a4','es1_a5', 'es1_a6', 'Total Dollar Volume', 'Total Dollar Volume Recovered', 'Average Age Account', 'Fee Amount', 'Misc Fee', 'Total Fee', 'Labor Cost', 'Benefit Cost', 'Statement Cost', 'Sales Bonus', 'Other Direct Cost', 'Total Direct Cost', 'Total Direct Cost Second', 'Total Number Active Customer', 'Average Cost per Account', 'Total Cost Collection', 'Total Profit Lost', 'Indirect Cost Company', 'Indirect Cost per Company', 'Total Placement', 'Increase in Collection 1', 'Increase in Collection 2'));
        
        foreach ($totalData as $data){
            fputcsv($output, $data);
        }
        die();

} 




} // End of class

