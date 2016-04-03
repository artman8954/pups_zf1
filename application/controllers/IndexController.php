<?php

/** 
 * Controller class for default index page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 28th Aug 2013 
 */

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        

    }
	
/** 
 * Function for index action. Setting seperate login layout.
 * @param None
 * @return None
 */
    public function indexAction()
    {

        $auth = Zend_Auth::getInstance(); 
	//check whether already logged in 
	if($auth->hasIdentity()){
	  $this->_redirect('/home/index');
	}
       // Setting seperate layout for login 
	    Zend_Layout::getMvcInstance()->setLayout('loginlayout');

		$title = Zend_Registry::get('title');
		$this->view->assign('title', $title);
		
		$request = $this->getRequest();
		
		$invalid = $request->getParam('invalid'); 
		$baseUrl =  $request->getBaseURL();
		
		$this->view->assign('action', $baseUrl ."/index/auth");
		
		if($invalid == 'yes'){
		    $this->view->assign('msg', "Invalid Username/Password.");
		}else if($invalid == 'sess'){
		    $this->view->assign('msg', "Session expired.Please login again.");
		}else if($invalid == 'logout'){
		    $this->view->assign('msg', "You have successfully logged out");
		}

    }

/** 
 * Function for login action. 
 * @param None
 * @return None
 */
    public function authAction()
    {

		$request = $this->getRequest();
		$username = $request->getParam('txtUsername'); 
		$password = $request->getParam('txtPassword'); 
		
		//create new object of index model
		$indexModelObject = new Application_Model_IndexModel(); 

		//checking the authentication in the index model			
		$result = $indexModelObject->authentication($username, $password); 
		 
	     if($result){
  	         $this->_redirect('/home');
	      }else{
	         $this->_redirect('/index/index/invalid/yes');
	      }
    }// End of function 
	
	
/** 
 * Function for index action. Setting seperate login layout.
 * @param None
 * @return None
 */
     public function logoutAction()
     {
         $auth = Zend_Auth::getInstance();
	     $auth->clearIdentity();
	     $this->_redirect('/index/index/invalid/logout');
     }	
	 
	 
} // End of class

