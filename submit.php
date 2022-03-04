<?php

require("class.phpmailer.php");

if( isset( $_POST['email'] ) ){
	$err_array = array();

	if( empty($_POST['mobile']) && empty($_POST['email']) && empty($_POST['name']) ){
		$err_array['mobile']= 'Enter mobile no!';
		$err_array['name']= 'Enter your name!';
		$err_array['email']= 'Enter your email!';
	}
	if( empty($_POST['mobile']) ){
		$err_array['mobile']= 'Enter mobile no!';
	}
	if( empty($_POST['name']) ){
		$err_array['name']= 'Enter your name!';
	}
	if( empty($_POST['email']) ){
		$err_array['email']= 'Enter your email!';
	}
	if( $_POST['mobile'] ){
		$mobileregex = "/^[6-9][0-9]{9}$/" ;  
		if( !preg_match($mobileregex, $_POST['mobile']) ){
			$err_array['mobile'] = "Enter valid 10-digit mobile number";
		}
	}
	if( !empty($_POST['email']) ){
		$email = $_POST["email"];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $err_array['email'] = "Enter valid email!";	
		}
	}
	if(!empty($err_array)){
		echo json_encode( $err_array ); die();	
	}
	
	$email = isset($_POST['email']) ? $_POST['email'] : '';  
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
	$message =isset($_POST['message']) ? $_POST['message'] : '';

	$mail = new PHPMailer();

	$mail->IsSMTP(); 
	                                     // set mailer to use SMTP
	$mail->Host = "134.119.190.82";  // specify main and backup server
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = "";  // SMTP username
	$mail->Password = ""; // SMTP password

	$mail->From = "";
	$mail->FromName = "Name here";
	$mail->AddAddress("person email here", "Name here");
	$mail->addReplyTo($email, $name);


	$mail->WordWrap = 50;                                 // set word wrap to 50 characters
	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	///$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
	$mail->IsHTML(true);                                  // set email format to HTML

	$mail->Subject = "Query From Contact From";
	$mail->Body = "Hi team,<br/><br/>You have received a new query from your website:<br/><br/><b>Name - </b>".$name."<br/><br/><b>Email - </b><a href='mailto:".$email."'>".$email."</a><br/><br/><b>Phone - </b>".$mobile."<br/><br/><b>Message - </b>".$message."<br><br/>Note: This query was submitted through the website: ";
	$mail->AltBody =date("Y-m-d H:i:s");

	if(!$mail->send()) {	
		    $array = array('err' => 'Something went wrong!');
		    echo json_encode(  ); die();
		} 
		else 
		{
		    $array = array('msg' => 'We have received your query, our team will respond you shortly.');
		    echo json_encode( $array ); die();
		}

}



?>
