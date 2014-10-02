<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        width: 100%;
        border-collapse: collapse;
    }

    #customers td, #customers th {
        font-size: 1em;
        border: 1px solid #CCC;
        padding: 3px 7px 2px 7px;
    }

    #customers th {
        font-size: 1.1em;
        text-align: left;
        padding-top: 5px;
        padding-bottom: 4px;
        background-color: #e0005f;
        color: #ffffff;
    }

    #customers tr.alt td {
        color: #000000;
        background-color: #e0005f;
    }
</style>




<div style="padding:20px;text-align: center;" id="pageTitle">

</div>




<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">

    </div>
</div>
<?php if (isset($modelsbg) && !empty($modelsbg) && count($modelsbg) > 0) { ?>

    <div id="customers" class="table table-bordered" style="width:100%;">

        <div>
            <?php for ($i = 0; $i < count($modelsbg); $i++) { ?>

                <div style="padding:10px;width:20%;float:left;">
                    <?php
                        $thumb_image = $modelsbg[$i]->cropped_img;
                        if(!empty($modelsbg[$i]->thumb_image)){
                            $thumb_image = "thumbs/".$modelsbg[$i]->thumb_image;;
                        }
                        
                    ?>
                    <img alter="collage" style="width:180px;height:120px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/<?php echo $thumb_image ; ?>">
                    <br>
                    <?php if ($modelsbg[$i]->project_key != 'XXX') { ?>
                        <a class="delete_img" imgkey="<?php echo $modelsbg[$i]->img_key; ?>" style="color:red;" href="javascript://">Delete</a>
                        <a class="edit_img" img_name="<?php echo $modelsbg[$i]->main_img; ?>" imgkey="<?php echo $modelsbg[$i]->img_key; ?>" style="color:red;" href="javascript://">| Edit</a>
                        <a class="make_bg" img_name="<?php echo $modelsbg[$i]->main_img; ?>" imgkey="<?php echo $modelsbg[$i]->img_key; ?>" style="color:red;" href="javascript://">| Use As Background</a>
                    <?php } else { ?>
                        <a class="make_bg" img_name="<?php echo $modelsbg[$i]->main_img; ?>" imgkey="<?php echo $modelsbg[$i]->img_key; ?>" style="color:red;" href="javascript://">Use As Background</a>
                    <?php } ?>
                </div>



            <?php } ?>
        </div>
        <div style="clear: both;"></div>
    </div>

<?php } ?>
<div style="clear: both;"></div>
<div style="margin-top:20px;">

    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pages,
    ))
    ?>

</div>