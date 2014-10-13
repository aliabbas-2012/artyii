<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/colorbox/colorbox.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/colorbox/jquery.colorbox.js"></script>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/js/jquery.Jcrop.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/js/jquery.color.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/css/jquery.Jcrop.css" type="text/css" />


<link   href="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/fineuploader.css?v=2" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/header.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/util.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/button.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/handler.base.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/handler.form.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/handler.xhr.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/uploader.basic.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/dnd.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/uploader.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/js/jquery-plugin.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/cdn/js/jquery.ui-contextmenu.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/cdn/js/collage.js"></script>
<script type="text/javascript">
    var size_update_url = '<?php echo $this->createUrl('/upload/updateResize'); ?>';
    $(document).ready(function() {
        loaddefaultprojectimages();
        collage.element_tob_rotate = "#lighttable img";
        collage.start_set_pos = true;

        //collage.resizableCollage();
        collage.initPhotos();
        collage.contexteMenu();
    });
    function loaddefaultprojectimages() {
        $.post('<?php echo $this->createUrl('/site/loaddefaultimages'); ?>', {
            send: 'ok',
            ukey: ukey
        }, function(data) {

            if (data) {
                $('.defaultprojectimages').html(data.dataset);
            }
        }, "json");
    }

    var scalew = 0;
    var scaleh = 0;
    var image_id = 0;
    var background_upload = 1;
    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';
    var newimage = '';
    var imgkey = '';
    var ukey = '<?php echo $_GET["ukey"]; ?>';
    var imgpos = 5;
    $(document).ready(function() {
        //loadprojectimages();

        var fileuploadedname = '';
    });
    function loadprojectimages() {
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/loadimages', {
            newimage: newimage,
            ukey: ukey,
            imgpos: imgpos
        }, function(data) {
            console.log(data);
            if (data) {
                $('.imgblock').html(data.dataset);
            }
            if (data.message != '') {
                background_upload = 0;
            } else {
                background_upload = 1;
            }
            $("#saveit").removeAttr('disabled', 'disabled');
            newimage = '';
        }, "json");
    }
    function deleteimages() {
        $("#saveit").removeAttr('disabled', true);
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/deleteimage', {
            imgkey: imgkey,
            ukey: ukey
        }, function(data) {

            if (data) {
                $('.imgblock').html(data.dataset);
            }
            if (data.message != '') {
                background_upload = 0;
            } else {
                background_upload = 1;
            }
            $("#saveit").removeAttr('disabled', true);
            newimage = '';
        }, "json");
    }
    function make_background() {

        $("#saveit").removeAttr('disabled', 'disabled');
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/makebackground', {
            imgkey: imgkey,
            ukey: ukey
        }, function(data) {
            $('.imgblock').html(data.dataset);
            $("#saveit").removeAttr('disabled', 'disabled');
            newimage = '';
            loadprojectimages();
        });
    }

    function cropimage() {
        var cuimagekey = $('#cuimagekey').val();
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/cropimg', {
            imgkey: cuimagekey,
            ukey: ukey,
            x: g_x,
            y: g_y,
            w: g_w,
            h: g_h,
        }, function(data) {

            if (data) {
                $('.imgblock').html(data);
            }
            $("#savecrop").removeAttr('disabled', true);
            newimage = '';
            $.colorbox.close();
        });
    }
