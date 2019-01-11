<?php 
if(isset($_GET["sailId"])) {
  $sailId = $_GET['sailId'];
?>
<div class="modal fade" id="landServices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Land Services for <?php echo $sailId; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 

          include("../../classes/Tallink.class.php");
          $fetch_land_services = new Tallink();
            $fetch_land_services->locale = 'en'; /* locale */
            $fetch_land_services->country = ''; /* country */
            $fetch_land_services->outwardSailId = $sailId; /* outwardSailId */
          $fetch_land_services = Tallink::fetch_land_services($fetch_land_services); 

          ?>  
        <table class="table table-responsive">
          <thead>
            <th>Title</th>
            <th style="white-space: nowrap;">Image</th>
            <th>Description</th>
            <th>Starting</th>
            <th>Ending</th>
            <th>Availability</th>
            <th>Price</th>
            <th>ClubOnePrice</th>
          </thead>
          <tbody>
        <?php 
        if($fetch_land_services != null) 
        {
          if(is_array($fetch_land_services) || is_object($fetch_land_services)) 
          {
                foreach($fetch_land_services as $row_service)
                {
                    ?>
            <tr>
            <td><?php echo $row_service["title"]; ?></td>
            <td><img height="64" src="<?php echo $row_service["imageUrl"]; ?>"></td>
            <td><?php echo $row_service["description"]; ?></td>
            <td><?php foreach($row_service["eventTimes"] as $eventful) { echo $eventful['dateTime'];  ?></td>
            <td><?php echo $eventful['endDateTime'];  ?></td>
            <td><?php echo $eventful['hasPlaces'];  ?></td>
            <td><?php echo $eventful['price'];  ?>€</td>
            <td><?php echo $eventful['clubAccountPrice']; } ?>€</td>
            </tr>
            <?php 
                } /* foreach($fetch_land_services as $row_service) */
            } /* if(is_array($fetch_land_services) || is_object($fetch_land_services))  */
         } /* if($fetch_land_services != null) */
            
            ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } /* if(isset($_GET["sailId"])) */ ?>
