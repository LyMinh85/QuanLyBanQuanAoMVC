<div class="container-fluid" style="margin:0px">
    
    <div class="row">

        <form action="" method="get" class="col-md-2 list-group">

            <button type="button" class="btn btn-outline-primary" id="btnManageRole">ManageRole</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageGroupRole">ManageGroupRole</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageAccount">ManageAccount</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageCategory">ManageCategory</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageType">ManageType</button>
            <button type="submit" class="btn btn-outline-primary" id="btnManageProduct">ManageProduction</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageInvoice">ManageInvoice</button>
            <button type="button" class="btn btn-outline-primary" id="btnManageOrder">ManageOrder</button>

        </form>

        <div class="col" id="content">123</div>

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
    })

</script>