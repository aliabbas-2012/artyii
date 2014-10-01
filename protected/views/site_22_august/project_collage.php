<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/colorbox/colorbox.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/colorbox/jquery.colorbox.js"></script>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/js/jquery.Jcrop.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/js/jquery.color.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/tapmodo-Jcrop-1902fbc/css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">

var newImageZIndex = 1;         // To make sure newly-loaded images land on top of images on the table
var loaded = false;             // Used to prevent initPhotos() running twice
var imageBeingRotated = false;  // The DOM image currently being rotated (if any)
var mouseStartAngle = false;    // The angle of the mouse relative to the image centre at the start of the rotation
var imageStartAngle = false;    // The rotation angle of the image at the start of the rotation

// When the document is ready, fire up the table!
$( init );

// When the wooden table image has loaded, start bringing in the photos
function init() {
  var woodenTable = $('#wooden-table img');
  woodenTable.load( initPhotos );

  // Hack for browsers that don't fire load events for cached images
  if ( woodenTable.get(0).complete ) $(woodenTable).trigger("load");
}

// Set up each of the photos on the table

function initPhotos() {

  // (Ensure this function doesn't run twice)
  if ( loaded ) return;
  loaded = true;

  // The table image has loaded, so bring in the table
  $('#lighttable').fadeIn('fast');

  // Add an event handler to stop the rotation when the mouse button is released
  $(document).mouseup( stopRotate );

  // Process each photo in turn...
  $('#lighttable img').each( function(index) {

    // Set a random position and angle for this photo
    var left = Math.floor( Math.random() * 550 + 100 );
    var top = Math.floor( Math.random() * 150 + 100 );
    var angle = Math.floor( Math.random() * 60 - 30 );
    $(this).css( 'left', left+'px' );
    $(this).css( 'top', top+'px' );
    $(this).css( 'transform', 'rotate(' + angle + 'deg)' );   
    $(this).css( '-moz-transform', 'rotate(' + angle + 'deg)' );   
    $(this).css( '-webkit-transform', 'rotate(' + angle + 'deg)' );
    $(this).css( '-o-transform', 'rotate(' + angle + 'deg)' );
    $(this).data('currentRotation', angle * Math.PI / 180 );

    // Make the photo draggable
    $(this).draggable( { containment: 'parent', stack: '#lighttable img', cursor: 'pointer', start: dragStart } );

    // Make the photo rotatable
    $(this).mousedown( startRotate );

    // Make the lightbox pop up when the photo is clicked
    

    // Hide the photo for now, in case it hasn't finished loading
    $(this).hide();

    // When the photo image has loaded...
    $(this).load( function() {

      // (Ensure this function doesn't run twice)
      if ( $(this).data('loaded') ) return;
      $(this).data('loaded', true);

      // Record the photo's true dimensions
      var imgWidth = $(this).width();
      var imgHeight = $(this).height();

      // Make the photo bigger, so it looks like it's high above the table
      $(this).css( 'width', imgWidth * 1.5 );
      $(this).css( 'height', imgHeight * 1.5 );

      // Make it completely transparent, ready for fading in
      $(this).css( 'opacity', 0 );

      // Make sure its z-index is higher than the photos already on the table
      $(this).css( 'z-index', newImageZIndex++ );

      // Gradually reduce the photo's dimensions to normal, fading it in as we go
      $(this).animate( { width: imgWidth, height: imgHeight, opacity: .95 }, 1200 );
    } );

    // Hack for browsers that don't fire load events for cached images
    if ( this.complete ) $(this).trigger("load");

  });

}

// Prevent the image being dragged if it's already being rotated

function dragStart( e, ui ) {
  if ( imageBeingRotated ) return false;
}

// Open the lightbox only if an image isn't currently being rotated



// Start rotating an image

function startRotate( e ) {

  // Exit if the shift key wasn't held down when the mouse button was pressed
  if ( !e.shiftKey ) return;

  // Track the image that we're going to rotate
  imageBeingRotated = this;

  // Store the angle of the mouse at the start of the rotation, relative to the image centre
  var imageCentre = getImageCentre( imageBeingRotated );
  var mouseStartXFromCentre = e.pageX - imageCentre[0];
  var mouseStartYFromCentre = e.pageY - imageCentre[1];
  mouseStartAngle = Math.atan2( mouseStartYFromCentre, mouseStartXFromCentre );

  // Store the current rotation angle of the image at the start of the rotation
  imageStartAngle = $(imageBeingRotated).data('currentRotation');

  // Set up an event handler to rotate the image as the mouse is moved
  $(document).mousemove( rotateImage );

  return false;
}

