<?php
require("connection.php");
session_start();

// var_dump($_POST);
// die();

if (isset($_POST['action']) and $_POST['action'] == "makePost")
{
$query ="INSERT INTO notes(title, description, created_at) VALUES('{$_POST['title']}','{$_POST['note']}', now())";

$insert_query= mysql_query($query);

$last_record = fetch_record("SELECT * FROM notes ORDER BY id DESC LIMIT 1");

$data['last_record'] = $last_record;

echo json_encode($data);
}



elseif(isset($_POST['action']) and $_POST['action'] == "deletePost")
{

$delete_id = $_POST['delete'];

$delete_query = "DELETE FROM notes WHERE id = '{$delete_id}'";
mysql_query($delete_query);

$deleted_record = fetch_record("SELECT * FROM notes WHERE id = '{$delete_id}'");

$data['delete_record'] = $deleted_record;

echo json_encode($data);

}

else if(isset($_POST['action']) and $_POST['action'] == "editPost")
{
$edit_query = "UPDATE notes SET title='{$_POST['title']}', description='{$_POST['note']}', updated_at=now() WHERE id = '{$_POST['id']}'";
mysql_query($edit_query);

$updated_record = fetch_record("SELECT * FROM notes WHERE id ='{$_POST['id']}'");

$data['edit_record'] = $updated_record;

echo json_encode($data);
}

else{
	echo "WTF you do?";
}




//add a hidden field on every button. Do an if/ele if with isset to test each button

?>

