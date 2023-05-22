<h1>INVOICE</h1>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Id_Account</th>
          <th scope="col">Id_Product</th>
          <th scope="col">Create_date</th>
          <th scope="col">Quantity</th>
          <th scope="col">Sumprice</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invoices as $value):?>       
          <tr>
          <td><?php  echo $value->id?></td>
          <td><?php echo $value->account->id_account?></td>
          <td><?php echo $value->product->id ?></td>
          <td><?php echo $value->createDate->format('d-m-Y') ?></td>
          <td><?php echo $value->quantity ?></td>
          <td><?php echo $value->sumPrice ?></td>
          </td>
          <tr>
        <?php endforeach;?>
      </tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
</script>

<script>
  $(document).ready(function(){
    $("#displayTable tbody").on('click',"tr",function(){
        var idInvoice = $(this).closest("tr").find("td:eq(0)").text();

        var url = "<?php echo Config::getUrl("/administrator/manage-invoice/invoice-page?id=")?>";
        url += idInvoice;

        $.ajax({
            url:url,
            success: function(result){
                $("#content").html(result);
            }
        })
    
    })
  })
</script>