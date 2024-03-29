<?php 
include('config.php');
session_start();
$uid=$_SESSION['user']['user_id'];
date_default_timezone_set('Asia/Dhaka');
$date=date("Y-m-d");


$statement290 = $pdo->prepare("SELECT * FROM tbl_member WHERE user_id=?");
$statement290->execute(array($uid));
$result290 = $statement290->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result290 as $row290){
        $wcredit=$row290['credit'];
    }
$amount=$_POST['withdraw_amount']+10;

    $statement = "SELECT * FROM tbl_withdraw_limit ORDER BY id DESC LIMIT 1";
    $stmt =  $pdo->query($statement);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $min = $row['minimum_amount'];
    $max = $row['maximum_amount'];


if($amount >= $wcredit){
    echo json_encode(array("wstatues"=>"<div role='alert' class='alert alert-danger'>
                                <strong>Your withdraw amount is more than your balance!</strong>
                            </div>"));
}elseif($amount < $min){
    echo json_encode(array("wstatues"=>"<div role='alert' class='alert alert-danger'>
                                <strong>Your withdraw amount is less than " .$min. " your balance!</strong>
                                <p>Please enter more than " .$min. "</p>
                            </div>"));
}elseif ($amount > $max) {
    echo json_encode(array("wstatues"=>"<div role='alert' class='alert alert-danger'>
        <strong>Your withdraw amount is more than " .$max. " your balance!</strong>
        <p>Please enter less than " .$max. "</p>
    </div>"));
}

else{
	$state = $pdo->prepare("SELECT * FROM tbl_member WHERE user_id=?");
    $state->execute(array($uid));
    $results = $state->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
    	$credit = $row['credit'];
    }
    $final_amount = $credit-$_POST['withdraw_amount'];
    $statement = $pdo->prepare("UPDATE tbl_member SET credit=? WHERE user_id=?");
    $statement->execute(array($final_amount,$uid));
	$a="0";
	$statement = $pdo->prepare("INSERT INTO tbl_withdraw (request_by, amount, method, send_to, account_type, date, withdraw_status) VALUES (?,?,?,?,?,?,?)");
	$statement->execute(array($uid,$_POST['withdraw_amount'],$_POST['withdraw_method'],$_POST['withdraw_to'],$_POST['account_type'],$date,$a));
	echo json_encode(array("wstatues"=>"<div role='alert' class='alert alert-success'>
                                <strong>Your withdraw has been successfully requested!</strong>
                            </div>"));

}
?>