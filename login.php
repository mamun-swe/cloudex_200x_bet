<?php
ob_start();
session_start();
include("config.php");
$_SESSION['login_error']='';

if(isset($_POST['form'])) {
        
    if(empty($_POST['user_name']) || empty($_POST['password'])) {
        $_SESSION['login_error'] = 'Email and/or Password can not be empty<br>';
    } else {
		
		$user_name = strip_tags($_POST['user_name']);
		$password = strip_tags($_POST['password']);

    	$statement = $pdo->prepare("SELECT * FROM tbl_member WHERE user_name=? AND status=?");
    	$statement->execute(array($user_name,'1'));
    	$total = $statement->rowCount();    
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
        if($total==0) {
            $_SESSION['login_error'] .= 'User Name does not match<br>';
        } else {       
            foreach($result as $row) { 
                $row_password = $row['password'];
            }
        
            if( $row_password != md5($password) ) {
                $_SESSION['login_error'] .= 'Password does not match<br>';
            } else {       
            
				$_SESSION['user'] = $row;
                header("location: index.php");
                unset($_SESSION['login_error']);
            }
        }
    }

    
}
?>