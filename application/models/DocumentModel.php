<?php

/** 
 * Model class for client(customer) information
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 4th Sept 2013 
 */

class Application_Model_DocumentModel
{
	
	
/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getDocuments($projectId, $search_key,$column_name,$page,$avoidSearch = false)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$page = $page;
		
		$searchCondition = '';
		
		if($search_key != ''){
			$searchCondition = " AND $column_name like '%$search_key%'  " ;
		}
		
		if($projectId > 0){
			$searchCondition = " AND project_id  =  $projectId  " ;
		}
		
        $sql = "SELECT * FROM `tbl_documents` as d
				LEFT JOIN tbl_users as u on d.created_by = u.user_id
				WHERE d.`deleted` = 0 " . $searchCondition . " ORDER BY `doc_id` DESC ";
  		$result = $DB->fetchAll($sql);
		
		
    	$paginator = Zend_Paginator::factory($result);
		
		if($avoidSearch == true){
			$countPerPage = $paginator->getTotalItemCount();
		}else{
			$countPerPage = 25;
		}
				
    	$paginator = Zend_Paginator::factory($result);
		
    	$paginator->setItemCountPerPage(10);
    	$paginator->setCurrentPageNumber($page);
	
		return $paginator;
    }
	
/** 
 * Function for delete docuement details
 * @param None
 * @return None
 */
    public function deleteDocument($docId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];

		if($docId > 0){
			$data = array('deleted' => 1 ); 
			$DB->update('tbl_documents', $data," doc_id = $docId");
		}
		
		return $result;
    }
	
	/** 
 * Function for save project details
 * @param None
 * @return None
 */
    public function saveDocument($docId,$projectId, $documentName,$size)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		
		$auth       = Zend_Auth::getInstance();
    	$user       = $auth ->getIdentity();
    	$userid   	= $user ->user_id;

		$created_datetime = date("Y-m-d h:i:s");
		 
		if($docId > 0){
					   
		   $data = array('doc_name' => $documentName,
		   				 'doc_size' => $size,
						 'project_id' => $projectId, 
		  				 'last_updated_by' => $userid ,
		  				 'last_updated_time' => $created_datetime );

			$DB->update('tbl_documents', $data,"doc_id = $docId");
			
		}else{
		
			$data = array('doc_name' => $documentName,
			              'doc_size' => $size,
						  'project_id' => $projectId, 
		 			      'created_by' => $userid ,
					      'created_time' => $created_datetime );
		
			$DB->insert('tbl_documents', $data);
			
		}
		
		return $result;
    }
	
	
	/** 
 * Function for get project details of given project id
 * @param None
 * @return None
 */
    public function getProjectDetails($docId)
    {
        $registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
        $sql = "SELECT * FROM `tbl_documents`  WHERE `deleted` = 0 AND doc_id = $docId ";
  		$result = $DB->fetchAssoc($sql);
		return $result;
    }



} // End of class

