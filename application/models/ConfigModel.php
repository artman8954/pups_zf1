<?php

/** 
 * Model class for configuration
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 4th Sept 2013 
 */

class Application_Model_ConfigModel
{


	
	
	/** 
 * Function for save new project details
 * @param None
 * @return None
 */
    public function getConfig($projectId)
    {
		
        $registry   = Zend_Registry::getInstance();
        $auth       = Zend_Auth::getInstance();
		$DB  = $registry['DB'];


        
		//$sql = "INSERT INTO  `tbl_projects`(project_name) VALUES('$projectName') ";
  		//$result = $DB->query($sql);
		//return $result;
		
		  
    }
	
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function getConfigDetails($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = " SELECT project_id,prime_account_no,controlled_cost_no,prime_labor_cost,cc_med_labor_cost,
				prime_benefit_cost,cc_med_benefit_cost,prime_statement_cost,sm_med_cont_aces_stmnt_cost,
				prime_other_direct_cost,cc_other_direct_cost,indirect_cost,total_comp_fee_collected,total_legal_expense,
				total_legal_earned,active_client_no,sales_bonus_id,small_bal_acc_cost,total_fee_income_for_the_year,
				aces_labor_cost,aces_total_acc_no,aces_benefit_cost,aces_statement_cost,aces_sales_bonus_id,aces_other_direct_cost,
				aces_indirect_cost,aces_total_com_fee_collected FROM `tbl_config` WHERE `deleted` = 0 AND project_id = $projectId limit 1 ";
  		$result = $DB->fetchAssoc($sql);
		return $result;
    }

/** 
 * Function for save config details
 * @param None
 * @return None
 */
    public function saveConfig($config_id,$data)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		if($config_id > 0){
			$DB->update('tbl_config', $data,"config_id = $config_id");
		}else{
			$DB->insert('tbl_config', $data);
		}
		
		return $result;
    }
	
/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function getConfigId($projectId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
        $sql = " SELECT config_id FROM `tbl_config` WHERE `deleted` = 0 AND project_id = $projectId limit 1 ";
  		$result = $DB->fetchCol($sql);
		return $result;
    }



} // End of class

