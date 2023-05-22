<div class="container" style="text-align:center;">
    <?php   if($orders !=null): ?>
        <h3> Sửa Order</h3>
    <?php else: ?>
        <h3>Thêm Order</h3>
    <?php endif; ?>
</div>
<div class="row">
<div class="col">
    <div class="mb-3">
    <label for="" class="form-label">Id_Order</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->id_order : ""?>">
    </div>
</div>
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Id_Account</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->id_account : ""?>">
    </div>
</div>
</div>
<div class="row">
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Status</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->status : ""?>">
    </div>
</div>
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Address</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->address : ""?>">
    </div>
</div>
</div>
<div class="row">
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Create_Date</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->create_date->format('Y-m-d') : ""?>">
    </div>
</div>
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Receviec_Date</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->receive_date->format('Y-m-d') : ""?>">
    </div>
</div>
</div>
<div class="row">
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">Payment</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->method_of_payment : ""?>">
    </div>
</div>
<div class="col">   
    <div class="mb-3">
    <label for="" class="form-label">SUM_price</label>
    <input type="text"
        class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
            value="<?php echo $retVal = ($orders != null) ? $orders->sum_price : ""?>">
    </div>
</div>
</div>
<div class="row" style="text-align:center;">
    <?php if($orders != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>



</div>