image_id
    function scaleimage() {
        var cuimagekey = $('#cuimagekey').val();
        $.post('<?php echo $this->createUrl("/upload/updateResize"); ?>', {
            imgkey: cuimagekey,
            id: image_id,
            ukey: ukey,
            width: scalew,
            height: scaleh
        }, function(data) {

            if (data) {
                $('.imgblock').html(data);
            }
            $("#savescale").removeAttr('disabled', true);
            newimage = '';
            $.colorbox.close();
            alert("Image has been resized ,to see effect refreshing window");
            document.location.reload();
        });
    }
    $(function() {
        $('.make_bg').click(function(e) {

            imgkey = $(this).attr('imgkey');
            var r = confirm("WARNING: Image will be used as background image. Are you agree?");
            if (r == true)
            {

                make_background();
            }
            else
            {

            }

            e.stopImmediatePropagation();
        });
        $('.delete_img').click(function(e) {

            imgkey = $(this).attr('imgkey');
            var r = confirm("WARNING: Image will be deleted. Are you sure you want to delete this image?");
            if (r == true)
            {

                deleteimages();
            }
            else
            {

            }

            e.stopImmediatePropagation();
        });
        $('#savecrop').click(function(e) {
            $("#savecrop").attr('disabled', 'disabled');
            g_x = $('#x').val();
            g_y = $('#y').val();
            g_w = $('#w').val();
            g_h = $('#h').val();
            if (g_x > 0 || g_y > 0 || g_w > 0 || g_h > 0) {

            } else {
                $("#savecrop").removeAttr('disabled', true);
                alert("WARNING: You must have to crop to save the image.");
                return false;
            }
            var r = confirm("WARNING: Image will be cropped. Are you sure you want to crop this image?");
            if (r == true)
            {
                cropimage();
            }
            else
            {
                $("#savecrop").removeAttr('disabled', 'disabled');
            }

            e.stopImmediatePropagation();
        });
        $('#savescale').click(function(e) {
            $("#savescale").attr('disabled', 'disabled');
            if (scalew > 0 || scaleh > 0) {

            } else {
                $("#savescale").removeAttr('disabled', true);
                alert("WARNING: You must have to scale to save the image.");
                return false;
            }
            var r = confirm("WARNING: Image will be scaled. Are you sure you want to scale this image?");
            if (r == true)
            {

                scaleimage();
            }
            else
            {
                $("#savescale").removeAttr('disabled', 'disabled');
            }

            e.stopImmediatePropagation();
        });

    })


    var xxx = 1;
    var jcrop_api;
    var _icropimgkey = '';
    var g_x = '';
    var g_y = '';
    var g_w = '';
    var g_h = '';
    var orw = 0;
    var orh = 0;
    $(document).ready(function() {
        $('.edit_img').click(function(e) {
            $('#x').val('');
            $('#y').val('');
            $('#w').val('');
            $('#h').val('');
            $("#savecrop").removeAttr('disabled', 'disabled');
            _thisfileName = $(this).attr('img_name');
            _icropimgkey = $(this).attr('imgkey');
            image_id = $(this).attr('c-id');
            
            $("#cuimagekey").val(_icropimgkey);
            $('.display_avatar').attr('src', tempImagePath + _thisfileName);
            $.colorbox({
                height: "auto",
                width: "auto",
                inline: true,
                href: "#inline_content",
                onComplete: function() {
                    uimagekey = _thisfileName;
                    $('.display_avatar').Jcrop({
                        bgColor: 'black',
                        bgOpacity: .4,
                        setSelect: [100, 100, 50, 50],
                        onSelect: updateCoords
                    }, function() {

                        jcrop_api = this;
                    });
                },
                onClosed: function() {
                    jcrop_api.destroy();
                }
            });
            e.stopImmediatePropagation();
        });
        $('.scale_img').click(function(e) {

            //$( ".display_avatar_scale" ).resizable( "destroy" );
            //$('.display_avatar_scale').attr( "style", "" );
            //$('.ui-wrapper').attr( "style", "" );
            //$('.ui-wrapper').css( "width", orw);
            //$('.ui-wrapper').css( "height", orh );
            
            c_width = $(this).attr("c-width");
            c_height = $(this).attr("c-height");
            
            $('.display_avatar_scale').css("height",c_height);
            $('.display_avatar_scale').css("width",c_width);

            scalew = 0;
            scaleh = 0;
            image_id = $(this).attr('c-id');
            _thisfileName = $(this).attr('img_name');
            _icropimgkey = $(this).attr('imgkey');
            $("#cuimagekey").val(_icropimgkey);
            $('.display_avatar_scale img').attr('src', tempImagePath + _thisfileName);
            $.colorbox({
                height: "auto",
                width: "auto",
                inline: true,
                href: "#inline_scale_content",
                onComplete: function() {

                    $(".display_avatar_scale").resizable({stop: function(event, ui) {
                            //console.log(ui.size.width);
                            scalew = ui.size.width;
                            scaleh = ui.size.height;
                            orw = ui.originalSize.width;
                            orh = ui.originalSize.height;
                        }}

                    );
                },
                onClosed: function() {
                    scalew = 0;
                    scaleh = 0;
                    location.reload();
                    //$( ".display_avatar_scale" ).resizable( "destroy" );
                }
            });
            e.stopImmediatePropagation();
        });
    });
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }


    function set_storage_items(id, pos, update) {

        var exists_img = localStorage.getItem(id);
        if (!exists_img || update) {

            localStorage.setItem(id, JSON.stringify(pos));
        } else {

            var pos = JSON.parse(localStorage.getItem(id));
        }
        //console.log(id);
        //console.log(pos);
        return pos;
    }



    var ukey = '<?php echo $_GET["ukey"]; ?>';
    var total = '<?php echo count($imgmodel); ?>';
    function printDiv()
    {//console.log($("#notesText").html()); 
        var note = $("#notesText").html();
        if (total <= 0) {
            alert('Please upload at least one image to proceed on. Otherwise refresh the page to recount your uploaded image.');
            return false;
        } else {
            html2canvas([document.getElementById('lighttable')], {
                useCORS: true,
                onrendered: function(canvas)
                {
                    var img = canvas.toDataURL('image/png');
                    $.post('<?php echo BASE_URL; ?>/' + "site/saveimg", {data: img, ukey: ukey, notes: note}, function(file) {
                        if (file != '') {
                            localStorage.clear();
                            window.location.href = '<?php echo BASE_URL; ?>/' + "site/success/?ukey=" + ukey
                        }

                    });
                }
            });
        }
    }

    function getValueNotes() {
        $("#notesText").html($("#notes").val());
    }
    $(function() {
        $("#backit").click(function() {
            window.location.href = '<?php echo BASE_URL; ?>/' + "site/upload/?ukey=" + ukey
        });
        $("#saveit").click(function() {
            printDiv();
        });

    })


