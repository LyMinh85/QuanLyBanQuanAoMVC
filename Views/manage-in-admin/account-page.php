<div class="container" style="text-align:center;">
    <?php   if($accounts !=null): ?>
        <h3> Sửa Account</h3>
    <?php else: ?>
        <h3>Thêm Account</h3>
    <?php endif; ?>
</div>
<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($accounts != null) ? $accounts->name : ""?>">
</div>

<div class="row">
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">UserName</label>
          <input type="gmail" class="" name="" id="user" aria-describedby="helpId" placeholder="UserName"
            value="<?php echo $retVal = ($accounts != null) ? $accounts->username : ""?>">
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">Email</label>
          <input type="text" class="" name="" id="email" aria-describedby="helpId" placeholder="Email"
            value="<?php echo $retVal = ($accounts != null) ? $accounts->email : ""?>">
        </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">PassWord </label>
          <input type="text" class="" name="" id="pass" aria-describedby="helpId" placeholder="Password"
            value="<?php echo $retVal = ($accounts != null) ? $accounts->password : ""?>">
        </div>
    </div>

    <div class="col">
        <div class="mb-3">
              <label for="" class="form-label">Gender</label>
              
                <select id="gender">
                    <option <?php if($accounts != null) echo $retVal = ($accounts->gender == "female") ? "selected" : ""?>>Female</option>
                    <option <?php if($accounts != null) echo $retVal = ($accounts->gender == "male") ? "selected" : ""?>>Male</option>
                    <option <?php if($accounts   != null) echo $retVal = ($accounts->gender == "unisex") ? "selected" : ""?>>Unisex</option>
                </select>

        </div>
    
    </div>
    </div>
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">Phone </label>
          <input type="text" class="" name="" id="phone" aria-describedby="helpId" placeholder="Phone"
            value="<?php echo $retVal = ($accounts != null) ? $accounts->phone : ""?>">
        </div>
     
    </div>
    <div class="col">
    <div class="mb-3">
          <label for="" class="form-label">BirthDay </label>
          <input type="text" class="" name="" id="birth" aria-describedby="helpId" placeholder="y-m-d"
            value="<?php echo $retVal = ($accounts != null) ? $accounts->birthday->format("Y-m-d") : ""?>">
        </div>
    </div>

    <div class="row">
    <div class="col">
    <div class="mb-3">
          <label for="" class="form-label">GroupRole </label>
          <input type="text" class="" name="" id="groles" aria-describedby="helpId" placeholder=""
            value="<?php echo $retVal = ($accounts != null) ? $accounts->id_group_roles : ""?>">
        </div>
    </div>
    </div>

    <div class="row">
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">Address</label>
          <textarea class="form-control" name="" id="address" cols="3" rows="3"><?php echo $retVal = ($accounts != null) ? $accounts->address : ''?></textarea>
          
        </div>
    
    </div>
    
</div>
   
        
<div class="row" style="text-align:center;">
    <?php if($accounts != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>



</div>
