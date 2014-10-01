var mainlim = 100;
var limit = mainlim;
var offset = 0;
var qstring ='';
var uid =0;
var tco ='';
var ordercriteria =1;
function loadmyreport() {
    $.post(JBASE_URL + '/admin/getmyreports', {
        offset: offset,
        limit: limit,
        qstring:qstring,
        uid:uid,
        ordercriteria:ordercriteria,
        tco:tco
    }, function(data) {
        if (typeof (data) == "string" && data != '') {
            data = JSON.parse(data);
        }
        if (data.success === true) {
            if (data.items.length > 0) {
                if (data.items.length >= limit) {
                    $('#seemore').removeClass('disnone');  
                }
                $("#tmpl_show_my_report").addMyTests(data.items, false);
                offset = offset + data.items.length;
                $('#seemore').removeClass('disnone');
            } else {
                $('#seemore').addClass('disnone');
            }
        }
        else {

        }

    }, "json");
}
$.fn.addMyTests = function(data) {
    var tmpl_tests = $(this).tmpl(data);
    tmpl_tests.appendTo("#append_grid_report");
    $("#append_grid_report").show();
}
$(document).ready(function() {
    
    $('#seemore').addClass('disnone');
    loadmyreport();
    $('#viewmoretest').live("click",function(e){
        $('#seemore').addClass('disnone');
        loadmyreport();
        e.stopImmediatePropagation();
    });
    
    $( "#tg_order" ).change(function() {
        $('#append_grid_report').html("");
        limit = mainlim;
        offset = 0;
        ordercriteria = $( "#tg_order" ).val();
        loadmyreport();
    });
    
    $( "#tg_user" ).change(function() {
        $('#append_grid_report').html("");
        limit = mainlim;
        offset = 0;
        uid = $( "#tg_user" ).val();
        loadmyreport();
    });
    $("#tg_cou").change(function() {
        $('#append_grid_report').html("");
        limit = mainlim;
        offset = 0;
        tco = $("#tg_cou").val();
        loadmyreport();
    });
    
    $('#btnSt').live("click",function(e){
        $('#append_grid_report').html("");
        $('#seemore').addClass('disnone');
        limit = mainlim;
        offset = 0;
        qstring = $( "#txtSearchBrand" ).val();
        loadmyreport();
        e.stopImmediatePropagation();
    });
    
    
});
