

<style>
    img{max-width: none !important;}
    .banner,
    .extra-preview {
        margin-bottom: 5px;
        overflow: hidden;
        width: 100%;
    }

    .banner img,
    .extra-preview img {
        width: 100%;
    }

    .extra-preview-sm {
        height: 90px;
        width: 160px;
    }
    .mheight{
        //height: 30%;
        //width: 30%;
       // margin-left:-15px;
    }
    .disnone{
        display:none;
    }


</style>

<link  href="<?php echo Yii::app()->request->baseUrl; ?>/imgcrop/src/cropper.css" rel="stylesheet">

<script src="http://fengyuanchen.github.io/js/vendor/google-code-prettify/prettify.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/imgcrop/src/cropper.js"></script>





<link   href="<?php echo Yii::app()->request->baseUrl; ?>/file-uploader-master/client/fineuploader.css" rel="stylesheet" type="text/css"/>
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
    $(document).ready(function() {
        $('.show_cropzone').hide();
        $('.mavatar').hide();
        $(".croparea").hide();
    });
</script>
<script>

    var tempImagePath = '<?php echo Yii::app()->request->baseUrl; ?>/collage/';
    var firsttime = 0;
    $(document).ready(function() {
        var fileuploadedname = '';
        var errorHandler = function(event, id, fileName, reason) {
            $("#btnSubmit").removeAttr('disabled', 'disabled');
            qq.log("id: " + id + ", fileName: " + fileName + ", reason: " + reason);
        };
        var uploader4 = new qq.FineUploader({
            element: $('#uploadWithVariousOptionsExample')[0],
            multiple: false,
            request: {
                endpoint: '<?php echo Yii::app()->request->baseUrl; ?>' + "/uploader.php"
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG']
            },
            text: {
                uploadButton: "Upload Collage"
            },
            callbacks: {
                onError: errorHandler,
                onSubmit: function(id, fileName) {
                    $("#Submit").attr('disabled', 'disabled');
                },
                onComplete: function(id, fileName, responseJSON) {
                    $('.mavatar').show();
                    if (firsttime == 0) {
                        $dataX1 = $("#dataX1"),
                        $dataY1 = $("#dataY1"),
                        $dataX2 = $("#dataX2"),
                        $dataY2 = $("#dataY2"),
                        $dataHeight = $("#dataHeight"),
                        $dataWidth = $("#dataWidth");


                                
                        //$('.croparea').hide();
                        var pv = 0;
                        var itsname = 'afbeelding bewerken';
                        $('.show_cropzone').live('click', function() {
                            itsname = $('.show_cropzone').text();
                            if (itsname == 'afbeelding bewerken') {
                                $('#cropit').val('1');
                                $(".croparea").show();
                                $(".mavatar").hide();
                                $('.show_cropzone').text('ongedaan maken');
                                $(".cropper").cropper("enable");
                            } else {
                                $('#cropit').val('0');
                                $(".croparea").hide();
                                $('.show_cropzone').text('afbeelding bewerken');
                                $(".cropper").cropper("disable");
                                $(".mavatar").show();
                            }

                        });

                        /*$(".cropper").cropper({
                            aspectRatio: 16 / 9,
                            preview: ".extra-preview",
                            done: function(data) {
                                $dataX1.val(data.x1);
                                $dataY1.val(data.y1);
                                $dataX2.val(data.x2);
                                $dataY2.val(data.y2);
                                $dataHeight.val(data.height);
                                $dataWidth.val(data.width);
                            }
                        });
                        $(".cropper").cropper("disable");*/
                        firsttime = 1;
                    }

                    $('.show_cropzone').show();
                    fileuploadedname = fileName;
                    $("#picName").val(fileName);
                    $("#uploadfileyes").val("1");
                    alert(fileName);
                    $('.display_avatar').attr('src', tempImagePath + fileName);
                    $('.cropper').attr('src', tempImagePath + fileName);

                    $("#Submit").removeAttr('disabled', 'disabled');
                }
            }
        });
    });
</script>
<script>
    var ukey = '<?php echo $_GET["ukey"];?>';
    $( "#saveit" ).live( "click", function() {
        window.location.href =  '<?php echo BASE_URL; ?>/'+"site/collage/?ukey="+ukey
    });

</script>

<div id="gameSection" style="padding-top:0px;">
    <div style="min-height: 300px; background:white;">
        <div style="display:none;">
            <div style="display:block;" class="form-group">
                <label class="col-sm-3 control-label" for="dataX1">X1:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="x1" name="dataX1" id="dataX1" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="dataY1">Y1:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="y1" name="dataY1" id="dataY1" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="dataX2">X2:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="x2" name="dataX2" id="dataX2" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="dataY2">Y2:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="y2" name="dataY2" id="dataY2" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="dataWidth">Width:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="width" name="dataWidth" id="dataWidth" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="dataHeight">Height:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="height" name="dataHeight" id="dataHeight" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group" >
             <div id="uploadWithVariousOptionsExample" class="unstyled" style="padding: 30px;">

             </div>
             <br>
             <button class="btn btn-warning btn-lg show_cropzone" data-toggle="modal">Crop it</button>
             <input  type="hidden"  name="cropit" id="cropit" value="0" class="form-control">
             <input  type="hidden" id="uploadfileyes" name="uploadfileyes" value=""/>
             <input  type="hidden" id="picName" name="picName" value=""/>
         </div>
        <div class="form-group mavatar">
            <img class="display_avatar" width="200" alt="images" src="" alt="no img choosen">
        </div>
        <div class="croparea"  id='inline_content'>
            <div class="form-group success" style="display: block;">

                <div class="col-md-12 areablock" style="padding-left: -15px !important;">
                    <div class="banner">
                        <div class="col-md-8 mheight" style="padding-left: -15px !important;">



                            <img class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/collage/bkg_single_game">


                        </div>
                        <div class="col-md-3" >

                            <div class="extra-preview extra-preview-sm" style="overflow: hidden;">

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <div style="padding:20px;text-align: center;">
        <button style="cursor:pointer;" class="btn btn-default" id="saveit" type="button">Next</button>
    </div>
</div>