</script>


<div id="pageTitle" style="text-align: center;">
    <h2 class="thick-title page-title-bar">Project - <?php echo $model->name; ?></h2>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="wrapper-box">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div style="text-align:center;"><span class="step"><b style="font-size:30px;">Step 4</b></span> <span class="headingname">Create Your Collage</span></div>
                        <br>
                        <!--                        <div style="text-align: center;color:red;font-weight: bold;">
                                                    *     To crop image, click the image below and use crop tool.<br>
                                                    **    To rotate image, just make shift + hold click to rotate the image.<br>
                                                </div>-->
                        <br>

                        <div id="wooden-table">
                            <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>
                                <img  style="z-index: 90000;" src="<?php echo BASE_URL; ?>/collage/<?php echo $result_bg['cropped_img']; ?>" alt="Wooden table image" />
                            <?php } else { ?>
                                <img style="z-index: 90000;" src="<?php echo BASE_URL; ?>/images/light.jpg" alt="Wooden table image" />
                            <?php } ?>

                        </div>

                        <div id="gameSection" style="padding-top:0px;">
                            <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>
                                <div id="lighttable"  class="change_<?php echo $result_bg['img_key']; ?> cropped_image_full"
                                     style="background-size: 100% 100%, auto; background-repeat-x: no-repeat;
                                     background-repeat-y: no-repeat;
                                     background: #eee url(<?php echo BASE_URL; ?>/collage/<?php echo $result_bg['cropped_img']; ?>);">
                                 <?php } else { ?>
                                    <div id="lighttable" style="background: #eee url(<?php echo BASE_URL; ?>/images/light.jpg);">
                                    <?php } ?>
                                    <?php if (isset($imgmodel) && !empty($imgmodel) && count($imgmodel) > 0) { ?>

                                    <?php } else { ?>
                                        <div style="text-align: center;padding:20px;margin-top:100px;color:red;font-size:20px;font-weight:bold;background: white;"> You must have to upload at least one collage image which is not used as background image to proceed on. Please upload image.</div>
                                    <?php } ?>

                                    <?php
                                    if (isset($imgmodel) && !empty($imgmodel) && count($imgmodel) > 0) {
                                        for ($i = 0; $i < count($imgmodel); $i++) {
                                            $src = BASE_URL . "/collage/" . $imgmodel[$i]->cropped_img;
                                            $htmlOptions = array(
                                                "alt" => $imgmodel[$i]->id,
                                                "img_name" => $imgmodel[$i]->main_img,
                                                "imgkey" => $imgmodel[$i]->img_key,
                                                "id" => "change_" . $imgmodel[$i]->img_key,
                                                'angle' => $imgmodel[$i]->angle,
                                                'c-width' => $imgmodel[$i]->width,
                                                'c-height' => $imgmodel[$i]->height,
                                                'c-left' => $imgmodel[$i]->left,
                                                'c-top' => $imgmodel[$i]->top,
                                            );
                                            // echo CHtml::openTag("div", array("class" => "update"));
                                            ?>
                                            <?php
                                            echo CHtml::image($src, $imgmodel[$i]->id, $htmlOptions);
                                            ?>
                                            <div class="ui-resizable-handle ui-resizable-nw" id="nwgrip"></div>
                                            <div class="ui-resizable-handle ui-resizable-ne" id="negrip"></div>
                                            <div class="ui-resizable-handle ui-resizable-sw" id="swgrip"></div>
                                            <div class="ui-resizable-handle ui-resizable-se" id="segrip"></div>

                                            <?php
                                            //echo CHtml::closeTag("div");
                                        }
                                    }
                                    ?>

                                </div>
                                <div style="width:100%;margin-top:60px;">

                                    <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>
                                        <?php
                                        $thumb_bg_image = $result_bg['cropped_img'];
                                        if (!empty($result_bg['thumb_image'])) {
                                            $thumb_bg_image = "thumbs/" . $result_bg['thumb_image'];
                                        }
                                        ?>
                                        <div style="width:25%;float:left;">

                                            <div style="color:white; padding:20px;background:#0396e3;border: 5px solid #CCC">
                                                BACKGROUND IMAGE
                                            </div>
                                            <div style="border: 5px solid #fff;padding:10px;">
                                                <img class="<?php
                                                if ($result_bg['project_key'] != "XXX") {
                                                    echo "edit_img";
                                                } else {
                                                    echo "not_edit_img";
                                                }
                                                ?>" background="yes" 
                                                     cropped_image="<?php echo $result_bg['cropped_img']; ?>"
                                                     img_name="<?php echo $result_bg['main_img']; ?>" imgkey="<?php echo $result_bg['img_key']; ?>" style="cursor:pointer; width: 192px;height: 200px;" src="<?php echo BASE_URL; ?>/collage/<?php echo $thumb_bg_image; ?>" alt="alt" />
                                            </div>
                                        </div>


                                    <?php } else { ?>

                                    <?php } ?>

                                    <?php
