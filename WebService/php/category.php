<?php
header('Content-Type: text/html; charset=UTF-8');
include ("../conection.php");
include ("../functions.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_language = $obj['id_language'];
//$id_language = "2";
//$user_key = "key";

if (strcmp($user_key ,"key") == 0) {
	$db = openConection();
	/*
	if (!exist_device($id_device)) {
		$id_person = register_device($id_device);
		if ($id_person!=0) {
			//$id_version = get_version_person($id_person);
		}
	}
	*/
	$result = $db->query("SELECT max(q.id_version) FROM tbl_question q, tbl_category c, tbl_version v where q.id_category = c.id_category and q.id_version=v.id_version and c.id_language= '".$id_language."'");
	if($result){
	   	$row = $result->fetch_row();
	      $id_version = $row[0];
	  }

	$result = $db->query("SELECT id_category,category,description,image,id_language FROM tbl_category WHERE id_language = '".$id_language."'");
	if($result){
	    while ($row = $result->fetch_object()){
	       $row->questions = question($row->id_category,$id_version,$id_language);
	       $json['items'][]=$row;
	    }
	     $result->close();
	     $db->next_result();
	     //register_device_version($id_person,$id_version);
	     echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();
}


function question($id_category,$id_version,$id_language) {
	$db = openConection();
	$json = [];
	$result = $db->query("SELECT id_question,question,points,id_question_type,id_version,active
	FROM tbl_question  WHERE id_category = '".$id_category."' AND id_version = '".$id_version."' AND ACTIVE = 1");
	if($result){
	    while ($row = $result->fetch_object()){
	    	if ($row->id_question_type != 1) {
	    		$row->question_options = question_option($row->id_question);
	    	}
	    	if ($row->id_question_type != 1 && $row->id_question_type != 2) {
	       		$row->cant_option_required = question_type($row->id_question_type);
	   		} else {
	   			$row->cant_option_required = 0;	
	   		}
	       $json[]=$row;
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);
	$db->close();	
	return $json;
}

function question_option($id_question){
	$db = openConection();
	$result = $db->query("SELECT id_question_option,tbl_question_option.option,id_type FROM tbl_question_option WHERE id_question = '".$id_question."'");
	if($result){
	    while ($row = $result->fetch_object()){
	      $json[]=$row;
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);
	$db->close();
	return $json;
}
function question_type($id_question_type){
	$db = openConection();
	$result = $db->query("SELECT cant_option_selection FROM tbl_question_type WHERE id_question_type = '".$id_question_type."'");
	if($result){
	    while ($row = $result->fetch_object()){
	      	$json=$row->cant_option_selection;
	    }
	     $result->close();
	     $db->next_result();
	}
	else echo($db->error);
	$db->close();
	return $json;
}
?>