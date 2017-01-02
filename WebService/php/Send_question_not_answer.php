<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_question = $obj['id_question'];
$id_person = $obj['id_person'];
$registration_date=date("y/m/d H:i:s");

//$id_person= "1";

if (strcmp ($user_key ,"key") == 0) {
	$db = openConection();
	$exist = false;
	$result = $db->query("SELECT id_question_not_answer FROM tbl_question_not_answer  WHERE id_question = '".$id_question."' AND id_person = '".$id_person."'");
	if($result){
	    while ($row = $result->fetch_object()){
	    	$exist = true;
	    }
	     $result->close();
	     $db->next_result();
	}
	if ($exist == true) {
		exit();
	}
	
	$result = $db->query("INSERT into tbl_question_not_answer(id_question,registration_date,id_person) VALUES('".$id_question."','".$registration_date."','".$id_person."')");
	$json = array();
	if ($result === true) {
		$id_question_not_answer = $db->insert_id;
   		$json['items']["id_question_not_answer"] = $id_question_not_answer;
   		echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();
}
?>