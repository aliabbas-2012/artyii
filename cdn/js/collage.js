var collage = {
    upload_img_obj: {},
    getBackgroundHTml: function(data) {
        html_with_scale = '<div class="ui-resizable-handle ui-resizable-nw" id="nwgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-ne" id="negrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-sw" id="swgrip"></div>' +
                '<div class="ui-resizable-handle ui-resizable-se" id="segrip"></div>';
        style = "style='width:" + data['all_result']['width'] + "px;height:" + data['all_result']['height'] + "px;'";
        html = "<h3>" + data['all_result']['dimension_type'] + "</h3>";
        html += "<div class='image_part' '" + style + "'>";
        html += data.cropped_image;
        html += html_with_scale;
        html += "</div>";

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
    }
}

