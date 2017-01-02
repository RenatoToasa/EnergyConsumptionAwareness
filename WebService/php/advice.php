<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_person = $obj['id_person'];;
$id_language = $obj['id_language'];;
//$id_person = 1;
//$id_language = 1;
//$user_key = "key";
if (strcmp ($user_key ,"key") == 0) {
	$json['items'] =[] ;
	$db = openConection();
	$result = $db->query("SELECT id_advice,advice,registration_date FROM tbl_advice Where id_language = '".$id_language."' AND 
		id_question_option IN 
		(SELECT id_question_option from tbl_answer_detail,tbl_answer WHERE  tbl_answer.id_answer = tbl_answer_detail.id_answer AND tbl_answer.id_person = '".$id_person."')");
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json['items'][]=$row;
	    }
	     $result->close();
	     $db->next_result();
	     echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();
}
?>
