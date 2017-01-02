<?PHP
include ("../conection.php");
$id_person = 1;
$id_user = 1;
$send = 1;
$id_person=$_POST['id_person'];
$id_language=$_POST['id_language'];
$id_question=$_POST['id_question'];
$id_question_option=$_POST['id_question_option'];
$advice=$_POST['advice'];
$registration_date=date("y/m/d H:i:s");
$query_search  ="SELECT  token FROM tbl_person WHERE  id_person = '".$id_person."'";
$db = openConection();
	$result = $db->query($query_search);
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json=$row;
	    }
	     $result->close();
	     $db->next_result();
	     echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();

$db = openConection();
	$result = $db->query("INSERT into tbl_advice(advice,send,registration_date,id_user,id_question,id_language,id_question_option) 
		VALUES('".$advice."','".$send."','".$registration_date."','".$id_user."','".$id_question."','".$id_language."','".$id_question_option."')");
	$json = array();
	if ($result === true) {
		$id_advice = $db->insert_id;
	}
	else echo($db->error);
	$db->close();

?>