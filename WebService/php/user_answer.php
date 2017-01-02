<?php
include '../conection.php';
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
//$id_facebook = $obj['id_facebook'];
$id_person = $obj['id_person'];
$user_key = "key";
//$id_person = 109;

if (strcmp($user_key ,"key") == 0) {
	$json['items']['answer'] = array();
	$json['items']['never_answer'] = array();
	$db = openConection();
	$result = $db->query("SELECT tbl_answer.id_question,tbl_answer_detail.id_question_option FROM tbl_answer,tbl_answer_detail WHERE tbl_answer.id_answer = tbl_answer_detail.id_answer AND tbl_answer.id_person ='".$id_person."'");
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json['items']['answer'][]=$row;
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);
	
	$db = openConection();
	$result = $db->query("SELECT id_question FROM tbl_question_not_answer WHERE id_person = '".$id_person."'");
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json['items']['never_answer'][]=$row;
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);

	echo json_encode($json,JSON_NUMERIC_CHECK);
	$db->close();
}
?>