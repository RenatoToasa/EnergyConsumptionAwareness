<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_device = $obj['id_device'];
$token = $obj['token'];
$name = $obj['name'];
$image = $obj['image'];
//$id_language = $obj['id_language'];
//$user_key = "key";
if (strcmp ($user_key ,"key") == 0) {
	$registration_date=date("y/m/d H:i:s");
	$db = openConection();
	$result = $db->query("SELECT id_person FROM tbl_person WHERE idDevice ='".$id_device."' and idDevice<>'' ");//
	if($result){
	    while ($row = $result->fetch_object()){
	       	$json['items']['id_person']=$row->id_person;
	       	$json['items']['Info']=1;
			echo json_encode($json,JSON_NUMERIC_CHECK);
			exit();
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);




	$db = openConection();
	$result = $db->query("INSERT into tbl_person(name,registration_date,image,idDevice,token) VALUES('".$name."','".$registration_date."','".$image."','".$id_device."','".$token."')");
	$json = array();
	if ($result === true) {
   		$json['items']["id_person"] = $db->insert_id;
   		$json['items']['Info']=0;
   		echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();
}
?>
