<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h4>Infor Product</h4>
        </div>

        <div class="col">
            <h4>Infor Invoice</h4>
        </div>

        <div class="col">
            <h4>Infor Employee</h4>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="" class="form-label">Id: <?php echo $product->id ?></label>
        </div>

        <div class="col">
            <label for="" class="form-label">Id: <?php echo $invoice->id ?></label>
        </div>

        <div class="col">
            <label for="" class="form-label">Id: <?php echo $account->id_account ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="" class="form-label">Name: <?php echo $product->name ?></label>
        </div>

        <div class="col">
            <label for="" class="form-label">Create date: <?php echo $invoice->createDate->format('d-m-Y') ?></label>
        </div>

        <div class="col">
            <label for="" class="form-label">Name: <?php echo $account->name ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="" class="form-label">Price (unit): <?php echo $product->price ?>vnđ</label>
        </div>

        <div class="col">
        </div>

        <div class="col">
        </div>
    </div>

    <div class="row">
        <table class="table table-hover" id="displayTable">
            <thead>
                <tr>
                  <th scope="col">Color</th>
                  <th scope="col">Size</th>
                  <th scope="col">Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($productVariant as $value):?>       
                  <tr>
                    <td><?php echo $value->color?></td>
                    <td><?php echo $value->size->value?></td>
                    <td><?php echo $value->quantity ?></td>
                  </td>
                  <tr>
                <?php endforeach;?>

                  <tr>
                    <td style="font-weight:bold;">SumQuantity</td>
                    <td></td>
                    <td><?php echo $invoice->quantity?></td>
                  </td>

                  <tr>
                    <td style="font-weight:bold;">Total(price x SumQuantity)</td>
                    <td></td>
                    <td><?php echo $invoice->sumPrice?>vnđ</td>
                  </td>
              </tbody>
        </table>
    </div>
</div>