<?php 
if(isset($_GET["sailId"])) {
  $sailId = $_GET['sailId'];
?>
<div class="modal fade" id="vehiclePrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vechicle Prices for <?php echo $sailId; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 

          include("../../classes/Tallink.class.php");
          $vehiclePrice = Tallink::fetch_vehicle_prices('en', 'fi', $sailId); 

          ?>  
        <table class="table table-responsive">
          <thead>
            <th>Category</th>
            <th style="white-space: nowrap;">License Plates</th>
            <th>Availability</th>
            <th>Price</th>
          </thead>
          <tbody>
        <?php 
        if($vehiclePrice != null) 
        {
          if(is_array($vehiclePrice) || is_object($vehiclePrice)) 
          {
                foreach($vehiclePrice as $row_vechicle)
                {
                    ?>
            <tr>
            <td><?php echo $row_vechicle["carCategory"]; ?></td>
            <td><?php echo $row_vechicle["licensePlates"]; ?></td>
            <td><?php echo $row_vechicle["outwardDetails"]['availability']; ?></td>
            <td><?php echo $row_vechicle["outwardDetails"]['price']; ?>€</td>
            </tr>
            <?php 
                } /* foreach($vehiclePrice as $row_vechicle) */
          } /* if(is_array($vehiclePrice) || is_object($vehiclePrice)) */
         } /* if($vehiclePrice != null) */
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
