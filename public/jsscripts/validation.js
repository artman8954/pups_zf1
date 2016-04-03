/*######################################################################################################################################
########################################################################################################################################
#
#                          This java script file  is used to check the validation of the form fields
#
#                                          The Fuctions included in this file is 
#
########################################################################################################################################

  1) usernamecheck(usernameobj)                            : This function is used to check the username entered is correct or not

  2) passwordcheck(passwordobj)                            : This function is used to check the wheather the password is enterd and 
   															 wheather the enterd password contains space and wheather the password
															 length is less than 5 etc

  3) confirmpasswordcheck(confirmpasswordobj,passwordobj)  : This function check wheather the enterd confirm password 
                                                             is correct and also check wheather the first password and 
															 confirm password are same
															 
  4) emptycheck(obj,cmd)                                   : This function is used to check wheather any of the fields is empty of not
  															 two parameters are one is the obj name and other is the name of the field
															  
  5) combocheck(comboboxobj,field type,defaultvalue)       : This funcation is used to check wheather ay combobox value is selected 
  															 or not PARAMETERS are combobox obj,Type of combobox value ie country,
															 salutaion etc,default value  of the combobox 
															 
  6) emailcheck(emailobj)       						   : This function is used to cheack the email . It will check whather 
  															 the enterd email is correctly formated or not
								  
  7) fullnamecheck(fullnameobj)                            : This function will check the full name of a person,
  															 Wheather it contains specail chracters,numbers etc
  
  8) urlcheck(urlobj)                                      : This function is used to check wheather the enterd url is 
  															 in the form www.name.com
  
  9) citycheck(cityobj,cmd)                                : This function is used to check the city name is correct 
  															,ie wheather the name start will alphabet wheather is cotains 
															special chars or number etc,the 2nd parameter is to specifie wheather
															it is a city or state or a country

  10) phonecheck(phoneobj,command) 						   : This function is used to check the phone number or fax number 
  															 ,it will chek wheather it contains only numbers and allowed
															 characters +, ,- , and the length of the number is grether than 4 and 
															 less than 25 etc
															 TWO PARAMETRS are one phone or fax object , 
															 2nd is wheather is is a phone or fax number 
  															 

  11) name(nameobj,nametype)                               : This function is used to check wheather the first name or last name is
                                                             correctly formated 
															 Two parameters are first is the name field obj, and secound is 
															 wheather it is first or last name
															 
  12) spaceonlycheck(obj,cmd)                              :  This funcation is to check whather the user entered only the space ina field or not															 															 
				

  13)  spacer(obj)                                         :  This function automaticaly chages the space to _ . We can call this function
  															  in onKeyup="spacer(this);"
															   
  14)  changeCase(obj)                                     :  This function automaticaly chages the first character of the word to 
  															  capital , we can call this funcation like
															  in onKeyup="changeCase(this);"
  
  15) isDate(monthobj,dateobj,yearobj)                     :  This function is used to check wheather the selected data month and year is 
                                                              in same format
 
  16) pincheck(obj)                             		   :  This function is used to check the pin number is correct or not													  
  
  17)isInteger(value) 										:Returns true if value contains all digits
  
  18)menucheck(obj)											:this function is to check whether any selection is made in th4e menu/list
  
  19)checkme(obj)											:this function is to check whether the check box is checked or not.
														  
#######################################################################################################################################*/



