<?php
require("connection.php");
session_start(); 

?>
<!doctype html>
<html lang="en">

<head>
<title>Notes for 71 Thomas Ave.</title>
<meta charset="utf-8" />
<link href="style.css" rel="stylesheet" type="text/css">
<link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular"rel="stylesheet" type="text/css">  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/foundation.css">




<script type="text/javascript">
		$(document).ready(function(){

			$("#makePost").on("submit", function(){
				var form = $(this);
				$.post(form.attr("action"), form.serialize(), function(data){

					console.log(data);

					var html = 
					'<div class="postBox"><h1>' + data.last_record.title + '</h1>'+
						data.last_record.description + 
						'<p class="time">Post Time: ' + data.last_record.created_at + '</p>'+
					'<form class="deletePost" action="process.php" method="post">'+
						'<input type="hidden" name="action" value="deletePost">'+
						'<input type="image" class="right delete" src="delete-icon.png">'+
						'<input type="hidden" name="delete" value="' + data.last_record.id + '">'+
					'</form>'+
					'<form class="editPost">'+
						'<input type="hidden" name="action" value="editPost">'+
						'<img name="edit" class="edit right" id="' + data.last_record.id + '" src="edit-icon.png">'+
					'</form>'+
					'</div>';

					$("#all_posts").append(html);

				}, "json");
				return false;
			});


			$(document).on("submit", ".deletePost", function(){
				var form = $(this);
				$.post(form.attr("action"), form.serialize(), function(data){

					console.log(data);
					$(form.parent()).remove();

				}, "json");
				return false;
			});


			$(document).on("submit", ".editPost", function(){

				var form = $(this);

				$.post(form.attr("action"), form.serialize(), function(data){

					console.log(data);

				var html = 
					'<div class="postBox">'+
						'<h1>' + data.edit_record.title + '</h1>'+
						data.edit_record.description + 
						'<p class="time">Post Time: ' + data.edit_record.created_at + '</p>'+
						'<form class="deletePost" action="process.php" method="post">'+
							'<input type="hidden" name="action" value="deletePost">'+
							'<input type="image" class="right delete" src="delete-icon.png">'+
							'<input type="hidden" name="delete" value="' + data.edit_record.id + '">'+
						'</form>'+
						'<form class="editPost">'+
							'<input type="hidden" name="action" value="editPost">'+
							'<img name="edit" class="edit right" id="' + data.edit_record.id + '" src="edit-icon.png">'+
						'</form></div>';

				$(form.parent()).replaceWith(html);

				}, "json");
				return false;
			});


		$(document).on("click", ".edit", function(){

		var id = ($(this).attr("id"));

		var html = 
			'<div class="postBox">' +
			'<form class="editPost" action="process.php" method="POST">' +
				'Title: <input name="title" type="text"><br>' +
				'<input name="action" type="hidden" value="editPost">' +
				'<input type="hidden" name="id"  value="' + id + '">' +
				'<textarea name="note" rows="6"></textarea>' +
				'<input type="submit" value="Edit Post">' +
			'</div>';

		$(this).parent().parent().replaceWith(html);
			
			 });

		});

	</script>
</head>

<body>
<div id="wrapper">
<h1  class="heading">Notes for 71 Thomas Ave.</h1>
<div id="all_posts">

<?php

  //get all posts and time from db
  $query = "SELECT id, title, description, created_at FROM notes";

  $notes = fetch_all($query);
  
	foreach ($notes as $note){


		echo '<div id ="'. $note["id"] . '" class="postBox">
				<h1>' . $note["title"] . '</h1>'
				 . $note["description"] . '
				<p class="time">Post Time: "' . $note["created_at"] . '"</p>
				<form class="deletePost" action="process.php" method="post">
					<input type="hidden" name="action" value="deletePost">
					<input type="image" class="right delete" src="delete-icon.png">
					<input type="hidden" name="delete" value="' . $note["id"] . '"></form>
				<form class="editPost">
				<input type="hidden" name="action" value="editPost">
					<img class="right edit pointer" name="edit" id="' .$note["id"] . '" src="edit-icon.png">
				</form></div>';
	}
?>

</div>
<div class="clear"></div>

<div class="container">
<h2>Add a note:</h2>
<form id="makePost" action="process.php" method="POST">
	Title:&nbsp; <input name="title" type="text"><br>Note: <textarea name="note" rows="4"></textarea>
	<input name="action" type="hidden" value="makePost">
	<input type="submit" value="post it">
</form>
<p class="sig">By: David L. Ethier, 2013</p>
</div>

</div>
</body>
</html>