//load model images here
                                    if (isset($imgmodel) && !empty($imgmodel) && count($imgmodel) > 0) {
                                        for ($i = 0; $i < count($imgmodel); $i++) {
                                            $thumb_image = $imgmodel[$i]->main_img;
                                            if (!empty($imgmodel[$i]->thumb_image)) {
                                                $thumb_image = "thumbs/" . $imgmodel[$i]->thumb_image;
                                            }
                                            ?>  

                                            <div style="width:25%;float:left;">
                                                <div style="color:white; padding:20px;background:#0396e3;border: 5px solid #CCC">
                                                    IMAGE <?php echo $i + 1; ?>
                                                </div>
                                                <div style="border: 5px solid #fff;padding:10px;">
                                                    <img background="no" class="edit_img" cropped_image="<?php echo $imgmodel[$i]->cropped_img; ?>" img_name="<?php echo $thumb_image; ?>" imgkey="<?php echo $imgmodel[$i]->img_key; ?>" style="cursor:pointer; width: 192px;height: 200px;" src="<?php echo BASE_URL; ?>/collage/<?php echo $thumb_image; ?>" alt="alt" />
                                                    <br>
                                                    <a id="scale_<?php echo $imgmodel[$i]->id ?>" class="scale_img" 
                                                       img_name="<?php echo $imgmodel[$i]->main_img; ?>" 
                                                       imgkey="<?php echo $imgmodel[$i]->img_key; ?>" 
                                                       c-width ="<?php echo $imgmodel[$i]->width; ?>"
                                                       c-height ="<?php echo $imgmodel[$i]->height; ?>"
                                                       c-id ="<?php echo $imgmodel[$i]->id; ?>"
                                                       style="color:red;" href="javascript://">Scale |</a>
                                                    <a  c-id ="<?php echo $imgmodel[$i]->id; ?>" 
                                                        id="crop_<?php echo $imgmodel[$i]->id ?>" class="edit_img" cropped_image="<?php echo $imgmodel[$i]->cropped_img; ?>" img_name="<?php echo $imgmodel[$i]->main_img; ?>" imgkey="<?php echo $imgmodel[$i]->img_key; ?>" style="color:red;" href="javascript://"> Crop</a>


                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                </div>
                                <div style="clear: both;"></div>
                                <div class="defaultprojectimages"></div>
                                <div class="content" style="font-size: 20px; margin-bottom: 14px;">
                                    If you would like to add any of these effects, please send emily a note when you submit your collage.
                                </div>
                                <div>
                                    <textarea onblur="getValueNotes()" class="form-control field span12" id="notes" cols="176" rows="7" placeholder="Enter notes"></textarea>
                                    <span id="notesText" style="display: none;"></span>
                                </div>
                                <div style="padding:20px;text-align: center;">
                                    <button style="cursor:pointer;" class="btn btn-success" id="backit" type="button">Back</button> &nbsp;&nbsp;&nbsp;
                                    <?php if (isset($imgmodel) && !empty($imgmodel) && count($imgmodel) > 0) { ?>
                                        <button style="cursor:pointer;" class="btn btn-success" id="saveit" type="button">Submit</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';
        var imbackground = false;
        function cropimage() {

            var cuimagekey = $('#cuimagekey').val();
            $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/cropimgcollage', {
                imgkey: cuimagekey,
                ukey: ukey,
                x: g_x,
                y: g_y,
                w: g_w,
                h: g_h,
            }, function(data) {

                if (data.new_crop_file_name) {

                    if (imbackground == "no") {
                        $('#change_' + cuimagekey).attr('src', tempImagePath + data.new_crop_file_name).load(function() {
                            $('#change_' + cuimagekey).css('max-width', '300');
                            $('#change_' + cuimagekey).css('max-height', '300');
                            $("#savecrop").removeAttr('disabled', true);
                            newimage = '';
                            $.colorbox.close();
                        });
                    } else {
                        $('.change_' + cuimagekey).css('background-image', 'url(' + tempImagePath + data.new_crop_file_name + ')');
                        $.colorbox.close();
                    }

                }


            }, "json");
        }

        $('#savecrop').click(function(e) {
            $("#savecrop").attr('disabled', 'disabled');
            g_x = $('#x').val();
            g_y = $('#y').val();
            g_w = $('#w').val();
            g_h = $('#h').val();
            if (g_x > 0 || g_y > 0 || g_w > 0 || g_h > 0) {

            } else {
                $("#savecrop").removeAttr('disabled', true);
                alert("WARNING: You must have to crop to save the image.");
                return false;
            }
            var r = confirm("WARNING: Image will be cropped. Are you sure you want to crop this image?");
            //window.location.reload();
            if (r == true)
            {

                cropimage();
            }
            else
            {
                $("#savecrop").removeAttr('disabled', 'disabled');
            }

            e.stopImmediatePropagation();
        });
        var xxx = 1;
        var jcrop_api;
        var _icropimgkey = '';
        var g_x = '';
        var g_y = '';
        var g_w = '';
        var g_h = '';
        $(document).ready(function() {
            $('.edit_img').click(function(e) {
                imbackground = $(this).attr('background');
                $('#x').val('');
                $('#y').val('');
                $('#w').val('');
                $('#h').val('');
                $("#savecrop").removeAttr('disabled', 'disabled');
                _thisfileName = $(this).attr('cropped_image');
                _icropimgkey = $(this).attr('imgkey');
                $("#cuimagekey").val(_icropimgkey);
                $('.display_avatar').attr('src', tempImagePath + _thisfileName);
                $.colorbox({
                    height: "auto",
                    width: "auto",
                    inline: true,
                    href: "#inline_content",
                    onComplete: function() {
                        uimagekey = _thisfileName;
                        $('.display_avatar').Jcrop({
                            bgColor: 'black',
                            bgOpacity: .4,
                            setSelect: [100, 100, 50, 50],
                            onSelect: updateCoords
                        }, function() {

                            jcrop_api = this;
                        });
                    },
                    onClosed: function() {
                        jcrop_api.destroy();
                    }
                });
                e.stopImmediatePropagation();
            });
            $('.not_edit_img').click(function(e) {

                alert("This image is not editable.");
                e.stopImmediatePropagation();
            });
        });
        function updateCoords(c)
        {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }
        ;</script>

    <div style='display:none'>
        <div id='inline_content' style='padding:10px; background:#fff;'>

            <p class="image_popup">
                <img class="display_avatar"  alt="images" src="" alt="no img choosen">
            <div style="text-align: center;margin-top:20px;">
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="cuimagekeyx" name="cuimagekeyx" value="" />
                <button style="cursor:pointer;" class="btn btn-success" id="savecrop" type="button">Save</button>
            </div>
            </p>

        </div>
    </div>

    <div style='display:none'>
        <div id='inline_scale_content' style='padding:10px; background:#fff;'>

            <div class="image_popup">
                <div class="display_avatar_scale">
                    <img 
                        class=""  
                        alt="images" src="" alt="no img choosen" />
                </div>

                <div style="text-align: center;margin-top:20px;">
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="hidden" id="cuimagekey" name="cuimagekey" value="" />
                    <button style="cursor:pointer;" class="btn btn-success" 
                            id="savescale" type="button">Save</button>
                </div>


            </div>
        </div>
        <style>
            #lighttable{
                max-width:100% !important;
                max-height:100% !important;
                width: 1024px;
                background-size: cover;
                background-repeat: no-repeat !important;
                display:block;
            }
            .display_avatar_scale img {
                width:100%;
                height:100%;
            }
        </style>

