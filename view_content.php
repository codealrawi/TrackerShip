<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `mobile_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
            if(isset($id)){
                $field = [];
            $meta_qry = $conn->query("SELECT * FROM `mobile_meta` where mobile_id = '{$id}'");
            while($row = $meta_qry->fetch_assoc()){
                $field[$row['field_id']] = $row['meta_value'];
            }
            
        }
        
    }else{
        echo '<script> alert("Unknown Smart Phone\'s ID."); location.replace("./?page=mobiles"); </script>';
    }
}else{
    echo '<script> alert("Smart Phone\'s ID is required to access the page."); location.replace("./?page=mobiles"); </script>';
}
?>
<style>
    .view-image img{
        width:100%;
        height:10vh;
        object-fit:scale-down;
        object-position: center center;
    }
    .mapouter{position:relative;text-align:right;height:500px;width:100%;}
    .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}
</style>
<div class="container">
    <div class="content py-3">
        <div class="card card-outline card-primary rounded-0 shadow">
            <div class="card-header">
                <h4 class="card-title">Smart Phone Details</h4>
            </div>
            <div class="card-body">
                <div class="row gx-4 gx-lg-5 align-items-top">
                    <div class="col-md-6">
                        <img class="card-img-top mb-5 mb-md-0 border border-dark" loading="lazy" id="display-img" src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" alt="..." />
                        <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                            <div class="col">
                                <a href="javascript:void(0)" class="view-image active"><img src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                            </div>
                            <?php 
                            if(isset($id)):
                            if(is_dir(base_app."uploads/mobile_".$id)):
                            $fileO = scandir(base_app."uploads/mobile_".$id);
                                foreach($fileO as $k => $img):
                                    if(in_array($img,array('.','..')))
                                        continue;
                            ?>
                            <div class="col">
                                <a href="javascript:void(0)" class="view-image"><img src="<?php echo validate_image('uploads/mobile_'.$id.'/'.$img."?v=".strtotime($date_updated)) ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- <div class="small mb-1">SKU: BST-498</div> -->
                        <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo isset($model) ? $model : "" ?></h1>
                        <p class="m-0"><span class="text-muted">Brand: </span><div class="h4 font-weight-bolder w-auto"><?= isset($brand) ? $brand : "" ?></div></p>
                        <div>
                            <?= html_entity_decode($display_content) ?>
                        </div>
                    </div>
                </div>
                <hr>
                <?php 
                $categories = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 order by `order_by` asc");
                while($crow = $categories->fetch_assoc()):
                ?>
                <fieldset class="border-bottom border-gray">
                    <legend class="text-muted"><b><?= $crow['name'] ?></b></legend>
                    <div class="row">
                        <?php 
                        $field_qry = $conn->query("SELECT * FROM `field_list` where category_id = '{$crow['id']}' and delete_flag = 0 order by `order_by` asc");
                        while($frow = $field_qry->fetch_assoc()):
                        ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="field_id_<?= $frow['id'] ?>" class="control-label"><?= $frow['name'] ?> <small class="text-muted"><i class="fa fa-question-circle" title="<?= $frow['description'] ?>"></i></small></label>
                                    <div class="pl-2"><?php echo isset($field[$frow['id']]) ? $field[$frow['id']] : ''; ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </fieldset>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<script>

$(function(){
    $('.view-image').click(function(){
        var _img = $(this).find('img').attr('src');
        $('#display-img').attr('src',_img);
        $('.view-image').removeClass("active")
        $(this).addClass("active")
    })
    $('#delete_mobile').click(function(){
        _conf("Are you sure to delete this Real mobile permanently?","delete_mobile",[])
    })
})
function delete_mobile($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_mobile",
			method:"POST",
			data:{id: '<?= isset($id) ? $id : "" ?>'},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=mobile');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>