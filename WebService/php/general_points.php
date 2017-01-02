<?php
include ("../conection.php");
$obj = json_decode(file_get_contents("php://input"), true);
$user_key = $obj['key'];
$id_person = $obj['id_person'];;

//$id_person = 1;
//$user_key = "key";
if (strcmp ($user_key ,"key") == 0) {
	$db = openConection();
	$i = 0;
	$result = $db->query("SELECT p.name, p.image, p.id_person as inIdPerson,IFNULL( (select sum(points) from tbl_question
						WHERE id_question in (select id_question from tbl_answer
                    								WHERE id_person= inIdPerson)),0) as cant_points from tbl_person p 
                        order by cant_points DESC LIMIT 4");
	if($result){
	    while ($row = $result->fetch_object()){
	    	$i++;
	    	$row->id_person = $i;
	    	$row->inIdPerson = 0;
	       	$json['items'][]=$row;
	       	/*if ($row->inIdPerson != $id_person) {
	       		insertUser();
	       	}*/
	    }
	   
	     $result->close();
	     $db->next_result();
	     echo json_encode($json,JSON_NUMERIC_CHECK);
	}
	else echo($db->error);
	$db->close();


	function insertUser() {
		$result = $db->query("SELECT p.name, p.id_person as inIdPerson,IFNULL( (select sum(points) from tbl_question
						WHERE id_question in (select id_question from tbl_answer
                    								WHERE id_person= inIdPerson)),0) as points from tbl_person p 
                        order by points DESC");
	$i = 0 ;
	$positionUser = 0;
	if($result){
	    while ($row = $result->fetch_object()){
	    	$i++;
	    	if ($row->inIdPerson == $id_person) {
	    		$positionUser = $i;
	    		///echo $positionUser;
	    	}
	    }
	}

	    $result = $db->query("SELECT p.name, p.id_person as inIdPerson,IFNULL( (select sum(points) from tbl_question
						WHERE id_question in (select id_question from tbl_answer
                    								WHERE id_person= inIdPerson)),0) as points from tbl_person p WHERE p.id_person = '".$id_person."'");
	    if($result){
	    while ($row = $result->fetch_object()){
	    	$row->id_person = $positionUser;
	       	$json['items'][]=$row;
	    }
	}


	}

}
?>

