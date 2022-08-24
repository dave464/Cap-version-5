
<?php

//fetch.php

include('connect.php');

if(isset($_POST["year"]))
{
 $query = "
 SELECT * FROM merchant
 WHERE year = '".$_POST["year"]."' 
 ORDER BY id ASC
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'month'   => $row["barangay"],
   'profit'  => floatval($row["merchant_id"])
  );
 }
 echo json_encode($output);
}

?>
