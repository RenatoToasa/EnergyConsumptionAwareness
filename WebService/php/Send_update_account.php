<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_person = $obj['id_person'];
$id_facebook = $obj['id_facebook'];
//$id_person = "121";
//$id_facebook = "128251369180902";
//$user_key ="key";
if (strcmp ($user_key ,"key") == 0) {
	$db = openConection();
	$id_new_person = 0;
	$update = 0;

	$result = $db->query("SELECT id_person FROM tbl_person WHERE idFacebook ='".$id_facebook."' and idFacebook <> ''");
	if($result){
	    while ($row = $result->fetch_object()){
	       	$id_new_person=$row->id_person;
	       	if($id_new_person != $id_person){
	       		$update=1;			
	       	}
	       	UpdateAccount($row->id_person);
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);

	$db = openConection();
	$result = $db->query("UPDATE tbl_person SET idFacebook ='".$id_facebook."' WHERE id_person = '".$id_person."'");
	if ($result) {
   		//mysqli_commit($db);
	} else echo($db->error);
	
	$db->close();
	
	$json = array();
	$json['items']["id_person"] = $id_new_person;
   		$json['items']['Info']=$update;
	echo json_encode($json,JSON_NUMERIC_CHECK);



}
function UpdateAccount($id_persona){
		$db2 = openConection();
		$result2 = $db2->query("UPDATE tbl_person SET idFacebook ='' WHERE id_person = '".$id_persona."'");
		if ($result2 === true) {
		}
		else echo($db2->error);
		if (!mysqli_commit($db2)) {
    		//print("Transaction commit failed\n");
    		//exit();
			}
		$db2->close();

	}
?>
