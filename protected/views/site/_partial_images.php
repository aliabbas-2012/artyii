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
<div class="col-lg-12 col-md-12 col-sm-12 imgchanel">
    <div class="wrapper-box">



        <div class="wrapper-content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">

                </div>
            </div>
            <?php
            if (isset($models) && !empty($models) && count($models) > 0) {
                ?>

                <div>
                    <?php
                    for ($i = count($models) - 1; $i >= 0; $i--) {

                        $thumb_image = $models[$i]->cropped_img;
                        if (!empty($models[$i]->thumb_image)) {
                            $thumb_image = "thumbs/" . $models[$i]->thumb_image;
                        }
                        ?>
                        <div style="padding:15px;width:24%;float:left;">
                            <img alter="collage" style="width:170px;height:120px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/<?php echo $thumb_image; ?>"></td>
                            <br>
                            <!--<a class="scale_img" img_name="<?php echo $models[$i]->main_img; ?>" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">Scale |</a>-->
                            <a class="delete_img" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">Delete</a>
                            <!--<a style="display:none;" class="make_bg" img_name="<?php echo $models[$i]->main_img; ?>" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">| Background</a>-->
                            <!--<a class="edit_img" img_name="<?php echo $models[$i]->main_img; ?>" imgkey="<?php echo $models[$i]->img_key; ?>" style="color:red;" href="javascript://">| Crop</a>-->

                        </div>
                    <?php } ?>
                    <div style="clear: both;"></div>

                <?php } ?>
            </div>
            <div style="margin-top:20px;">

                <?php
                
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                ))
                ?>

            </div>
        </div>


    </div>
</div>