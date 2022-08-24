
<?php  

//index.php

include("connect.php");


       
?>  
<!DOCTYPE html>  
<html>  
    <head>  
        <title>Create Dynamic Column Chart using PHP Ajax with Google Charts</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    </head>  
    <body> 

       
                      


                 


                      <!--  <?php  
                                  

                                $query = $conn->query("SELECT AVG(rating) as Rate ,
                                            merchant.merchant_id, merchant.business_name, product_rating.rate_id,product_rating.rating 
                                 FROM product_rating 
                                 LEFT JOIN merchant on product_rating.merchant_id= merchant.merchant_id
                                 GROUP BY merchant.business_name ORDER BY AVG(rating) DESC

                                                 ") or die(mysqli_error());

                                                 while($fetch = $query->fetch_array()){

                                              

                                              ?>
                                          
                                          <p>
                                                <?php echo $fetch['business_name']?> 
                                                <?php echo $fetch['Rate']?> 
                                          </p>      
                                               
                                           
                                             <?php
                                                }
                                              ?>-->


<?php  
                                  

                                $query = $conn->query("SELECT AVG(rating) as Rate ,
                                            merchant.merchant_id, merchant.business_name, product_rating.rate_id,product_rating.rating 
                                 FROM product_rating 
                                 LEFT JOIN merchant on product_rating.merchant_id= merchant.merchant_id
                                 GROUP BY merchant.business_name ORDER BY AVG(rating) DESC

                                                 ") or die(mysqli_error());

                                                 while($fetch = $query->fetch_array()){

                                              

                                              ?>
                                          
                                          <p>
                                                <?php echo $fetch['business_name']?> 
                                                <?php echo $fetch['Rate']?> 
                                          </p>      
                                               
                                           
                                             <?php
                                                }
                                              ?>



<script type="text/javascript">
    
    function submitform() {

        document.getElementById("cform").submit();
        var s= document.getElementById("ss").value;

        alert(s);

    }

    var button =document.getElementById("cform");
    setInterval(function(){
        button.cform()
    },1)

</script>


<form method="post" action="" id="cform">
    
    <input type="hidden" name="n" id="ss" value="lala"> 

</form>

<div onclick="submitform()" id="w"> Accc</div>