// Stop rotating an image

function stopRotate( e ) {

  // Exit if we're not rotating an image
  if ( !imageBeingRotated ) return;

  // Remove the event handler that tracked mouse movements during the rotation
  $(document).unbind( 'mousemove' );

  // Cancel the image rotation by setting imageBeingRotated back to false.
  // Do this in a short while - after the click event has fired -
  // to prevent the lightbox appearing once the Shift key is released.
  setTimeout( function() { imageBeingRotated = false; }, 10 );
  return false;
}

// Rotate image based on the current mouse position

function rotateImage( e ) {

  // Exit if we're not rotating an image
  if ( !e.shiftKey ) return;
  if ( !imageBeingRotated ) return;

  // Calculate the new mouse angle relative to the image centre
  var imageCentre = getImageCentre( imageBeingRotated );
  var mouseXFromCentre = e.pageX - imageCentre[0];
  var mouseYFromCentre = e.pageY - imageCentre[1];
  var mouseAngle = Math.atan2( mouseYFromCentre, mouseXFromCentre );

  // Calculate the new rotation angle for the image
  var rotateAngle = mouseAngle - mouseStartAngle + imageStartAngle;

  // Rotate the image to the new angle, and store the new angle
  $(imageBeingRotated).css('transform','rotate(' + rotateAngle + 'rad)');
  $(imageBeingRotated).css('-moz-transform','rotate(' + rotateAngle + 'rad)');
  $(imageBeingRotated).css('-webkit-transform','rotate(' + rotateAngle + 'rad)');
  $(imageBeingRotated).css('-o-transform','rotate(' + rotateAngle + 'rad)');
  $(imageBeingRotated).data('currentRotation', rotateAngle );
  return false;
}

// Calculate the centre point of a given image

function getImageCentre( image ) {

  // Rotate the image to 0 radians
  $(image).css('transform','rotate(0rad)');
  $(image).css('-moz-transform','rotate(0rad)');
  $(image).css('-webkit-transform','rotate(0rad)');
  $(image).css('-o-transform','rotate(0rad)');

  // Measure the image centre
  var imageOffset = $(image).offset();
  var imageCentreX = imageOffset.left + $(image).width() / 2;
  var imageCentreY = imageOffset.top + $(image).height() / 2;

  // Rotate the image back to its previous angle
  var currentRotation = $(image).data('currentRotation');
  $(imageBeingRotated).css('transform','rotate(' + currentRotation + 'rad)');
  $(imageBeingRotated).css('-moz-transform','rotate(' + currentRotation + 'rad)');
  $(imageBeingRotated).css('-webkit-transform','rotate(' + currentRotation + 'rad)');
  $(imageBeingRotated).css('-o-transform','rotate(' + currentRotation + 'rad)');

  // Return the calculated centre coordinates
  return Array( imageCentreX, imageCentreY );
}

var ukey = '<?php echo $_GET["ukey"];?>';
var total = '<?php echo count($imgmodel);?>';
function printDiv()
{
    if(total<=0){
        alert('Please upload at least one image to proceed on. Otherwise refresh the page to recount your uploaded image.');
        return false;
    }else{
        html2canvas([document.getElementById('lighttable')], {   
            onrendered: function(canvas)  
            {
                var img = canvas.toDataURL();
                $.post('<?php echo BASE_URL; ?>/'+"site/saveimg", {data: img,ukey:ukey}, function (file) {
                    if(file != ''){
                        window.location.href =  '<?php echo BASE_URL; ?>/'+"site/success/?ukey="+ukey
                    }

                });   
            }
        });    
    }
}
$( "#backit" ).live( "click", function() {
        window.location.href =  '<?php echo BASE_URL; ?>/'+"site/upload/?ukey="+ukey
});
$( "#saveit" ).live( "click", function() {
 printDiv();
});

</script>


