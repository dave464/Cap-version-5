<?php
require 'validate.php';
require '../connection.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lab Result</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../main.css">
        <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <link rel='stylesheet' href='https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css'>
    </head>
    <body >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
      <!-- Navbar-->
      <?php include 'navbar.php' ?>


      <p class="text-center h1 fw-bold mb-3 mx-1 mx-md-4 mt-4"  
      style="color:#004aad;text-shadow: 1px 1px #03a9f4;">LAB RESULT
      </p>

      
  <div class="container" > 
    <div class="table-responsive">
       <table class="table " >
  <thead class="table-dark">
  <tr>
    
        <th>Business Name</th>
        <th>Date</th>
        <th>File</th>
      </tr>
  </thead>
  <tbody>
  <?php  
     $query = $conn->query("SELECT inspection.inspection_id,inspection.date,inspection.file,merchant.business_name, merchant.merchant_id
              FROM merchant RIGHT JOIN inspection ON merchant.merchant_id = inspection.merchant_id WHERE  inspection.merchant_id = '".$_SESSION['merchant_id']."'") or die(mysqli_error());
              while($fetch = $query->fetch_array()){
 ?>

        <tr>  
            
            <td><?php echo $fetch['business_name']?></td>
            <td><?php echo date("M d, Y", strtotime($fetch['date']))?></td>
            <td><a href="../admin/file/<?php echo $fetch['file']?>"><?php echo $fetch['file']?></a></td>

           </tr> 

        <?php
            }
          ?>  
      

  </tbody>
</table>
</div>
</div>



<!-----------------------------------SCRIPTS-------------------------------------------->  
 <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
<script src='https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/1.11.4/api/sum().js'></script>

 
<script type = "text/javascript">
 
 var minDate, maxDate;
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[4] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);


  $(document).ready(function(){
     // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });

    // DataTables initialisation
  var table = $('#table').DataTable(
    {   
      pageLength: 10,
        lengthMenu: [[10, 20, 30, 40, 50 - 1], [10, 20, 30, 40, 50, 'all']],
       
        "columnDefs": [ {
            "searchable": false,

            "orderable": false,
           
            type:'title-string', targets: 0,
        } ],

        "dom": 'Blfrtip',
                "buttons": [  
                  
                  {  
                        extend: 'copy',  
                        className: 'btn btn-primary rounded-0',  
                        text: '<i class="far fa-file-excel"></i> Copy',
                        title:'Alpha Lab Test',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }  
                    }, 
                    {  
                        extend: 'excel',  
                        className: 'btn btn-primary rounded-0',  
                        text: '<i class="far fa-file-excel"></i> Excel',
                        title:'Alpha Lab Test',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }  
                    },  
                   
                    {  
                        extend: 'pdf',  
                        className: 'btn btn-primary rounded-0',  
                        text: '<i class="far fa-file-pdf"></i> Pdf',
                        title:'Alpha Lab Test',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }  
                    },  
                    
                    {  
                        extend: 'print',  
                        className: 'btn btn-primary rounded-0',  
                        text: '<i class="fas fa-print"></i> Print' ,
                        title:'Alpha Lab Test',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                            
                        } 
                    },
                   
                ]  ,

                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\₱,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
           /* total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ); */
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
              '&#8369;'+pageTotal +'.00'
               /* ' &#8369;'+pageTotal +' (  &#8369;'+ total +' total)'*/
            );
        }  
              
    }
  );

                // Refilter the table
              $('#min, #max').on('change', function () {
                table.draw();
                });

  });


</script> 


    </body>
</html>


<style>
  .container {
    background-color:#FFF;
  }
  td{
    //font-size: 10px;
    white-space: nowrap;
  }
  th {
    //font-size: 10px;
    white-space: nowrap;
  }
.select-container {
  display: flex;
  justify-content: center;
  align-items: center;
}
  .list {
    display: flex; 
    width: 100%;
    border:2px solid #000;
  }
  label {
    font-size: 12px;
  }
  .myButton {
  box-shadow:inset 0px 1px 0px 0px #fff6af;
  background:linear-gradient(to bottom,  #2196F3 5%, #0d6edf 100%);
  border-radius:6px;
  display:inline-block;
  cursor:pointer;
  color:#fff;
  font-family:Arial;
  font-size:15px;
  font-weight:bold;
  padding:6px 24px;
  text-decoration:none;
  border-color: #0d6edf;
  box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
}
.myButton:hover {
  background-color: $blue-500;
  background:linear-gradient(to bottom, #0d6edf 5%, #2196F3 100%);
}
h5 {
  width: 150px;
  color:#000;
  padding:20px 0px;
}
.myButton:active {
  position:relative;
  top:1px;
}
</style>