//######################################################################################################################################
// Function to check the user name is correctly entered or not
//######################################################################################################################################
//alert ("ok");
function usernamecheck(obj)
{
	if(obj.value =="")
			{
				alert ("Please enter a Username");
				obj.focus();
				return false;
			}
			
		   else
		   {
				var usr=obj.value;
				var ltr,i;
				
				for (i=0;i<usr.length;i++)
				{
				ltr = usr.substring(i,i+1);
	//checking whether there are spaces in the username
					if (ltr==' ')
					{
					alert("Invalid Username - Space not allowed ");
					obj.focus();
					return false;
					}
			   }
	//checking whether the first character is an alphabetic character
				if((usr.substring(0,1)<"a" || usr.substring(0,1)>"z") && (usr.substring(0,1)<"A" || usr.substring(0,1)>"Z"))
				{
					alert("The User Name should begin with an alphabetic character.");
					obj.focus();
					return false;
				}
				if(usr.length < 4)
			{
			alert ("Username cannot be less than Four characters");
				obj.focus();
				return false;
			}
			if(usr.length >20)
			{
			alert ("Username cannot be greater than 20 characters");
				obj.focus();
				return false;
			}
	//checking whether the username contains a special character
				for (var i = 1; i < usr.length; i++) 
				{
					var ch = usr.substring(i, i + 1);
					if ( ((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && (ch < "0" || "9" < ch) && (ch != '_')) 
					{
						alert("The User Name field  accepts only letters,numbers & underscore.\n\nPlease re-enter your User Name.");
						obj.focus();
						return false;
					}
				}
			   
			}
return true;
}
//######################################################################################################################################
//Function to check the password field
//######################################################################################################################################
function passwordcheck(obj)
{
	if(obj.value =="")
		{
			alert ("Please enter a Password");
			obj.focus();
			return false;
		}
		else
       {
			var pwd=obj.value;
			var ltr,i;

//checking whether the password field contain spaces			

			for (i=0;i<pwd.length;i++)
			{
			ltr = pwd.substring(i,i+1);

				if (ltr==' ')
				{
				alert("Invalid Password - Space not allowed ");
				obj.focus();
				return false;
				}
//checking the length of the password
				if (pwd.length<6)
				{
				alert("Enter minimum Six characters for the Password");
				obj.focus();
				return false;				
				}	
				if (pwd.length>20)
				{
				alert("Password not to exceed Twenty characters");
				obj.focus();
				return false;				
				}			   
		   }
		}
		
	return true;	   
}
//######################################################################################################################################

//######################################################################################################################################
//Function to check the confirm password and both the passwords are equal or not 
//######################################################################################################################################
function confirmpasswordcheck(obj,obj1)
 {
 if(obj.value =="")
		{
			alert ("Please enter Confirm Password");
			obj.focus();
			return false;
		}
		else
       {
			var cpwd=obj.value;
			var ltr,i;
			
//checking whether the confirm password field contain spaces				
			for (i=0;i<cpwd.length;i++)
			{
			ltr = cpwd.substring(i,i+1);

				if (ltr==' ')
				{
				alert("Invalid Confirm Password - Space not allowed\n \nThe Confirm Password and Password must be same ");
				obj.focus();
				return false;
				}
//checking the length of the confirm password			
				if (cpwd.length<6)
				{
				alert("Enter minimum Six characters for the Confirm Password\n \nThe Confirm Password and Password must be same ");
				obj.focus();
				return false;				
				}	
				if (cpwd.length>20)
				{
				alert("Password should not exceed Twenty characters");
				obj.focus();
				return false;				
				}		   
		   }
		}	
		//checking whether the password and confirm password is same
		if (obj1.value!=obj.value)
		{
			alert ("Password and Confirm Password are not matching. Please  re-enter");
			obj.focus();
			return false;
		}

	return true;
		}
 //#####################################################################################################################################
 
 //#####################################################################################################################################
 //Function to check wheather any of the field is empty
 //#####################################################################################################################################

 function emptycheck(obj,cmd)
  {
  
		trimValue = obj.value.trim() ;
		
   		if(trimValue =="")
		{
			alert ("Please enter " + cmd);
			obj.focus();
			return false;
		}
		//if(hasWhiteSpace(obj.value))
		//{
			//obj.focus();
			//return false;
		//}
			
		return true;
  }
  //----------------FUNCTION FOR CHECKING WHITE SPACE------------------
  
  function hasWhiteSpace(s) 
{
		//alert("coming");
		reWhiteSpace = new RegExp(/^\s+$/);
		// Check for white space
		if (reWhiteSpace.test(s)) {
			alert("Please Check Your Fields For Spaces");
			//obj.focus();
			return true;
		}
return true;
}	

  
  
  //------------------------------------------------
  function getFirstNameLenth(obj)
  {
 // alert("OKD");
   if(obj.value.length >50)
		{
			alert ( "First Name cannot be greater than Fifty");
			obj.focus();
			return false;
		}
		
		
		return true;
  }
  function getLastNameLenth(obj)
  {
 // alert("OKD");
   if(obj.value.length >50)
		{
			alert ( "Second  Name cannot be greater than Fifty");
			obj.focus();
			return false;
		}
		
		
		return true;
  }
  //-------------------------------
//#####################################################################################################################################

//#####################################################################################################################################
//Function to check the combobox value is selected or not 
//#####################################################################################################################################

function combocheck(obj,cmd,defaultvalue)
 {
  var f=defaultvalue;
  if(obj.value==f)
			{
				alert("Please select " +cmd)
				obj.focus();
				return false;
					} 
			return true;
 }
 //#####################################################################################################################################
 
 //#####################################################################################################################################
 //Function to check the Email 
 //#####################################################################################################################################
function emailcheck(obj)
{
  if(obj.value==""  )
		{
			alert ("Please enter E-mail  ");
			obj.focus();
			return false;
		}
		//-----------------------------
		//-------------------
		if(obj.value!="")
		{ 
			if(obj.value.indexOf('@')==-1 || obj.value.indexOf('.')==-1)
			{
			alert("Invalid E-Mail");
			obj.focus();
			return false;
			}
		var em=obj.value;
		if(em.length > 50  )
			{
			alert ("Invalid E-mail  ");
			obj.focus();
			return false;
		}

		var ltr,i,c=0;
		for (i=0;i<em.length;i++)
			{
			ltr = em.substring(i,i+1);
				if(ltr=='@')
					{
						c=c+1;
						lgth1=i;
						if(i<1)
							{
								alert("Invalid E-Mail,email address must not begin with '@'");
								obj.focus();
								return false;
						  }
						if(c>1)
							{	
									alert("Invalid E-Mail,Only one '@' is allowed");
									obj.focus();
									return false;
							}
				   }
			
					if(ltr=='.')
						{
							lgth2=i;
							if(i<1)
								{
									alert("Invalid E-Mail,email address must not begin with '.'");
									obj.focus();
									return false;
							   }
						}
				}
				
			if((lgth2-lgth1)<2)
					{	
						alert("Invalid E-Mail,There should be some domain name between '@' and '.'");
						obj.focus();
						return false;
					}
			
			if((em.length-lgth2)<=1)
					{	
						alert("Invalid E-Mail,No character detected after the '.'");
						obj.focus();
						return false;
					}	
				
		var em=obj.value	
		for (var i = 0; i < em.length; i++) 
			{
				
				var ch = em.substring(i, i + 1);
				if (ch == " ")
				 	{
						alert("Spaces not allowed.\n\nPlease re-enter your Email.");
						obj.focus();
						return false;
					}
						if ( ((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && (ch < "0" || "9" < ch) && (ch != '_') && (ch != '@') && (ch != '.') && (ch != '-')) 
							{
								alert("The Email field  does not accept special characters.\n\nPlease re-enter your Email.");
								obj.focus();
								return false;
							}
				
			}
		}
		
	return true;	
}
//######################################################################################################################################

//######################################################################################################################################
//Funcation to check the fullname field checking 
//######################################################################################################################################
///////*************** URL

function siteURL( obj) 
{
	if(obj.value!="")
	{
		if (obj.value == "" || obj.value.indexOf("http://",0) == -1 || obj.value.length >600 || obj.value.indexOf(".") == -1 ) 
		{
		alert( "Please provide a valid URL with less than six hundred characters");
		obj.focus();
		return false;
		} 
	}
	return true;
}


////////******************
///////*************** Name

function siteName( obj) 
{
	if(obj.value!="")
	{
		if (obj.value == "" || obj.value.length >50  ) 
			{
			alert( "Please provide a valid site name less than fifty characters");
			obj.focus();
			return false;
			} 
	}
		return true;
}
//-------------------------list
function getList( obj) 
{
			if(obj.value=="")
				{
		
				alert( "Please Enter a List name");
				obj.focus();
				return false;
			} 
	
		return true;
}
//---------------------

////////******************
function fullnamecheck(obj)
 {
 
 if(obj.value =="")
		{
			alert ("Please  enter your full name");
			obj.focus();
			return false;
		}	
		if(obj.value !="")
		{
			var cp = obj.value;

			for (i=0;i<cp.length;i++)
			{
			ltr = cp.substring(i,i+1);
			
			   if (ltr=="0" || ltr=="1" || ltr=="2" || ltr=="3" || ltr=="4" || ltr=="5" || ltr=="6" || ltr=="7" || ltr=="8" || ltr=="9")
				{
						alert("Invalid  name, numbers are not allowed");
						obj.focus();
						return false;
				}
			}
	    }
	return true;	
 }
 //#####################################################################################################################################
 
 //#####################################################################################################################################
 // Funcation to check  the URL
 //#####################################################################################################################################
  function urlcheck(obj)
   {
     if(obj.value=="")
		{ 
			alert("Please enter your web address");
			obj.focus();
			return false;
		}	
    if(obj.value!="")
		{ 
			
		var em=obj.value;
		var ltr,i,len,c=0;
		
		ltr = em.substring(0,4)
		len=em.length;
		entr=em.substring(len-4,len)
		/*if((entr==".com")||(entr==".com"))
				{
				
				} 
		else
				{
				alert ("Invalid url. Please enter the URL in the form www.name.com");
				obj.focus();
				return false;
				}  */
		if((ltr=="www.")||(ltr=="WWW."))
				{
				
				} 
		else
				{
				alert ("Invalid url. Please enter the URL in the form www.name.com");
				obj.focus();
				return false;
				}  
		
		}
    return true;
   }
  //####################################################################################################################################
  
  //####################################################################################################################################
  //Funcation to check the city name 
  //####################################################################################################################################
 function citycheck(obj,cmd)
   {
     if(obj.value =="")
		{
			alert ("Please enter the " + cmd +"  Name");
			obj.focus();
			return false;
		}
		
//checking whether the City first character is an alphabetic character
		   	var fn=obj.value;
			var ltr,i;

		   	if((fn.substring(0,1)<"a" || fn.substring(0,1)>"z") && (fn.substring(0,1)<"A" || fn.substring(0,1)>"Z"))
			{
				alert("The " + cmd +" name should begin with an alphabetic character.");
				obj.focus();
				return false;
			}

//checking whether the City contains a special character
			for (var i = 1; i < fn.length; i++) 
			{
				var ch = fn.substring(i, i + 1);
				if ( ((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && (ch < "0" || "9" < ch) && (ch != "'")&& (ch != " ")) 
				{
					alert("The " + cmd +"  name must contain only alphabetic characters. \n\nPlease re-enter your " + cmd +"  Name.");
					obj.focus();
					return false;
				}
			}
	for (i=0;i<fn.length;i++)
			{
			ltr = fn.substring(i,i+1);
//checking whether City name contains numeric characters

			   if (ltr=="0" || ltr=="1" || ltr=="2" || ltr=="3" || ltr=="4" || ltr=="5" || ltr=="6" || ltr=="7" || ltr=="8" || ltr=="9")
				{
						alert("Invalid " + cmd +"   name, numbers are not allowed");
						obj.focus();
						return false;
				}
			}
	return true;
   }  
//######################################################################################################################################

//######################################################################################################################################
//Funcation to Check the pin code or zip code
//######################################################################################################################################
function pincodecheck(obj)
 {
  if(obj.value!="")
		{
			
			var pin=obj.value;
			
						
			for (i=0;i<pin.length;i++)
			{
			ltr = pin.substring(i,i+1);
//checking whether the pincode entered is a number and whehter it contain spaces 
				if (isNaN(ltr) && ltr!=' ')
				{
				alert("Invalid Pincode");
				obj.focus();
				return false;
				}
		   }
//checking the length of the pincode		   
		   		if (pin.length > 7)
				{
				alert("Invalid Pincode-Total number of digits should be < 7 ");
				obj.focus();
				return false;
				}
		   
		}	
 return true;
 }   
 //#####################################################################################################################################
 
 //#####################################################################################################################################
 //Function to chek the phone number
 //#####################################################################################################################################
function phonecheck(obj,cmd)
{

//checking whether Phone 1 is null		 
		// if(obj.value =="")
		//{
			//alert ("Please enter the "+ cmd +" Number");
			//obj.focus();
			//return false;
		//} 

//checking whether the  phone number 1 is valid		

		if (obj.value!="")
		{
			var ph = obj.value;

				for (i=0;i<ph.length;i++)
				{
					ltr = ph.substring(i,i+1);

					if (isNaN(ltr)&& ltr!="+" && ltr !=" " && ltr !="-")
					{
						alert("Invalid  "+ cmd +"  Number. Please re-enter the "+ cmd +" number");
						obj.focus();
						return false;
					}
				}

//Checking the length of the phone number 1
		if(obj.value.length<4 || obj.value.length>25)
					{
						alert("This is not a valid "+ cmd +" Number");
						obj.focus();
						return false;
					}
		}		
return true;
}      
//######################################################################################################################################


//######################################################################################################################################
//Funcation to check the first name or last name
//#######################################################################################################################################
function namecheck(obj,cmd)
 {
 if(obj.value =="")
		{
			alert ("Please  enter your "+ cmd );
			obj.focus();
			return false;
		}	
		if(obj.value !="")
		{
var usr=obj.value;
				var ltr,i;
				for (i=0;i<usr.length;i++)
				{
				ltr = usr.substring(i,i+1);
	//checking whether there are spaces in the username
					if (ltr==' ')
					{
					alert("Invalid " + cmd + "- Space not allowed ");
					obj.focus();
					return false;
					}
			   }
			   var cp = obj.value;
for (i=0;i<cp.length;i++)
			{
			ltr = cp.substring(i,i+1);
			
			   if (ltr=="0" || ltr=="1" || ltr=="2" || ltr=="3" || ltr=="4" || ltr=="5" || ltr=="6" || ltr=="7" || ltr=="8" || ltr=="9")
				{
						alert("Invalid Contact Person name, numbers are not allowed");
						obj.focus();
						return false;
				}
			}
	    }
	return true;	
 }
 //####################################################################################################################################
 
//#####################################################################################################################################
// Function to check wheather the field contains only space as chatrecters
//#####################################################################################################################################
 
function spaceonlycheck(obj,cmd)
 {
  var usr=obj.value;
  var flagsp=0;
		  for (i=0;i<usr.length;i++)
			{
			var ltr = usr.substring(i,i+1);
		//checking whether there are spaces in the username
				if (ltr!=' ')
				{
				 flagsp=1;
				}
		   }
		  
     if(flagsp==0)
	  {
	   alert("invalid " + cmd + "formate");
	   	obj.focus();
	   return false;
	  }
	  return true;
 }
 //#####################################################################################################################################
 
//######################################################################################################################################
//Function for cahnging the space to '_'
//######################################################################################################################################
 
    function spacer(obj)
    {
      
      //checking whether the Profile contain spaces			
            var p=obj.value;
            var temp = new Array();
			for (i=0;i<p.length;i++)
			{
			  temp[i]=p.substring(i,i+1);
			
			}
			for (i=0;i<p.length;i++)
			{
			     if(temp[i]==" ")
			       {
			        temp[i]="_"; 
			       }                      
	       }
	       //obj.value="";
	       var str="";
	       for (i=0;i<temp.length;i++)
	        {
	         // if(temp[i]!=",")
	            {
	             str=str+temp[i];
	            }
	        }
	     
	       obj.value=str;
    
    }
 //#####################################################################################################################################
 
//######################################################################################################################################
//function to change the name first charachter to the capitals
//######################################################################################################################################
function changeCase(frmObj) {
//discombo();
var index;
var tmpStr;
var tmpChar;
var preString;
var postString;
var strlen;
tmpStr = frmObj.value;
//.toLowerCase();
strLen = tmpStr.length;
if (strLen > 0)  {
for (index = 0; index < strLen; index++)  {
if (index == 0)  {
tmpChar = tmpStr.substring(0,1).toUpperCase();
postString = tmpStr.substring(1,strLen);
tmpStr = tmpChar + postString;
}
else {
tmpChar = tmpStr.substring(index, index+1);
if (tmpChar == " " && index < (strLen-1))  {
tmpChar = tmpStr.substring(index+1, index+2).toUpperCase();
preString = tmpStr.substring(0, index+1);
postString = tmpStr.substring(index+2,strLen);
tmpStr = preString + tmpChar + postString;
         }
      }
   }
     
}
frmObj.value = tmpStr;
}
//######################################################################################################################################

//######################################################################################################################################
//Function to check wheather the date combination is correct or not
//######################################################################################################################################

function isDate(month,date,year)
{
	//var docF=document.frmreg
	var yy,mm,dd;
	var im,id,iy;
	var present_date = new Date();
	yy = 1900 + present_date.getFullYear();
	if (yy > 3000)
	{
		yy = yy - 1900;
	}
	mm = present_date.getMonth();
	dd = present_date.getDate();
	im = month.selectedIndex;
	id = date.selectedIndex;
	iy = year.selectedIndex;
	var entered_month = im;
	var invalid_month = im- 1; 
	var entered_day = eval(date.options[id].value); 
	var entered_year = eval(year.options[iy].value); 
	if ( is_greater_date(entered_year,entered_month,entered_day,yy,mm,dd) && is_valid_day(entered_month,entered_day,entered_year) )
	{
		return true; 
	}
	return false;
}
function is_greater_date(entered_year,entered_month,entered_day,yy,mm,dd)
{
//var docF=document.frmreg
	if (entered_year > yy)
	{
		alert("The Date of birth field is entered incorrectly. The year entered exceeds the current year.");
		year.focus();
		return false;
	}
	if (entered_year == yy)
	{
		if (entered_month > mm)
		{
			alert("The Date of birth field is entered incorrectly.");
			month.focus();
			return false;
		}
		if (entered_month == mm)
		{
			if (entered_day > dd)
			{
				alert("The Date of birth field is entered incorrectly.");
				date.focus();
				return false;
			}
		}
	}
	return true;
}
function is_valid_day(entered_month,entered_day,entered_year)
{
//var docF=document.frmreg
	if ((entered_year % 4) == 0) 
	{ 
		var days_in_month = "312931303130313130313031";
 	}
 	else 
	{ 
		var days_in_month = "312831303130313130313031";
 	} 
	var months = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	if (entered_month != "0")
	{
	emonth=entered_month
			if (entered_day > days_in_month.substring(2*emonth,2*emonth+2))
		{
			alert ("The Date of birth field is entered wrongly (the date field value exceeds the number of days for the month entered).");
			date.focus();
			return false;
		}
	}
	return true;
}		
//######################################################################################################################################

//######################################################################################################################################
//Function to check the pincode
//######################################################################################################################################

function pincheck(obj)
 {  var i,ltr;
			if(obj.value.length<5)
			{
				alert("Please Enter a Valid zip code")
				obj.focus();
				return false;
			} 
		 if(obj.value.length<5)
			{
				alert("Please Enter a Valid zip code")
				obj.focus();
				return false;
			} 
			
				for (i=0;i<obj.value.length;i++)
				{ 
					ltr = obj.value.substring(i,i+1);
					//checking whether the pincode entered is a number and whehter it contain spaces 
					if (isNaN(ltr) && ltr!=' ')
					{
						alert("Invalid Pincode");
						obj.focus();
						return false;
					}
				}
				
				//checking the length of the pincode		   
				if (obj.value.length > 7)
				{
					alert("Invalid Pincode-Total number of digits should be < 7 ");
					obj.focus();
					return false;
				}
  return true;
 }
 
 
 
 //#####################################################################################################################################

//######################################################################################################################################
//Function to check a integer value
//######################################################################################################################################
function isInteger(obj)
{
	/*if (isBlank(val))
	{
	return false;
	}*/
	for(var i=0;i<obj.value.length;i++)
	{
		ltr = obj.value.substring(i,i+1);
		if (isNaN(ltr) && ltr!=' ')
		{
		alert("Please enter a valid value");
		obj.focus();
		return false;
		}
		}
	return true;
	}
//#######################################################################################################################################
//######################################################################################################################################
// Function to check whether any selection is made in menu
//#######################################################################################################################################
	function menucheck(obj)
	{
	if(obj.selectedIndex==0)
	{
	alert("Please select an Item.");
	obj.focus();
	return false;
	}
	return true;
	}
//#######################################################################################################################################	
	function checkme() 
	{
	if (obj.checked)
	 {
		return true;
	}
	else
	{
	alert("Please accept the terms");
	obj.focus();
	return false;
	}
	}
	//######################################################################################################
	
	function IsEmpty(obj,cmd) { 
	 
	 if ((obj.value.length==0) ||(obj.value=="")) {  
	 		alert ("Please enter " + cmd);
			obj.focus();
	    	 return false;  
		  } 
	else{
		var usr=obj.value;
		var ltr,i;
		
		for (i=0;i<usr.length;i++)
			{
				ltr = usr.substring(i,i+3);
				//checking whether there are spaces in the username
				if (ltr==' ')
				{
				alert("Invalid name - Space not allowed ");
				obj.focus();
				return false;
				}
			}
			if(usr.length >100){
				alert("Characters are more than allowed");
				obj.focus();
				return false;
			}
	}
		   
return true;
			
		}

function cancel()
{
	window.history.back();
}
function fnvshobj(obj,Lay){
    var tagName = document.getElementById(Lay);
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
    var maxW = tagName.style.width;
    var widthM = maxW.substring(0,maxW.length-2);
    if(Lay == 'editdiv') 
    {
        leftSide = leftSide - 225;
        topSide = topSide - 125;
    }else if(Lay == 'transferdiv')
	{
		leftSide = leftSide - 10;
	        topSide = topSide;
	}
    var IE = document.all?true:false;
    if(IE)
   {
    if($("repposition1"))
    {
	if(topSide > 1200)
	{
		topSide = topSide-250;
	}
    }
   }
	
    var getVal = eval(leftSide) + eval(widthM);
    if(getVal  > document.body.clientWidth ){
        leftSide = eval(leftSide) - eval(widthM);
        tagName.style.left = leftSide + 34 + 'px';
    }
    else
        tagName.style.left= leftSide + 'px';
    tagName.style.top= topSide + 'px';
    tagName.style.display = 'block';
    tagName.style.visibility = "visible";
}

/////////////////////////Another set JS functin /////////////

var defaultEmptyOK = false
var reFloat = /^((\d+(\.\d*)?)|((\d*\.)?\d+))$/


// BOI, followed by one digit, followed by EOI.
var reDigit = /^\d/


function isEmptyFC(s)
{   return ((s == null) || (s.length == 0))
}

function isFloat (s)

{   if (isEmptyFC(s)) 
       if (isFloat.arguments.length == 1) return defaultEmptyOK;
       else return (isFloat.arguments[1] == true);

    return reFloat.test(s)
}

// Returns true if character c is a digit 
// (0 .. 9).

function isDigit (c)
{   return reDigit.test(c)
}

function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}


function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
