
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
    .mob-img{
        width:100%;
        max-height:20vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<?php
extract($_GET);
$qry = $conn->query("SELECT * from `cargo_list` where ref_code = '{$ref_code}' ");
if($qry->num_rows > 0){
    foreach($qry->fetch_assoc() as $k => $v){
        $$k=$v;
    }
}
?>
<section class="py-0">
    <div class="container">
        <div class="col-lg-12 py-2">
            
            <div class="container px-4 px-lg-5 mt-5">
               <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <?php if(isset($id)): ?>
                        <h4><span class="text-muted">Shipment tracking code :</span> <b><?= isset($ref_code) ? $ref_code : "" ?></b></h4>
                        <div id="history" class="border-left border-3 pl-3">
                            <?php 
                            $tracks = $conn->query("SELECT * FROM `tracking_list` where cargo_id = '{$id}' order by unix_timestamp(date_added) desc");
                            while($row = $tracks->fetch_assoc()):
                            ?>
                            <div class="card card-default shadow rounded-0">
                                <div class="card-header py-1">
                                    <h5 class="card-title"><b><?= $row['title'] ?></b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="card-text"><?= $row['description'] ?></div>
                                    <div class="clear-fix"></div>
                                    <div class="text-right"><small class="text-muted"><em><?= date("F d, Y h:i A", strtotime($row['date_added'])) ?></em></small></div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php else: ?>
                            <h4 class="text-ceter"><em>Код отправления неверен или неизвестен, пожалуйста, проверьте код!</em></h4>
                        <?php endif; ?>
                    </div>
               </div>

            </div>
    </div>
    </div>
</section>