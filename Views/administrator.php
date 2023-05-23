<div class="container-fluid" style="margin:0px">

    <button class="btn btn-outline-primary"><a href="<?php echo Config::getUrl("") ?>" style="text-decoration-line: none;">Home</a></button>

    <div class="row" style="text-align:center;">
        <h1>ADMIN PAGE</h1>
    </div>

    <div class="row" style="margin-top:10px;">

        <form action="" method="get" class="col-md-2 list-group">

            <?php if($_SESSION["user"]["id_group_role"] == 100): ?>
                <button type="button" class="btn btn-outline-primary" id="btnManageRole">ManageRole</button>
                <button type="button" class="btn btn-outline-primary" id="btnManageGroupRole">ManageGroupRole</button>
                <button type="button" class="btn btn-outline-primary" id="btnManageAccount">ManageAccount</button>
                <button type="button" class="btn btn-outline-primary" id="btnManageCategory">ManageCategory</button>
                <button type="button" class="btn btn-outline-primary" id="btnManageType">ManageType</button>
            <?php endif; ?>

            <?php foreach ($roles as $value):?> 
                <?php if($value->name_role == "ManageProduction"): ?>
                    <button type="submit" class="btn btn-outline-primary" id="btnManageProduct">ManageProduction</button>
                <?php endif; ?>
                
                <?php if($value->name_role == "ManageInvoice"): ?>
                    <button type="button" class="btn btn-outline-primary" id="btnManageInvoice">ManageInvoice</button>
                <?php endif; ?>

                <?php if($value->name_role == "ManageOrder"): ?>
                    <button type="button" class="btn btn-outline-primary" id="btnManageOrder">ManageOrder</button>
                <?php endif; ?>

            <?php endforeach; ?>

        </form>

        <div class="col" id="content"></div>

    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
</script>

<script>

    $(document).ready(function(){

        $("#btnManageProduct").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl('/administrator/manage-products') ?>",
                success:function(result){
                    $("#content").html(result);
                }
            })
        })

        $("#btnManageRole").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-roles")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })
        $("#btnManageCategory").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-category")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })
        $("#btnManageType").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-type")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })

        $("#btnManageInvoice").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-invoice")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })

        $("#btnManageGroupRole").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-grouprole")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })
        $("#btnManageAccount").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-account")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })
        $("#btnManageOrder").click(function(e){
            e.preventDefault();

            $.ajax({
                url:"<?php echo Config::getUrl("/administrator/manage-order")?>",
                success:function(result){
                    console.log(result);    
                    $("#content").html(result);
                }
            })
        })
    })

</script>