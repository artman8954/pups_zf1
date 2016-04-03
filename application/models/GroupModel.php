<?php

/** 
 * Model class for client(customer) information
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 4th Sept 2013 
 */
 

class Application_Model_GroupModel
{
	
	
/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getClientGroups($project_id,$search_key,$column_name,$page)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$page = $page;
		
		$searchCondition = '';
		
		if($search_key != ''){
			$searchCondition = " AND $column_name like '%$search_key%'  " ;
		}
		
		if($project_id > 0) {
			$searchCondition = $searchCondition .  " AND cl.project_id =  $project_id " ;
		}
		
		
        $sql = " SELECT group_id,GROUP_CONCAT(client_id SEPARATOR ','  ) AS group_name ,GROUP_CONCAT(client_name SEPARATOR '<br>'  ) AS group_items FROM tbl_clientgroups AS cg
				INNER JOIN tbl_clients AS cl ON cl.proj_client_id = cg.proj_client_id 
				AND  cl.deleted = 0 AND cg.deleted = 0  AND cl.project_id = $project_id GROUP BY GROUP_ID  "; 
		
		
  		$result = $DB->fetchAll($sql);
		
    	$paginator = Zend_Paginator::factory($result);
		
		$totalcount =  $paginator->getTotalItemCount(); 
		
    	$paginator->setItemCountPerPage(25);
		
    	$paginator->setCurrentPageNumber($page);
	
	
		return $paginator;
    }
	
	
	
	
	/** 
 * Function for save client details
 * @param None
 * @return None
 */
    public function saveGroup($clientids, $projectId){
	
       	$registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];


		$auth       = Zend_Auth::getInstance();
    	$user       = $auth ->getIdentity();
    	$userid   	= $user ->user_id;
		
		$created_datetime = date("Y-m-d h:i:s");

		$groupData = array('created_by' => $userid, 'created_datetime' => $created_datetime ); 
						
						
			$result = $DB->insert('tbl_groups', $groupData );
			$id = $DB->lastInsertId();
			
			
			if(count($clientids) > 0 ){
				foreach($clientids as $val){
				
					if( $val > 0 ){
					
						$clientgroupdata = array(
							'proj_client_id' => $val,
							'group_id' => $id
						); 
						$result = $DB->insert('tbl_clientgroups', $clientgroupdata );	
					
					}	
				}
			}

		$this->saveClientGroupData($clientids, $projectId); 

		return array('id' => $id, 'status' => $status );
		
		
    }
	
	
	function saveClientGroupData($clientids, $projectId){
	
	       	$registry   = Zend_Registry::getInstance();
			$DB  = $registry['DB'];

	
			$arrData = array(); 
	
			if(count($clientids) > 0 ){ 

				$i = 0;
				foreach($clientids as $val){
				
					if( $val <= 0 ){
						continue; 
					}
				
					$clientModel = new Application_Model_ClientModel() ; 
					$arrData = $clientModel -> getClientDetail($val);
					$arr[] = $arrData[$val] ; 
					
					$arrClientDetails['project_id']   = $projectId;
					
					$arrClientDetails['client_id']  =  $arrData[$val]['client_id'] . ", " . $arrClientDetails['client_id_group'];
					$arrClientDetails['client_id_group']  =  $arrData[$val]['client_id'] . ", " . $arrClientDetails['client_id_group'];
					$arrClientDetails['list_amount']  +=  $arrData[$val]['list_amount'];
					$arrClientDetails['client_name']  =  $arrClientDetails['client_id'] ;
					$arrClientDetails['status']  	   =  $arrData[$val]['status'];
					$arrClientDetails['sales_rep_id']  	   =  $arrData[$val]['sales_rep_id'];
					$arrClientDetails['paid_amount']  	   =  $arrData[$val]['paid_amount'];
					$arrClientDetails['earned_amount']  +=  $arrData[$val]['earned_amount'];
					$arrClientDetails['age']  =  $arrData[$val]['age'];
					$arrClientDetails['small_balance']   +=  $arrData[$val]['small_balance'];
					$arrClientDetails['medium_balance']  +=  $arrData[$val]['medium_balance'];
					$arrClientDetails['large_balance']   +=  $arrData[$val]['large_balance'];

					$arrClientDetails['legal_fee_amount']   +=  $arrData[$val]['legal_fee_amount'];
					$arrClientDetails['legal_fee_amount_earned_us']  +=  $arrData[$val]['legal_fee_amount_earned_us'];
					$arrClientDetails['legal_fee_amount_earned_client']   +=  $arrData[$val]['legal_fee_amount_earned_client'];
					
					$arrClientDetails['legal_total_amount_earned']   +=  $arrData[$val]['legal_total_amount_earned'];
					$arrClientDetails['court_cost_fee']  +=  $arrData[$val]['court_cost_fee'];
					$arrClientDetails['attorney_fee']   +=  $arrData[$val]['attorney_fee'];
					
					$arrClientDetails['collection_fee']   +=  $arrData[$val]['collection_fee'];
					$arrClientDetails['principal_paid']  +=  $arrData[$val]['principal_paid'];
					$arrClientDetails['total_paid']   +=  $arrData[$val]['total_paid'];
					
					$arrClientDetails['aces_es1']   +=  $arrData[$val]['aces_es1'];
					$arrClientDetails['aces_es2']   +=  $arrData[$val]['aces_es2'];
					$arrClientDetails['aces_es3']   +=  $arrData[$val]['aces_es3'];
					$arrClientDetails['aces_esf']   +=  $arrData[$val]['aces_esf'];
			
					$arrClientDetails['aces_list_amount']   +=  $arrData[$val]['aces_list_amount'];
					$arrClientDetails['aces_paid_amount']   +=  $arrData[$val]['aces_paid_amount'];
					$arrClientDetails['controlled_cost_accounts']   +=  $arrData[$val]['controlled_cost_accounts'];
					$arrClientDetails['average_age_acc']   =  $arrData[$val]['average_age_acc'];
			


					
				}
				
			}
	
					$client_groupdata = array(
						'proj_client_id' => $val,
						'group_id' => $id
					); 

	
		$result = $DB->insert('tbl_clients', $arrClientDetails);		



	//print_r($arrClientDetails); 
	
	//exit; 
	
	}
	
/** 
 * Function for save client details
 * @param None
 * @return None
 */
    public function saveClient($proj_client_id,$data,$importStatus = 0)
    {
	
       	$registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		$DB->getProfiler()->setEnabled(true);
	
		if($importStatus == 1){
		    $client_id = $data['client_id'] ; 
			$project_id = $data['project_id'] ; 
			$resArr = $this -> checkExistingClientId($client_id,$project_id);
			$proj_client_id = $resArr[0];
		}
		
		if($proj_client_id > 0){
			$result = $DB->update('tbl_clients', $data," proj_client_id = $proj_client_id");
			$id = $proj_client_id;
			$status = 'update';
		}else{
			$result = $DB->insert('tbl_clients', $data);
			$id = $DB->lastInsertId();
			$status = 'new';
		}

		return array('id' => $id, 'status' => $status );
    }


		
	
} // End of class

