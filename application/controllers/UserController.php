<?php

/** 
 * Controller class for Projects
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 3rd Sept 2013 
 */


class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		$auth		= Zend_Auth::getInstance(); 
		//check whether already logged in 
	    if(!$auth->hasIdentity()){
	      $this->_redirect('/index/index/invalid/sess');
	    }
		$user    = $auth ->getIdentity();
		if(! $user->isadmin)
		{
			$this->_redirect('/home');	
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
		 
		$params = array('search_text' => $search_key , 'search_field' => $column_name );
		//create new object of project model
		$object = new Application_Model_UserModel(); 
		$result = $object -> getItems($search_key, $column_name, $page); 
		//assign given result to view
  		$this->view->assign('paginator',$result); 
		$this->view->assign('params',$params); 
		
    }

/** 
 * Function for new action of Project controller. 
 * Used for listing of projects
 * @param None
 * @return None
 */

    public function newAction()
    {
	
		$request 	= $this->getRequest();
		$id 	= $request->getParam('id');
		
		if($id > 0){
			$object = new Application_Model_UserModel(); 
			$result = $object -> getItem($id); 
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
	    $id = $request->getParam('id'); 

		$data = array(
				  	 	'username' => $request->getParam('username'),
			  	     	'isadmin' => $request->getParam('isadmin'),
						'name' => $request->getParam('name'),
						'phone' => $request->getParam('phone'),
						'email' => $request->getParam('email'),
						'mobile' => $request->getParam('mobile'),
					);
		if ($request->getParam('password') != '')
		{
			$data['password'] = md5($request->getParam('password'));
		}

		//create new object of project model
		$object = new Application_Model_UserModel(); 
		if ($id)
		{
			$where = $object->getAdapter()->quoteInto('user_id = ?', $id);
			$object->update($data, $where);		
		}
		else
		{
			$data['date_of_creation'] = time();
			$object->insert($data);	
		}

		$this->_redirect('/user');
    }
/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function deleteAction()
    {
	
		$request 		= $this->getRequest();
	    $id = $request->getParam('id'); 
		
		//create new object of project model
		$object = new Application_Model_UserModel(); 
		$result = $object -> deleteUser($id); 
		$this->_redirect('/user');
    }

/** 
 * Function for delete Project . 
 * @param None
 * @return None
 */
    public function changepassAction()
    {

		if ($this->getRequest()->isPost()) {
			
			$auth		= Zend_Auth::getInstance(); 
			$user       = $auth->getIdentity();
			$user_id 	= $user->user_id;
			$current_password = $user->password;
			
			
			$request 		= $this->getRequest();
			$presentPass 	= md5($request->getParam('txtpasswordpresent')); 
			
			$newPass = $request->getParam('txtpassword1'); 
			$data = array ('password' => md5($newPass) ); 
			
				if($current_password == $presentPass){
					$object = new Application_Model_UserModel(); 
					$result = $object -> changepass($data,$user_id);
					//if($result == true)
					{
						$this->view->assign('msg', "Password changed successfully ! " ); 
					}
				}else{
					$this->view->assign('msg', "Current password and given current password are different ! " ); 
				}
		
		} 

    }


}

