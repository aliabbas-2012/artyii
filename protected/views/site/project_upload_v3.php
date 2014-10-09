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

<script>
    var background_upload = 1;
    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';
    var newimage = '';
    var imgkey = '';
    var ukey = '<?php echo $_GET["ukey"]; ?>';
    $(document).ready(function() {
        loadprojectimages();

        var fileuploadedname = '';
        var errorHandler = function(event, id, fileName, reason) {
            $("#btnSubmit").removeAttr('disabled', 'disabled');
            qq.log("id: " + id + ", fileName: " + fileName + ", reason: " + reason);
        };
        var uploader4 = new qq.FineUploader({
            element: $('#uploadWithVariousOptionsExample')[0],
            multiple: false,
            request: {
                endpoint: '<?php echo $this->createUrl('/upload/fileUpload'); ?>'
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG']
            },
            text: {
                uploadButton: "COLLAGE IMAGE"
            },
            callbacks: {
                onError: errorHandler,
                onSubmit: function(id, fileName) {
                    newimage = '';
                    $("#saveit").attr('disabled', 'disabled');
                },
                onComplete: function(id, fileName, responseJSON) {
                    newimage = fileName;
                    loadprojectimages();
                }
            }
        });


        var uploader1 = new qq.FineUploader({
            element: $('#uploadBackground')[0],
            multiple: false,
            request: {
                endpoint: '<?php echo $this->createUrl('/upload/fileUpload'); ?>'
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG']
            },
            text: {
                uploadButton: "BACKGROUND IMAGE"
            },
            callbacks: {
                onError: errorHandler,
                onSubmit: function(id, fileName) {
                    if (background_upload == 0) {
                        alert('To upload a new backgorund image you must have to delete your previous background image.');
                        return false;
                    }
                    newimage = '';
                    $("#saveit").attr('disabled', 'disabled');
                },
                onComplete: function(id, fileName, responseJSON) {
                    newimage = fileName;
                    loadprojectimagesbackground();
                }
            }
        });
    });
    function loadprojectimagesbackground() {
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/loadimages', {
            newimage: newimage,
            ukey: ukey,
            background: 1
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
    function loadprojectimages() {
        $.post('<?php echo Yii::app()->request->baseUrl; ?>' + '/site/loadimages', {
            newimage: newimage,
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

            if (data) {
                $('.imgblock').html(data);
            }
            $("#saveit").removeAttr('disabled', 'disabled');
            newimage = '';
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



    })
    var xxx = 1;
    var jcrop_api;
    var _icropimgkey = '';
    var g_x = '';
    var g_y = '';
    var g_w = '';
    var g_h = '';
    $(document).ready(function() {
        $('.edit_img').click(function(e) {
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
                        aspectRatio: 16 / 9,
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
    });
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }
    ;
</script>
<script>
    var ukey = '<?php echo $_GET["ukey"]; ?>';
    $(function() {
        $("#saveit").click(, function() {
            window.location.href = '<?php echo BASE_URL; ?>/' + "site/collage/?ukey=" + ukey
        });
    })
    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';

</script>

<div id="gameSection" style="padding-top:0px;">
    <div style="min-height: 300px; background:white;">
        <div id="pageTitle" style="padding:20px;text-align: center;">
            <h2 class="thick-title page-title-bar">Project - <?php echo $model->name; ?></h2>
        </div>
        <div style="width:100%;">
            <div class="form-group" style="width: 50%;float:left;" >
                <div id="uploadWithVariousOptionsExample" class="unstyled" style="padding: 20px;">

                </div>
            </div>
            <div class="form-group" style="width: 50%;float:right;">
                <div id="uploadBackground" class="unstyled" style="padding: 20px;">

                </div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="row imgblock" style="margin: 20px;" >

        </div>
        <div class="row" style="height: 20px;" >

        </div>
    </div>
    <div style="padding:20px;text-align: center;">
        <button style="cursor:pointer;" class="btn btn-success" id="saveit" type="button">Next</button>
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
            <input type="hidden" id="cuimagekey" name="cuimagekey" value="" />
            <button style="cursor:pointer;" class="btn btn-success" id="savecrop" type="button">Save</button>
        </div>
        </p>

    </div>
</div>


