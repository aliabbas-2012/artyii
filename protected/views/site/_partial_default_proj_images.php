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

                <div>
                    <?php
                    $defaultImages = array('blwh.jpg', 'feathered.png', 'hd.jpg', 'sepia.jpg');
                    for ($i = 0; $i < sizeof($defaultImages); $i++) { ?>
                        <div style="padding:15px;width:24%;float:left;">
                            <img alter="collage" style="width:170px;height:120px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/<?php echo $defaultImages[$i]; ?>">
                        </div>
                    <?php } ?>
                    <div style="clear: both;"></div>

                    </div>
           
            </div>


        </div>
    </div>