<?php

/** 
 * Controller class for logged in home page
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @created date 3rd Sept 2013 
 */

include('charts/class/FusionCharts_Gen.php');
  
class HomeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		$auth	= Zend_Auth::getInstance(); 
		
		//check whether already logged in 
	    if(!$auth->hasIdentity()){
	      $this->_redirect('/index/index/invalid/sess');
	    }
    }

    public function indexAction()
    {
	
		$auth	 = Zend_Auth::getInstance(); 
		$user    = $auth ->getIdentity();
		$this->view->assign('user',$user); 
		
		  //---------- Configuring Second Chart ----------//
  # Create another Column3D chart object
  $FC2 = new FusionCharts("Column3D","1000","300" ,"0");
  # set the relative path of the swf file
  $FC2->setSWFPath("/zend/public/includes/charts/");

  # Store chart attributes in a variable
  $strParam="caption=Top Client Report in USD;subcaption=;xAxisName=;yAxisName=Amount ;decimalPrecision=5";

  # Set chart attributes
  $FC2->setChartParams($strParam);
/*
  # Add chart values and category names for the second chart
  $FC2->addChartData("$noofusers","name=Registered Users");
  $FC2->addChartData("$noofresultfeedback","name=Feedbacks");
  $FC2->addChartData("$noofenquiry","name=Enquiries");
  $FC2->addChartData("$noofproducts","name=Products");
  $FC2->addChartData("$noofgroups","name=Groups");
  $FC2->addChartData("$noofoffers","name=Offers");
 */ 
  $FC2->addChartData("2700","name=Tupelo Eye Center");
  $FC2->addChartData("2927.59","name=North MS Pediatrics");
  $FC2->addChartData("1483.91","name=Mid-South Propane");
  $FC2->addChartData("1826.94","name=The Jackson Clinic ");
  $FC2->addChartData("938.05","name=KNS Medical, Inc");
  $FC2->addChartData("1826.94","name=The Jackson Clinic ");

 //$FC2->renderChart();

		$this->view->assign('fc2', $FC2); 
		

    }
}

