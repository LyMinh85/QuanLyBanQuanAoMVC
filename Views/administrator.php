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
                url:'administrator/manage-products',
                success:function(result){
                    $("#content").html(result);
                }
            })
        })



    })

</script>