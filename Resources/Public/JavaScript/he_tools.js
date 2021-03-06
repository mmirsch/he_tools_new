
$.fn.extend({
    bindWithDelay: function( type, data, fn, timeout, throttle ) {

        if ( $.isFunction( data ) ) {
            throttle = timeout;
            timeout = fn;
            fn = data;
            data = undefined;
        }

        // Allow delayed function to be removed with fn in unbind function
        fn.guid = fn.guid || ($.guid && $.guid++);

        // Bind each separately so that each element has its own delay
        return this.each(function() {

            var wait = null;

            function cb() {
                var e = $.extend(true, { }, arguments[0]);
                var ctx = this;
                var throttler = function() {
                    wait = null;
                    fn.apply(ctx, [e]);
                };

                if (!throttle) { clearTimeout(wait); wait = null; }
                if (!wait) { wait = setTimeout(throttler, timeout); }
            }

            cb.guid = fn.guid;

            $(this).bind(type, data, cb);
        });
    }
});

function processingAnimation(mode,message) {
    var aHeight = $(window).height();
    var aWidth = $(window).width();

    if (mode=='start') {
        if ($('#spinOverlay').size()==0) {
            $('body').append('<div id="spinOverlay"></div>');
            $('#spinOverlay').css('height', aHeight).css('width', aWidth);
            if (message) {
                $('#spinOverlay').append('<div id="spinOverlayMessage">' + message + '</div>');
                var left = Math.ceil((aWidth - $('#spinOverlayMessage').width()) / 2);
                var top = Math.ceil((aHeight - $('#spinOverlayMessage').height()) / 2)+30;
                $('#spinOverlayMessage').css('left', left).css('top', top);
            }
        }
        $('#spinOverlay').show();
    } else if (mode=='stop') {
        if ($('#spinOverlay')) {
            $('#spinOverlay').remove();
        }
        if ($('#spinOverlayMessage')) {
            $('#spinOverlayMessage').remove();
        }
    }
}

function listAjax(filter, div) {
    var ajaxUrl = $('#ajax_url').val();
    var returnUrl = $('#return_url').val();

    $.ajax({
        url: ajaxUrl,
        type: 'GET',
        dataType: 'html',
        data: {
            filter: filter,
            returnUrl: returnUrl,
        },
        beforeSend : function(){
            processingAnimation('start','bitte warten');
        },
        success: function (result) {
            $('#' + div).html(result);
        },
        error: function (error) {
            $('#' + div).html(error);
        }
    }).always(function() {
        processingAnimation('stop');
    });
}

$(document).ready(function() {

    $('#be_users_search_filter').bindWithDelay('keyup', function (event) {
        var filter = $('#be_users_search_filter').val();
        var div = 'be_userlist';
        listAjax(filter, div);
    },300);

    $('#fe_users_search_filter').bindWithDelay('keyup', function (event) {
        var filter = $('#fe_users_search_filter').val();
        var div = 'fe_userlist';
        listAjax(filter, div);
    },300);

});

