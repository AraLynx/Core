//alert('loaded');
$(document).ready(function(){
     GenerateCoordinateApplication();
});
$(window).resize(function() {
    GenerateCoordinateApplication();
});
function GenerateCoordinateApplication(){
    var radius = 160;
    var imageDimmesion = 100;
    var winH = $(document).height();
    var winW = $(window).width();

    var centerH = winH/2; //456
    var centerW = winW/2; //951.5

    //alert(centerH);alert(centerW);

    var applicationsH = $("#applications").height();
    var applicationsW = $("#applications").width();

    $("#hrefUranus").css('top', (winH - $("#hrefUranus").height()) / 2);
    $("#hrefUranus").css('left', (winW - $("#hrefUranus").width()) / 2);

    //alert($("#applications ul").length);

    var degree = 360 / $(".application").length;
    var nowDegree = 0;
    $('.application').each(function() {
        var elementId = this.id;

        var radians = nowDegree*Math.PI/180;

        var sin = Math.sin(radians) * radius;
        var cos = Math.cos(radians) * radius;

        var y = centerH - cos - (imageDimmesion/2);
        var x = centerW + sin - (imageDimmesion/2);

        $("#"+elementId).css('top',y);
        $("#"+elementId).css('left',x);

        nowDegree += degree;
    });
}
