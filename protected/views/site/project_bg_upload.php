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

<script src="<?php echo Yii::app()->request->baseUrl; ?>/cdn/js/collage.js"></script>

<script>
    var scalew = 0;
    var scaleh = 0;
    var background_upload = 1;
    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';
    var newimage = '';
    var imgkey = '';
    var ukey = '<?php echo $_GET["ukey"]; ?>';
    var imgpos = 5;
    var size_update_url = '<?php echo $this->createUrl('/upload/updateResize'); ?>';
    $(document).ready(function() {
        loadprojectimages();
        collage.element_tob_rotate = ".image_part";
        collage.initPhotos();
        collage.resizableBackgroundImage();
        var fileuploadedname = '';
        var errorHandler = function(event, id, fileName, reason) {
            $("#btnSubmit").removeAttr('disabled', 'disabled');
            qq.log("id: " + id + ", fileName: " + fileName + ", reason: " + reason);
        };
        var uploader5 = new qq.FineUploader({
            element: $('#uploadBackground')[0],
            multiple: false,
            request: {
                endpoint: '<?php echo $this->createUrl('/upload/fileUpload'); ?>'
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG']
            },
            text: {
                uploadButton: "BROWSE"
            },
            callbacks: {
                onError: errorHandler,
                onSubmit: function(id, fileName) {
                    newimage = '';
                    $("#saveit").attr('disabled', 'disabled');
                },
                onComplete: function(id, fileName, responseJSON) {
                    newimage = fileName;
                    imgpos = 5;
                    collage.upload_img_obj = responseJSON;
                    loadprojectimages();
                }
            }
        });




    });
    function loadprojectimages() {
        $.post('<?php echo $this->createUrl("/site/loadbgimages"); ?>', {
            newimage: newimage,
            ukey: ukey,
            imgpos: imgpos
        }, function(data) {

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
        $.post('<?php echo $this->createUrl('/site/deletebgimage'); ?>', {
            imgkey: imgkey,
            ukey: ukey
        }, function(data) {
            $(".image_container").html("");
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
        collage.upload_img_obj
        $("#saveit").removeAttr('disabled', 'disabled');
        $.post('<?php echo $this->createUrl('/site/makebackground'); ?>', {
            imgkey: imgkey,
            ukey: ukey,
            image_properties: collage.upload_img_obj
        }, function(data) {
            data = JSON.parse(data);
            $(".image_container").html(collage.getBackgroundHTml(data));
            collage.resizableBackgroundImage();
            $('.imgblock').html(data.dataset);
            $("#saveit").removeAttr('disabled', 'disabled');
            newimage = '';
            collage.upload_img_obj = {}
            loadprojectimages();
        });
    }

    function cropimage() {
        var cuimagekey = $('#cuimagekey').val();
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/cropbgimg', {
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

    function scaleimage() {
        var cuimagekey = $('#cuimagekey').val();
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/scaleimg', {
            imgkey: cuimagekey,
            ukey: ukey,
            scalew: scalew,
            scaleh: scaleh
        }, function(data) {

            if (data) {
                $('.imgblock').html(data);
            }
            $("#savescale").removeAttr('disabled', true);
            newimage = '';
            $.colorbox.close();
        });
    }

    $('.make_bg').live("click", function(e) {

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

    $('.delete_img').live("click", function(e) {

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


    $('#savecrop').live("click", function(e) {
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

    $('#savescale').live("click", function(e) {
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
        $('.edit_img').live("click", function(e) {
            $('#x').val('');
            $('#y').val('');
            $('#w').val('');
            $('#h').val('');
            $("#savecrop").removeAttr('disabled', 'disabled');
            _thisfileName = $(this).attr('img_name');
            _icropimgkey = $(this).attr('imgkey');
            $("#cuimagekey").val(_icropimgkey);
            $('.display_avatar').attr('src', tempImagePath + _thisfileName);
            $.colorbox({
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

        $('.scale_img').live("click", function(e) {

            //$( ".display_avatar_scale" ).resizable( "destroy" );
            //$('.display_avatar_scale').attr( "style", "" );
            //$('.ui-wrapper').attr( "style", "" );
            //$('.ui-wrapper').css( "width", orw);
            //$('.ui-wrapper').css( "height", orh );

            scalew = 0;
            scaleh = 0;
            _thisfileName = $(this).attr('img_name');
            _icropimgkey = $(this).attr('imgkey');
            $("#cuimagekey").val(_icropimgkey);
            $('.display_avatar_scale').attr('src', tempImagePath + _thisfileName);
            $.colorbox({
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


</script>
<script>
    var ukey = '<?php echo $_GET["ukey"]; ?>';
    $("#saveit").live("click", function() {
        window.location.href = '<?php echo $this->createUrl("/site/upload/"); ?>/' + "?ukey=" + ukey
    });
    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';

</script>

<div id="gameSection" style="padding-top:0px;">
    <div style="min-height: 300px; background:white;">
        <div id="pageTitle" style="text-align: center;">
            <h2 class="thick-title page-title-bar">Project - <?php echo $model->name; ?></h2>
        </div>

        <br><br>
        <div class="col-lg-12 col-md-12 col-sm-12 imgchanel">
            <div style="text-align:center;"><span class="step"><b style="font-size:30px;">Step 2</b></span> <span class="headingname">Select Background Images</span></div>
            <br>

            <br>
            <div class="wrapper-box">
                <div class="wrapper-content">

                    <br/>
                    <div class="image_container">
                        <?php
                        if (isset($_GET['ukey'])) {
                            $criteria = new CDbCriteria();
                            $criteria->addCondition("project_key = :project_key AND bg_img=1");
                            $criteria->params = array("project_key" => $_GET['ukey']);
                            $criteria->order = "id DESC";
                            $current_Image = Images::model()->find($criteria);

                            if ($current_Image = Images::model()->find($criteria)) {
                                echo "<h3>" . ucfirst($current_Image->dimension_type) . "</h3>";
                                DTUploadedFile::calculateImageStyle($current_Image);
                            } else {

                                if ($current_Image = Images::model()->findByPk($model->bg_id)) {
                                    echo "<h3>" . ucfirst($current_Image->dimension_type) . "</h3>";
                                    DTUploadedFile::calculateImageStyle($current_Image);
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="row imgblock" style="margin: 20px;" >

                    </div>
                    <div class="headingnameor">Or Upload Your Own</div>
                    <div style="width:100%;">
                        <div class="form-group" style="text-align: center;" >
                            <div id="uploadBackground" class="unstyled" style="padding: 20px;margin-left: 38%;">

                            </div>
                        </div>

                    </div>

                    <div style="clear: both;"></div>
                    <div class="row" style="height: 20px;" >

                    </div>
                </div></div>
            <div style="padding:20px;text-align: center;">
                <button style="cursor:pointer;" class="btn btn-success" id="saveit" type="button">Next</button>
            </div>
        </div>
    </div>
</div>
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

        <p class="image_popup">
            <img class="display_avatar_scale"  alt="images" src="" alt="no img choosen">
        <div style="text-align: center;margin-top:20px;">
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <input type="hidden" id="cuimagekey" name="cuimagekey" value="" />
            <button style="cursor:pointer;" class="btn btn-success" id="savescale" type="button">Save</button>
        </div>
        </p>

    </div>
</div>


