<?php

/** 
 * Model class for proejct
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 28th Aug 2013 
 */

class Application_Model_UserModel extends Zend_Db_Table
{
    protected $_name = 'tbl_users';
    protected $_primary = 'user_id';



/** 
 * Function for get project list
 * @param None
 * @return None
 */
    public function getItems($search_key,$column_name,$page,$avoidSearch = false)
    {
  		$select = $this->select()
		        	->where('deleted = 0');
		if($search_key != ''){
			$select->where("$column_name like '%$search_key%'");
		}

		$result = $this->fetchAll($select);  		
    	$paginator = Zend_Paginator::factory($result);
		
		if($avoidSearch == true){
			$countPerPage = $paginator->getTotalItemCount();
		}else{
			$countPerPage = 10;
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
    public function getItem($id)
    {
		$select = $this->select()
			->where('deleted = 0')
			->where('user_id = ?', $id);
  		$result = $this->fetchRow($select);
		return $result;
    }
	
	
/** 
 * Function for save project details
 * @param None
 * @return None
 */
    public function changepass($data,$user_id)
    {
		$registry   = Zend_Registry::getInstance();
		$DB  = $registry['DB'];
		$result = $DB->update('tbl_users', $data,"user_id = $user_id");
		return $result ;
    }

/** 
 * Function for delete project details
 * @param None
 * @return None
 */
    public function deleteUser($id)
    {
		if($id > 0){
			$data = array('deleted' => 1 ); 
			$where = $this->getAdapter()->quoteInto('user_id = ?', $id);
 			$this->update($data, $where);
		}
    }

} // End of class

