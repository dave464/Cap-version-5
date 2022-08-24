<?php
include "connect.php";
	if(ISSET($_POST['add_criteria'])){
		$admin_id = $_POST['admin_id'];
		$criteria_id = $_POST['criteria_id'];	
		$c_name = $_POST['c_name'];

        
		
		$conn->query("INSERT INTO `criteria` (criteria_id,admin_id,c_name) VALUES('$criteria_id','$admin_id','$c_name')") or die(mysqli_error());
			echo
			"<script>
			alert('Data Added Successfully');
			document.location.href = 'criteria.php';
			</script>"
			;
		
	}


?>