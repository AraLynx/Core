
let TDE = [];
let idFormat = 'id-ID';

//#region addition $ fn
    //#region $.textWidth
        (function($) {
            $.fn.textWidth = function(){
                let tempSpan = '<span style="display:none">' + $(this).text() + '</span>';
                $('body').append(tempSpan);
                let width = $('body').find('span:last').width();
                $('body').find('span:last').remove();
                return width;
            };
        })(jQuery);
    //#endregion $.textWidth

    //#region $.marquee
        (function($) {
            $.fn.marquee = function(args) {
                let element = $(this);

                args = $.extend(true, {
                    count: -1,
                    pxIncrement: 0.5,
                    speed: 10,
                    leftToRight: false,
                    start:true,
                    pause:false,
                    content: element.html(),
                }, args);

                let textWidth = element.textWidth(),
                    offset = element.width(),
                    width = offset,
                    existingCss = {
                        'text-indent' : element.css('text-indent'),
                        'overflow' : element.css('overflow'),
                        'white-space' : element.css('white-space')
                    },
                    marqueeCss = {
                        'text-indent' : width,
                        'overflow' : 'hidden',
                        'white-space' : 'nowrap'
                    },
                    loopCount = 0,
                    stopPosition = textWidth*-1,
                    dfd = $.Deferred();

                let status = "start";
                if(args.pause) status = "pause";
                if(!args.start) status = "stop";

                element.html(args.content);
                element.attr("data-status",status);

                function start() {
                    if(!element.length){//NO TEXT
                        return dfd.reject();
                    }

                    //if(element.css('overflow')!="hidden") {
                    if(element.attr("data-status") != "start"){
                        //element.css(existingCss);
                        return false;
                    }

                    //console.log("continue");
                    if(width == stopPosition) {
                        loopCount++;
                        if(loopCount == args.count) {
                            element.css(existingCss);
                            return dfd.resolve();
                        }
                        if(args.leftToRight) {
                            width = textWidth*-1;
                        } else {
                            width = offset;
                        }
                    }

                    element.css('text-indent', width + 'px');

                    if(args.leftToRight) {
                        width = width + args.pxIncrement;
                    } else {
                        width = width - args.pxIncrement;
                    }

                    setTimeout(start, args.speed);
                };
                function pause(){
                    element.attr("data-status","pause");
                };
                function stop(){
                    element.attr("data-status","stop");
                    element.css(existingCss);
                };

                if(args.leftToRight) {
                    width = textWidth*-1;
                    width++;
                    stopPosition = offset;
                } else {
                    width--;
                }

                if(status == "start"){
                    element.css(marqueeCss);
                    start();
                }
                if(status == "pause"){
                    pause();
                }
                if(status == "stop"){
                    stop();
                }

                return dfd.promise();
            };
        })(jQuery);
    //#endregion $.marquee
//#endregion

$(document).ready(function(){
    $(".invalid-feedback").show();
    $(".invalid-feedback").html("&nbsp;");

    $(".tde-box").addClass("border rounded border-secondary p-1");
    $(".tde-box-2").addClass("border rounded border-secondary p-2");
    $(".tde-box-3").addClass("border rounded border-secondary p-3");
    $(".tde-box-4").addClass("border rounded border-secondary p-4");
    $(".tde-box-5").addClass("border rounded border-secondary p-5");

    $("*").dblclick(function(e){
        e.preventDefault();
    });
});
//#region addition function
    function getFuncName() {
        return getFuncName.caller.name;
    }

    function formatNumber(number){
        return number.toLocaleString(idFormat);
    }
    function rupiah(nominal){
        const currency = new Intl.NumberFormat(idFormat, {style: "currency",currency: "IDR", minimumFractionDigits: 0});
        return currency.format(nominal);
    }

//#endregion

//#region string
    String.prototype.replaceLineBreak = function(relaceWith){
        if(relaceWith === undefined){
            relaceWith = "<br/>";
        }
        return this.replace(/(\r\n|\r|\n)/g, relaceWith);
    }
//#endregion
