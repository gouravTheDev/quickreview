<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({ 
			url: "/API/V1/?productList",
	        dataType:"html",
		    type: "post",
	        success: function(data){
	           var show = $('#productsShow');
    		   show.find("div").remove();
    		   show.append(data);
	        }
	    });
	    $('#region').change(function(){
	    	$.ajax({ 
				url: "/API/V1/?franchiseListFilter",
				data: { 
	              region: $("#region").val() 
	            },
		        dataType:"html",
			    type: "post",
		        success: function(data){
		           var show = $('#productsShow');
	    		   show.find("div").remove();
	    		   show.append(data);
		        }
		    });
	    });

	    $('#searchProduct').keypress(function(){
	    	var searchElem = $('#searchProduct').val();
	    	$.ajax({ 
				url: "/API/V1/?productSearch",
				data: { 
	              search: searchElem 
	            },
		        dataType:"html",
			    type: "post",
		        success: function(data){
		           var show = $('#productsShow');
	    		   show.find("div").remove();
	    		   show.append(data);
		        }
		    });
	    });
	});
</script>

<style type="text/css">
	.con{
		padding: 20px;
	}
</style>

<?php 
$link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
$link->set_charset("utf8");

if(mysqli_connect_error()){
	die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
}
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
$sql = "SELECT * FROM PRODUCT WHERE UNI_ID = '$id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$name = $row['PR_NAME'];
$price = $row['PRICE'];
$description = $row['DESCRIPTION'];
$category = $row['CATEGORY'];
$linkDe = $row['LINK'];
$review = $row['REVIEW'];
$imgName = $row['IMAGE'];
?>

<?php if($_SESSION['LoggedIn'] && $_SESSION['userAdmin']): ?>
<div class="container">
	<div class="row">
          <!-- left column -->
      <div class="col-md-12 ml-auto mr-auto">
        <!-- general form elements -->
        <div class="card con">
        	<h1 class="text-center"><?php echo $name ?></h1><hr>
          <div class="row">
          	<div class="col-lg-6 col-sm-12">
          	 	<?php echo '<img src="/CONTENT/UPLOADS/PRODUCT/'.$id.'/'.$imgName.'" height="100%" width="100%" alt="">'; ?>
          	</div>
          	<div class="col-lg-6 col-sm-12">
          		<h3 style="color: green"><?php echo "Rs:- ".$price ?></h3>
          		<h3>Link:- <?php echo $linkDe; ?></h3>
          		<h3>Category:- <?php echo $category; ?></h3>
          		<h4>Product Description:- <?php echo $description; ?></h4>
          	</div>
          </div>
      	</div>
      	<div class="card">
        	<div class="card-header"><h4>Reviews</h4></div>
        	<div class="card-body">
        		 <?php 
        		 	  $id = $_GET['id'];
                      $sql = "SELECT * FROM REVIEWS WHERE PRODUCT_ID = '$id' ORDER BY ID DESC";
                      $result = mysqli_query($link,$sql);
                      if ($result) {
                      	 if(mysqli_num_rows($result)>0){
	                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
	                          $uId = $row['USER_ID'];
	                          $uName = $row['USER_NAME'];
	                          $review = $row['REVIEW_DETAILS'];
	                          echo '<h4><b>'.$uName.' :-</b></h4>';
	                          echo '<h5>'.$review.'</h6>';
	                          echo '<hr>';
	                         }
	                      }else{
	                        echo '<div class="container"><div class="alert alert-warning">No review</div></div>';
	                      }
                      }else{
                      	echo "sdnj";
                      	echo mysqli_error($link);
                      }
                     

                ?>
        	</div>
      	</div>
      </div>
  	</div>
	
</div>

<?php endif; ?>