var collage = {
    upload_img_obj: {},
    getBackgroundHTml: function(data) {
        html_with_scale:'<div class="ui-resizable-handle ui-resizable-nw" id="nwgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-ne" id="negrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-sw" id="swgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-se" id="segrip"></div>';
        style:"style='width:" + data['all_result']['width'] + "px;height:" + data['all_result']['height'] + "px;'";
        html = "<h3>" + data['all_result']['dimension_type'] + "</h3>";
        html += "<div class='image_part' '" + style + "'>";
        html += data.cropped_image;
        html += html_with_scale;
        html += "</div>";
    },
    resizableBackgroundImage: function() {
        id:$(".image_container>div img").attr("alt");
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
    //drag and rotate
    newImageZIndex: 1, // To make sure newly-loaded images land on top of images on the table
    loaded: false, // Used to prevent initPhotos() running twice
    imageBeingRotated: false, // The DOM image currently being rotated (if any)
    mouseStartAngle: false, // The angle of the mouse relative to the image centre at the start of the rotation
    imageStartAngle: false,
    element_tob_rotate: "#lighttable",
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
        $(collage.element_tob_rotate+' img').each(function(index) {

            // Set a random position and angle for this photo
            var left = Math.floor(Math.random() * 450 + 100);
            var top = Math.floor(Math.random() * 100 + 100);
            var angle = Math.floor(Math.random() * 60 - 30);
//            
//            $(this).css('left', left + 'px');
//            $(this).css('top', top + 'px');
            
//            $(this).css('transform', 'rotate(' + angle + 'deg)');
//            $(this).css('-moz-transform', 'rotate(' + angle + 'deg)');
//            $(this).css('-webkit-transform', 'rotate(' + angle + 'deg)');
//            $(this).css('-o-transform', 'rotate(' + angle + 'deg)');
            $(this).data('currentRotation', angle * Math.PI / 180);
//            
            // Make the photo draggable
            $(this).draggable({containment: 'parent', stack: collage.element_tob_rotate+' img', cursor: 'pointer', start: collage.dragStart});
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
                // Record the photo's true dimensions
                var imgWidth = $(this).width();
                var imgHeight = $(this).height();
                
//                // Make the photo bigger, so it looks like it's high above the table
//                $(this).css('width', imgWidth * 1.5);
//                $(this).css('height', imgHeight * 1.5);
//                // Make it completely transparent, ready for fading in
//                $(this).css('opacity', 0);
//                // Make sure its z-index is higher than the photos already on the table
//                $(this).css('z-index', collage.newImageZIndex++);
//                // Gradually reduce the photo's dimensions to normal, fading it in as we go
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
    openLightbox: function(image) {
        if (!collage.imageBeingRotated) {
            var imageFile = $(image).attr('src');
            imageFile = imageFile.replace(/^slides\//, "")
            var imageCaption = $(image).attr('alt');
            $.colorbox({
                href: 'slides-big/' + imageFile,
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
        $(collage.imageBeingRotated).css('transform', 'rotate(' + rotateAngle + 'rad)');
        $(collage.imageBeingRotated).css('-moz-transform', 'rotate(' + rotateAngle + 'rad)');
        $(collage.imageBeingRotated).css('-webkit-transform', 'rotate(' + rotateAngle + 'rad)');
        $(collage.imageBeingRotated).css('-o-transform', 'rotate(' + rotateAngle + 'rad)');
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
        $(collage.imageBeingRotated).css('transform', 'rotate(' + currentRotation + 'rad)');
        $(collage.imageBeingRotated).css('-moz-transform', 'rotate(' + currentRotation + 'rad)');
        $(collage.imageBeingRotated).css('-webkit-transform', 'rotate(' + currentRotation + 'rad)');
        $(collage.imageBeingRotated).css('-o-transform', 'rotate(' + currentRotation + 'rad)');

        // Return the calculated centre coordinates
        return Array(imageCentreX, imageCentreY);
    }

}

