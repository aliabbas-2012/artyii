var collage = {
    upload_img_obj: {},
    getBackgroundHTml: function(data) {
        html_with_scale = '<div class="ui-resizable-handle ui-resizable-nw" id="nwgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-ne" id="negrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-sw" id="swgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-se" id="segrip"></div>';
        style = "style='width:" + data['all_result']['width'] + "px;height:" + data['all_result']['height'] + "px;'";
        other_htm_op = '';
        for (obj in data['htmlOptions']) {
            other_htm_op += obj + '=' + data['htmlOptions'][obj] + ' ';
        }

        html = "<h3>" + data['all_result']['dimension_type'] + "</h3>";
        html += "<div class='image_part' " + style + " " + other_htm_op + ">";
        html += data.cropped_image;
        html += html_with_scale;
        html += "</div>";
        return html;
    },
    resizableBackgroundImage: function() {
        id = $(".image_container>div img").attr("alt");
        $(".image_container>div").resizable({
            stop: function(event, ui) {

                //size_update_url
                $.post(size_update_url, {
                    id: id,
                    height: ui.size.height,
                    width: ui.size.width,
                }, function(data) {

                });
            }
        });
    },
    resizableCollage: function() {

        $(collage.element_tob_rotate + "").resizable({
            stop: function(event, ui) {

                object = collage.children(ui.helper);
                //size_update_url
                $.post(size_update_url, {
                    id: $(object).attr("alt"),
                    height: ui.size.height,
                    width: ui.size.width,
                }, function(data) {

                });
            }
        });
    },
    //drag and rotate
    newImageZIndex: 1, // To make sure newly-loaded images land on top of images on the table
    loaded: false, // Used to prevent initPhotos() running twice
    imageBeingRotated: false, // The DOM image currently being rotated (if any)
    mouseStartAngle: false, // The angle of the mouse relative to the image centre at the start of the rotation
    imageStartAngle: false,
    element_tob_rotate: "#lighttable",
    start_set_pos: false,
    initPhotos: function() {
        // (Ensure this function doesn't run twice)
        if (collage.loaded)
            return;
        collage.loaded = true;
        // The table image has loaded, so bring in the table
        $(collage.element_tob_rotate).fadeIn('fast');
        // Add an event handler to stop the rotation when the mouse button is released
        $(document).mouseup(collage.stopRotate);
        // Process each photo in turn...
        $(collage.element_tob_rotate).each(function(index) {


            // Set a random position and angle for this photo
            var left = Math.floor(Math.random() * 450 + 100);
            var top = Math.floor(Math.random() * 100 + 100);
            var angle = Math.floor(Math.random() * 60 - 30);
            var angle = 0;

            if (collage.start_set_pos == true) {
                $(this).css('left', left + 'px');
                $(this).css('top', top + 'px');
                $(this).css('position', 'inherit');
//                collage.arrangeLeftParent(this,left);
//                collage.arrangeTopParent(this,top);
            }

            //setting positions
            if (typeof ($(this).attr("c-left")) != "undefined") {
                left = parseFloat($(this).attr("c-left"));
                $(this).css('left', left + 'px');
            }
            if (typeof ($(this).attr("c-top")) != "undefined") {
                top = parseFloat($(this).attr("c-top"));
                $(this).css('top', top + 'px');
            }
            if (typeof ($(this).attr("c-width")) != "undefined") {
                cwidth = parseFloat($(this).attr("c-width"));
                $(this).css('width', cwidth + 'px');
            }
            if (typeof ($(this).attr("c-height")) != "undefined") {
                cheight = parseFloat($(this).attr("c-height"));
                $(this).css('height', cheight + 'px');
            }
            if (typeof ($(this).attr("angle")) != "undefined") {
                angle = parseFloat($(this).attr("angle"));
                $(this).data('currentRotation', angle);
            }

//            


            collage.children($(this)).css('transform', 'rotate(' + angle + 'deg)');
            collage.children($(this)).css('-moz-transform', 'rotate(' + angle + 'deg)');
            collage.children($(this)).css('-webkit-transform', 'rotate(' + angle + 'deg)');
            collage.children($(this)).css('-o-transform', 'rotate(' + angle + 'deg)');
            $(this).data('currentRotation', angle * Math.PI / 180);
//            
            // Make the photo draggable
            $(this).draggable({containment: 'parent', stack: "#lighttable",
                cursor: 'pointer', start: collage.dragStart, stop: collage.dragStop});
            // Make the photo rotatable
            $(this).mousedown(collage.startRotate);
            // Make the lightbox pop up when the photo is clicked
            $(this).bind('click', function() {
                collage.openLightbox(this)
            });
            // Hide the photo for now, in case it hasn't finished loading
            // $(this).hide();
            // When the photo image has loaded...
            $(this).load(function() {

                // (Ensure this function doesn't run twice)
                if ($(this).data('loaded'))
                    return;
                $(this).data('loaded', true);

                // Make it completely transparent, ready for fading in
                $(this).css('opacity', 1);
                // Make sure its z-index is higher than the photos already on the table
                $(this).css('z-index', collage.newImageZIndex++);
                // Gradually reduce the photo's dimensions to normal, fading it in as we go
                // Record the photo's true dimensions
                var imgWidth = $(this).width();
                var imgHeight = $(this).height();

//                // Make the photo bigger, so it looks like it's high above the table
//                $(this).css('width', imgWidth * 1.5);
//                $(this).css('height', imgHeight * 1.5);

//                $(this).animate({width: imgWidth, height: imgHeight, opacity: .95}, 1200);


            });
            // Hack for browsers that don't fire load events for cached images
            if (this.complete)
                $(this).trigger("load");
        });
    },
    // Prevent the image being dragged if it's already being rotated
    dragStart: function(e, ui) {

        if (collage.imageBeingRotated)
            return false;
    },
    dragStop: function(e, ui) {
        //size_update_url

        id = ui.helper.attr("alt");

        $.post(size_update_url, {
            id: id,
            left: ui.position.left,
            top: ui.position.top,
        }, function(data) {

        });
        if (collage.imageBeingRotated)
            return false;
    },
    openLightbox: function(image) {
        if (!collage.imageBeingRotated) {
            var imageFile = $(image).attr('src');
            imageFile = imageFile.replace(/^slides\//, "")
            var imageCaption = $(image).attr('alt');
            $.colorbox({
                href: imageFile,
                maxWidth: "900px",
                maxHeight: "600px",
                title: imageCaption
            });
            return false;
        }
    },
    startRotate: function(e) {

        // Exit if the shift key wasn't held down when the mouse button was pressed
        if (!e.shiftKey)
            return;

        // Track the image that we're going to rotate
        collage.imageBeingRotated = this;

        // Store the angle of the mouse at the start of the rotation, relative to the image centre
        var imageCentre = collage.getImageCentre(collage.imageBeingRotated);
        var mouseStartXFromCentre = e.pageX - imageCentre[0];
        var mouseStartYFromCentre = e.pageY - imageCentre[1];
        collage.mouseStartAngle = Math.atan2(mouseStartYFromCentre, mouseStartXFromCentre);

        // Store the current rotation angle of the image at the start of the rotation
        collage.imageStartAngle = $(collage.imageBeingRotated).data('currentRotation');

        // Set up an event handler to rotate the image as the mouse is moved
        $(document).mousemove(collage.rotateImage);

        return false;
    },
    // Stop rotating an image

    stopRotate: function(e) {

        // Exit if we're not rotating an image
        if (!collage.imageBeingRotated)
            return;

        // Remove the event handler that tracked mouse movements during the rotation
        $(document).unbind('mousemove');

        // Cancel the image rotation by setting imageBeingRotated back to false.
        // Do this in a short while - after the click event has fired -
        // to prevent the lightbox appearing once the Shift key is released.
        setTimeout(function() {
            $.post(size_update_url, {
                id: $(collage.imageBeingRotated).attr("alt"),
                angle: $(collage.imageBeingRotated).data('currentRotation') * (180 / Math.PI),
            }, function(data) {

            });
            collage.imageBeingRotated = false;

        }, 10);


        return false;
    },
    rotateImage: function(e) {

        // Exit if we're not rotating an image
        if (!e.shiftKey)
            return;
        if (!collage.imageBeingRotated)
            return;

        // Calculate the new mouse angle relative to the image centre
        var imageCentre = collage.getImageCentre(collage.imageBeingRotated);
        var mouseXFromCentre = e.pageX - imageCentre[0];
        var mouseYFromCentre = e.pageY - imageCentre[1];
        var mouseAngle = Math.atan2(mouseYFromCentre, mouseXFromCentre);

        // Calculate the new rotation angle for the image
        var rotateAngle = mouseAngle - collage.mouseStartAngle + collage.imageStartAngle;

        // Rotate the image to the new angle, and store the new angle
        collage.children($(collage.imageBeingRotated)).css('transform', 'rotate(' + rotateAngle + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-moz-transform', 'rotate(' + rotateAngle + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-webkit-transform', 'rotate(' + rotateAngle + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-o-transform', 'rotate(' + rotateAngle + 'rad)');
        $(collage.imageBeingRotated).data('currentRotation', rotateAngle);

        return false;
    },
    // Calculate the centre point of a given image

    getImageCentre: function(image) {

        // Rotate the image to 0 radians
        $(image).css('transform', 'rotate(0rad)');
        $(image).css('-moz-transform', 'rotate(0rad)');
        $(image).css('-webkit-transform', 'rotate(0rad)');
        $(image).css('-o-transform', 'rotate(0rad)');

        // Measure the image centre
        var imageOffset = $(image).offset();
        var imageCentreX = imageOffset.left + $(image).width() / 2;
        var imageCentreY = imageOffset.top + $(image).height() / 2;

        // Rotate the image back to its previous angle
        var currentRotation = $(image).data('currentRotation');
        collage.children($(collage.imageBeingRotated)).css('transform', 'rotate(' + currentRotation + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-moz-transform', 'rotate(' + currentRotation + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-webkit-transform', 'rotate(' + currentRotation + 'rad)');
        collage.children($(collage.imageBeingRotated)).css('-o-transform', 'rotate(' + currentRotation + 'rad)');

        // Return the calculated centre coordinates
        return Array(imageCentreX, imageCentreY);
    },
    arrangeLeftParent: function(obj, left) {
        $(obj).parent().css('left', left + 'px');
    },
    arrangeTopParent: function(obj, top) {
        $(obj).parent().css('top', top + 'px');
    },
    children: function(obj) {
//        obj = $(obj).children().eq(0);
        return obj;
    },
    contexteMenu: function() {
        $("#lighttable").contextmenu({
            delegate: "img",
            menu: [
                {title: "Crop", cmd: "crop", },
                {title: "Scale", cmd: "scale"},
            ],
            select: function(event, ui) {
                console.log(ui.cmd);
                elem_id = $.trim($(ui.target[0]).attr("alt"));
                if (ui.cmd == "crop") {

                    $("#crop_" + elem_id).trigger("click");
                }
                else if (ui.cmd == "scale") {
                    $("#scale_" + elem_id).trigger("click");
                }
            }
        });
    },
    registerStep3Events: function() {
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

                deleteimages(this);
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

        //other scripts

        $('.edit_img').click(function(e) {
            console.log('ali');
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
                inline: true,
                href: "#inline_content",
                height: "auto",
                width: "auto",
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
    },
    registerStep1Events: function() {

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

        //other evetns

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
    }

    //



}

