<?php

/** 
 * Model class for default index page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 28th Aug 2013 
 */

class Application_Model_IndexModel
{


/** 
 * Function for authentication
 * @param None
 * @return None
 */
    public function authentication($username,$password)
    {
		
        $registry   = Zend_Registry::getInstance();

        $auth       = Zend_Auth::getInstance();

		$DB = $registry['DB'];
		$authAdapter = new Zend_Auth_Adapter_DbTable($DB);
		Zend_Db_Table::setDefaultAdapter($DB);
		 
        $authAdapter->setTableName('tbl_users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');  
			   
	     $authAdapter->setIdentity($username);
         $authAdapter->setCredential(md5($password));
         $result = $auth->authenticate($authAdapter);
		
	     if($result->isValid()){
	         //$data = $authAdapter->getResultRowObject(null,'password');
	         $users= new Application_Model_UserModel();
	         $where = $users->getAdapter()->quoteInto('username = ?', $username);
	         $input = array ('lastlogin' => time());
	         $users->update($input, $where);
			 $data = $authAdapter->getResultRowObject( );
			 $data->lastlogin = $input['lastlogin'];
	         $auth->getStorage()->write($data);
			 return $auth;
	      }else{
		     return false;
	      }
		  
    }// End of function authentication
	
} // End of class

