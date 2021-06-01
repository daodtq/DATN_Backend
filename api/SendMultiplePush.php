<?php 
//importing required files 
require_once '../services/DbOperation.php';

require_once '../Firebase.php';
require_once '../entities/Push.php'; 

$db = new DbOperation();

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){	
	if(isset($_POST['title']) and isset($_POST['message'])) {
		$push = null; 
		if(isset($_POST['image'])){
			$push = new Push(
					$_POST['title'],
					$_POST['message'],
					$_POST['image']
				);
		}else{
			$push = new Push(
					$_POST['title'],
					$_POST['message'],
					null
				);
		}

		$mPushNotification = $push->getPush(); 

		$devicetoken = $db->getAllTokens();

		$firebase = new Firebase(); 

		echo $firebase->send($devicetoken, $mPushNotification);
	}else{
		$response['error']=true;
		$response['message']='Parameters missing';
	}
}else{
	$response['error']=true;
	$response['message']='Invalid request';
}

echo json_encode($response);