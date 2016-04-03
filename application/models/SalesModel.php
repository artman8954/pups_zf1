<?php

/** 
 * Model class for proejct
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 28th Aug 2013 
 */

class Application_Model_SalesModel
{


/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getSales($search_key,$column_name,$page,$avoidSearch = false)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$page = $page;
		
		$searchCondition = '';
		
		if($search_key != ''){
			$searchCondition = " AND $column_name like '%$search_key%'  " ;
		}
		
        $sql = "SELECT * FROM `tbl_sales_commission` as sc
		INNER JOIN tbl_users as u on sc.created_by = u.user_id
		WHERE sc.`deleted` = 0 " . $searchCondition . " ORDER BY `created_time` DESC ";
  		$result = $DB->fetchAll($sql);
		
		
    	$paginator = Zend_Paginator::factory($result);
		
		if($avoidSearch == true){
			$countPerPage = $paginator->getTotalItemCount();
		}else{
			$countPerPage = 100;
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
    public function getSsalesDetails($id) {
	
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT * FROM `tbl_sales_commission` as sc WHERE sc.`deleted` = 0 AND sc.sales_id_prime = $id ";
  		$result = $DB->fetchAssoc($sql);
		return $result;
		
    }
	
	
/** 
 * Function for save project details
 * @param None
 * @return None
 */
    public function saveSales($id,$salesId,$salesPercentage,$notes)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$created_datetime = date("Y-m-d h:i:s");
		
		$data = array('sales_id' => $salesId,
					   'sales_comm_percentage' => $salesPercentage,
					   'notes' => $notes,
					   'created_by' => 1,
					   'created_time' => $created_datetime);
		 
		if($id > 0){
			$DB->update('tbl_sales_commission', $data,"sales_id_prime = $id");
		}else{
			$DB->insert('tbl_sales_commission', $data);
		}
		
		return $result;
    }

/** 
 * Function for delete sales commission details
 * @param None
 * @return None
 */
    public function deleteSales($id)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		if($id > 0){
			$data = array('deleted' => 1 ); 
			$DB->update('tbl_sales_commission', $data," sales_id_prime = $id");
		}
		
		return $result;
    }
	
/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getSalesList(){
	
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
        $sql = "SELECT sales_id,sales_comm_percentage FROM `tbl_sales_commission` where `deleted` = 0  ORDER BY  sales_id DESC ";
		
  		$result = $DB->fetchAssoc($sql);
		return $result; 
		
    }



} // End of class