<div id="pageTitle">
    <h2 class="thick-title page-title-bar">Collage Builder</h2>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="wrapper-box">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        
                        
                        <div id="wooden-table">
                            <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>
                                <img  style="z-index: 90000;" src="<?php echo BASE_URL; ?>/collage/<?php echo $result_bg['cropped_img']; ?>" alt="Wooden table image" />
                            <?php } else { ?>
                                <img style="z-index: 90000;" src="<?php echo BASE_URL; ?>/images/light.jpg" alt="Wooden table image" />
                            <?php } ?>

                        </div>

                        <div id="gameSection" style="padding-top:0px;">
                            <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>
                                <div id="lighttable"  class="change_<?php echo $result_bg['img_key']; ?>"   style="background-size: 100% 100%, auto;background-repeat-x: no-repeat;
background-repeat-y: no-repeat;background: #eee url(<?php echo BASE_URL; ?>/collage/<?php echo $result_bg['cropped_img']; ?>);">
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
                                            ?>

                                            <img id="change_<?php echo $imgmodel[$i]->img_key; ?>" style="max-width: 300px;max-height: 300px;" src="<?php echo BASE_URL; ?>/collage/<?php echo $imgmodel[$i]->cropped_img; ?>" alt="alt" />

    <?php }
} ?>

                                </div>
                                <div style="width:100%;margin-top:60px;">

                                <?php if (isset($result_bg['cropped_img']) && !empty($result_bg['cropped_img'])) { ?>

                                        <div style="width:20%;float:left;">

                                            <div style="color:white; padding:20px;background:#0396e3;border: 5px solid #CCC">
                                                BACKGROUND IMAGE
                                            </div>
                                            <div style="border: 5px solid #fff;padding:10px;">
                                                <img class="<?php if($result_bg['project_key'] != "XXX"){echo "edit_img";}else {echo "not_edit_img";}?>" background="yes" img_name="<?php echo $result_bg['main_img']; ?>" imgkey="<?php echo $result_bg['img_key']; ?>" style="cursor:pointer; width: 192px;height: 200px;" src="<?php echo BASE_URL; ?>/collage/<?php echo $result_bg['main_img']; ?>" alt="alt" />
                                            </div>
                                        </div>


                                    <?php } else { ?>

                                    <?php } ?>

                                    <?php if (isset($imgmodel) && !empty($imgmodel) && count($imgmodel) > 0) {
                                        for ($i = 0; $i < count($imgmodel); $i++) {
                                        ?>  

                                            <div style="width:20%;float:left;">
                                                <div style="color:white; padding:20px;background:#0396e3;border: 5px solid #CCC">
                                                    IMAGE <?php echo $i + 1; ?>
                                                </div>
                                                <div style="border: 5px solid #fff;padding:10px;">
                                                    <img background="no" class="edit_img" img_name="<?php echo $imgmodel[$i]->main_img; ?>" imgkey="<?php echo $imgmodel[$i]->img_key; ?>" style="cursor:pointer; width: 192px;height: 200px;" src="<?php echo BASE_URL; ?>/collage/<?php echo $imgmodel[$i]->main_img; ?>" alt="alt" />
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                               </div>
                                <div style="clear: both;"></div>
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
                
                    if(imbackground=="no"){
                        $('#change_'+cuimagekey).attr('src', tempImagePath + data.new_crop_file_name).load(function() {  
                            $('#change_'+cuimagekey).css('max-width','300');
                            $('#change_'+cuimagekey).css('max-height','300');
                            $("#savecrop").removeAttr('disabled',true);
                            newimage = '';
                            $.colorbox.close();

                        }); 
                    }else{
                        $('.change_'+cuimagekey).css('background-image', 'url('+tempImagePath + data.new_crop_file_name+')');
                        $.colorbox.close();
                    }
                 
                }
                
                
            }, "json");
            
        }
        
        $('#savecrop').live("click", function(e) {
            $("#savecrop").attr('disabled', 'disabled');
            g_x =  $('#x').val();
            g_y =  $('#y').val();
            g_w=  $('#w').val();
            g_h =  $('#h').val();
            if(g_x > 0 || g_y >0 || g_w>0 || g_h >0){
            
            }else{
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
    
    
        var xxx = 1;
        var jcrop_api;
        var _icropimgkey = '';
        var g_x = '';
        var g_y = '';
        var g_w = '';
        var g_h = '';
        $(document).ready(function() {
            $('.edit_img').live("click", function(e) {
                imbackground = $(this).attr('background');
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
            
            $('.not_edit_img').live("click", function(e) {
                
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
        ;
    </script>
    
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
                <button style="cursor:pointer;" class="btn btn-success" id="savecrop" type="button">Update Image</button>
            </div>
            </p>

        </div>
    </div>