<?php
	 require_once 'connect.php';
	 $conn->query("DELETE FROM `criteria` WHERE `criteria_id` = '$_REQUEST[criteria_id]'") or die(mysqli_error());
	

	 echo ("<script>
	alert('Delete Successfully');
	document.location.href = 'criteria.php';
	</script>");