<?php
function exist_device($id_device) {
	$db = openConection();
	$result = $db->query("SELECT id_person
	FROM tbl_person  WHERE idDevice = '".$id_device."'");
	if($result){
	    while ($row = $result->fetch_object()){
	       return true;
	    }
	     $result->close();
	     $db->next_result();
	} else echo($db->error);
	$db->close();
	return false;
}
function register_device($id_device) {
	$db = openConection();
	$registration_date = date("y-m-d H:i:s");
	$result = $db->query("INSERT INTO tbl_person(registration_date,idDevice) VALUES ('".$registration_date."','".$id_device."')");
	$json;
	if ($result === TRUE) {
   		$json = $db->insert_id ;
	}
	else echo($db->error);
	$db->close();
	return $json;
}
function get_version_person($id_person) {
	$db = openConection();
	$id_version = 1;
	$result = $db->query("SELECT id_version FROM tbl_person_version WHERE id_person ='".$id_person."'");
	
	if($result){
	    while ($row = $result->fetch_object()){
	       $id_version = ($row->id_version);
	    }
	    $id_version +=1;
	     $result->close();
	     $db->next_result();
	} else echo($db->error);
	$db->close();
	
	return $id_version;	
}
function get_id_person($id_device) {
	$db = openConection();
	$id = 0;
	$result = $db->query("SELECT id_person FROM tbl_person WHERE idDevice ='".$id_device."'");
	if($result){
	    while ($row = $result->fetch_object()){
	       $id = ($row->id_person);
	    }
	     $result->close();
	     $db->next_result();
	} else echo($db->error);
	$db->close();
	return $id;	
}
function register_device_version($id_person,$id_version) {
	$db = openConection();
	$registration_date = date("y-m-d H:i:s");
	//$result = $db->query("INSERT INTO tbl_person_version(id_person,id_version,registration_date) VALUES ('".$id_person."','".$id_version."','".$registration_date."')");
	$result = $db->query("CALL proc_person_version_insert('".$id_person."','".$id_version."','".$registration_date."')");
	//$json = 0;
	if ($result === TRUE) {
   		//$json = $db->insert_id ;
	}
	else echo($db->error);
	$db->close();
	//return $json;	
}
?>
