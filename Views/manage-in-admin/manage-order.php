<div class="container" style="text-align:center;">
    <h5>Manage Order</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Id_Account</th>
          <th scope="col">Address</th>
          <th scope="col">create_day</th>
          <th scope="col">receive_day</th>
          <th scope="col">method_of_payment</th>
          <th scope="col">sum_price</th>
          <th scope="col">status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order):?>       
          <tr>
          <td><?php echo $order->id_order ?></td>
          <td><?php echo $order->id_account ?></td>
          <td><?php echo $order->address ?></td>
          <td><?php echo $order->create_date->format('Y-m-d') ?></td>
          <td><?php echo $order->receive_date->format('Y-m-d')?></td>
          <td><?php echo $order->method_of_payment ?></td>
          <td><?php echo $order->sum_price ?></td>
          <td><?php echo $order->status ?></td>
          <td><button type="button" class="btn btn-warning buttonEdit">Edit</button>
          </td>
          <tr>
        <?php endforeach;?>
      </tbody>
</table>
<div class="container" style="text-align:center;" method="post">
  <button id="Add" class="btn btn-outline-primary" value="AddGroupRole" name="function">Add</button> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
        </script>
<script>
  $(document).ready(function(){
    $("#Add").click(function(){
      $.ajax({
        url:"administrator/manage-order/order-page?id=-1",
        success: function(result){
          $("#content").html(result);
        }
      })
    })
    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      $.ajax({
        url:"administrator/manage-order/order-page?id="+id,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
})
</script>