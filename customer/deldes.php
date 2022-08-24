<?php 
require 'validate.php';
require_once '../connection.php';



  
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Delivery Destination</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="index.css" />
</head>
<body style='border:0; margin: 0'>
       <div id="map" class="map"></div>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
     <script src="../dist/leaflet-routing-machine.js"></script>
    <script src="Control.Geocoder.js"></script>


 <?php
         


            $query = $conn->query("SELECT product.product_id,product.image,product.product_name,product.product_type,
            product.price, product.merchant_id,orderlist.status, orderlist.order_id,orderlist.quantity,
            orderlist.total, orderlist.type, orderlist.photo,orderlist.date, merchant.business_name,merchant.merchant_id
            ,customer.firstname, customer.lastname, customer.address, customer.contact_number,customer.customer_id,customer.c_latitude,customer.c_longitude ,deliveryman.d_longitude,deliveryman.d_latitude
            FROM `orderlist`
            RIGHT JOIN product ON orderlist.product_id = product.product_id
            RIGHT JOIN merchant ON orderlist.merchant_id = merchant.merchant_id
            RIGHT JOIN customer ON orderlist.customer_id = customer.customer_id
             RIGHT JOIN deliveryman ON orderlist.deliveryman_id = deliveryman.deliveryman_id
             WHERE orderlist.order_id = '".$_REQUEST['order_id']."'") or die(mysqli_error());
            while($fetch = $query->fetch_array()){  

             $del_lati=$fetch['d_latitude']; 
             $del_long=$fetch['d_longitude']; 
          ?>  

            <input type="hidden" value="<?php echo $fetch['product_id']?>" name="product_id">
            <input type="hidden" value="<?php echo $fetch['merchant_id']?>" name="merchant_id">
            <input type="hidden" value="<?php echo $fetch['customer_id']?>" name="customer_id">
            <input type="hidden" value="<?php echo $fetch['quantity']?>" name="quantity">
            <input type="hidden" value="<?php echo $fetch['quantity'] * $fetch['price']?>" name="total">
            <input type="hidden" value="<?php echo $fetch['order_id']?>" name="order_id">
 <input type="hidden" value="<?php echo $fetch['deliveryman_id']?>" name="deliveryman_id">


<input type="hidden" value="<?php echo $fetch['product_id']?>" name="product_id">
          <input type="hidden" value="<?php echo $_SESSION['customer_id']?>" name="customer_id">
          <input type="hidden" value="<?php echo $fetch['merchant_id']?>" name="merchant_id">

<!--<div class="formBlock">
    <form id="form">-->
           <input type="hidden" name="c_latitude" class="input"  value="<?php echo $fetch['c_latitude']?>" id="c_latitude" ><br>
     <input type="hidden" name="c_longitude" class="input"  value="<?php echo $fetch['c_longitude']?>" id="c_longitude" ><br>

        <input type="hidden" name="d_latitude" class="input"  value="<?php echo $fetch['d_latitude']?>" id="d_latitude" ><br>
     <input type="hidden" name="d_longitude" class="input"  value="<?php echo $fetch['d_longitude']?>" id="d_longitude" ><br>

    <!--</form>
</div>-->

     <?php if($del_lati== null && $del_long ==null) {
                

  echo ("<script>
    alert('The deliveryman is not in your way');
    document.location.href = 'dispatched_order_details.php?order_id=".$fetch['order_id']."';
    </script>");

              } ?>
             

        </div>
 




           <?php
        }
        ?>

    


    
<script type="text/javascript">
 var map = L.map('map');
const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const tileLayer = L.tileLayer(tileUrl,{
 maxZoom: 21 ,
 attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\''
});
tileLayer.addTo(map);


function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  //x.innerHTML = "Latitude: " + position.coords.latitude + 


    let latti = document.getElementById("d_latitude").value; 
    let longi = document.getElementById("d_longitude").value;

    let latti2= document.getElementById("c_latitude").value;
    let longi2= document.getElementById("c_longitude").value;

    
    var control = L.Routing.control({
    waypoints: [
        L.latLng(latti,longi),
        L.latLng(latti2, longi2)
    ],
    
    routeWhileDragging: true,
    reverseWaypoints: true,
    showAlternatives: true,
    altLineOptions: {
        styles: [
            {color: 'black', opacity: 0.15, weight: 9},
            {color: 'white', opacity: 0.8, weight: 6},
            {color: 'blue', opacity: 0.5, weight: 2}
        ]
    },

createMarker: function (i, waypoint, n) {


let urlIcon;

if(i==0){
    urlIcon=('../img/marker.png');

}
else if((i+1)==n){
    urlIcon=('end.png');

}
else{
    urlIcon=('foot.png');

}

            const marker = L.marker(waypoint.latLng, {
              
              bounceOnAdd: false,
              bounceOnAddOptions: {
                duration: 1000,
                height: 800,
                function() {
                  (bindPopup(myPopup).openOn(map))
                }
              },
              icon: L.icon({
                iconUrl: urlIcon,
                iconSize: [35, 35]
              })
            });
            return marker;
          

}


}).addTo(map);

L.Routing.errorControl(control).addTo(map);
}

getLocation();

</script>


<!--<style type="text/css">
 .formBlock {
    max-width: 60px;
    background-color: #FFF;
    border: 1px solid #ddd;
    position: absolute;
    top: 90px;
    left: 5px;
    padding: 8px;
    z-index: 999;
    box-shadow: 0 1px 5px rgba(0,0,0,0.65);
    border-radius: 5px;
    width: 100%;
}


.input { 
    width: 100%;
    border: 1px solid #ddd;
    font-size: 15px;
    border-radius: 3px;
}

#form {
    padding: 0;
    margin: 0;
}
input:nth-child(1) {
    margin-bottom: 10px;
}
</style>-->


</body>
</html>