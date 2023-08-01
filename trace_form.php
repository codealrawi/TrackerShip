
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
    .mob-img{
        width:50px;
        height:100px;
        object-fit:scale-down;
        object-position:center center;
    }
    .mob-img-selected{
        width:50px;
        height:65px;
        object-fit:scale-down;
        object-position:center center;
    }
    span.select2-selection.select2-selection--single {
        height: auto !important;
    }
    span.select2-selection__arrow {
        top: 20% !important;
    }
</style>
<?php 
?>
<section class="py-0">
    <div class="container">
        <div class="col-lg-12 py-2">
           
            <div class="container px-4 px-lg-5 mt-5">
                <form action="" id="trace-frm">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-body">
                            <fieldset>
                                <legend>Поиск отправлений по трек-номеру ☑</legend>
                                <div class="row align-items-end">
                                    <div class="form-group col-md-6">
                                        <label for="mobile1" class="control-label">Трек-номер отправления 👇</label>
                                        <input type="text" class="form-control form-control-lg rounded-0" name="ref_code" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-default bg-gradient-primary btn-flat btn-lg text-light w-50">Го!</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
                <div class="clear-fix mb-3"></div>

            </div>
    </div>
    </div>
</section>
<script>
    $(function(){
        
        $('#trace-frm').submit(function(e){
            e.preventDefault();
            location.href="./?p=trace&"+$(this).serialize();
        })
    })

</script>