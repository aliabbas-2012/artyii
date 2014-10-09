
var jutils = {
    isMsie: function() {
        var match = /(msie) ([\w.]+)/i.exec(navigator.userAgent);
        return match ? parseInt(match[2], 10) : false;
    },
    isBlankString: function(str) {
        return !str || /^\s*$/.test(str);
    },
    escapeRegExChars: function(str) {
        return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    },
    isString: function(obj) {
        return typeof obj === "string";
    },
    isNumber: function(obj) {
        return typeof obj === "number";
    },
    isArray: $.isArray,
    isFunction: $.isFunction,
    isObject: $.isPlainObject,
    isUndefined: function(obj) {
        return typeof obj === "undefined";
    },
    bind: $.proxy,
    bindAll: function(obj) {
        var val;
        for (var key in obj) {
            $.isFunction(val = obj[key]) && (obj[key] = $.proxy(val, obj));
        }
    },
    indexOf: function(haystack, needle) {
        for (var i = 0; i < haystack.length; i++) {
            if (haystack[i] === needle) {
                return i;
            }
        }
        return -1;
    },
    each: $.each,
    map: $.map,
    filter: $.grep,
    every: function(obj, test) {
        var result = true;
        if (!obj) {
            return result;
        }
        $.each(obj, function(key, val) {
            if (!(result = test.call(null, val, key, obj))) {
                return false;
            }
        });
        return !!result;
    },
    some: function(obj, test) {
        var result = false;
        if (!obj) {
            return result;
        }
        $.each(obj, function(key, val) {
            if (result = test.call(null, val, key, obj)) {
                return false;
            }
        });
        return !!result;
    },
    mixin: $.extend,
    getUniqueId: function() {
        var counter = 0;
        return function() {
            return counter++;
        };
    }(),
    defer: function(fn) {
        setTimeout(fn, 0);
    },
    debounce: function(func, wait, immediate) {
        var timeout, result;
        return function() {
            var context = this, args = arguments, later, callNow;
            later = function() {
                timeout = null;
                if (!immediate) {
                    result = func.apply(context, args);
                }
            };
            callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) {
                result = func.apply(context, args);
            }
            return result;
        };
    },
    throttle: function(func, wait) {
        var context, args, timeout, result, previous, later;
        previous = 0;
        later = function() {
            previous = new Date();
            timeout = null;
            result = func.apply(context, args);
        };
        return function() {
            var now = new Date(), remaining = wait - (now - previous);
            context = this;
            args = arguments;
            if (remaining <= 0) {
                clearTimeout(timeout);
                timeout = null;
                previous = now;
                result = func.apply(context, args);
            } else if (!timeout) {
                timeout = setTimeout(later, remaining);
            }
            return result;
        };
    },
    tokenizeQuery: function(str) {
        return $.trim(str).toLowerCase().split(/[\s]+/);
    },
    tokenizeText: function(str) {
        return $.trim(str).toLowerCase().split(/[\s\-_]+/);
    },
    getProtocol: function() {
        return location.protocol;
    },
    noop: function() {}
};


function objEmpty(obj) {
    if (obj == null || obj == 'undefined' || obj == '') {
        return true;
    }

    return false;
}

function getRateString(obj) {
    if (objEmpty(obj)) {
        return '0%';
    }

    return obj.toString() + '%';
}

function getString(obj, limit) {
    var _limit = 0;
    var _strReturn = '';

    if (!objEmpty(limit)) {
        _limit = parseInt(limit);
    }

    if (!objEmpty(obj)) {
        _strReturn = obj.toString();
    }

    if (_limit > 0 && _strReturn.length > _limit) {
        _strReturn = _strReturn.substring(0, _limit) + '...';
    }

    return _strReturn;
}

function redirectTo(url) {
    if (url != 'undefined' && url != null && url != '') {
        window.location = url;
    }
    return false;
}

var overlayConfig = {
    top: 50,
    api: true,
    mask: {
        color: '#f0f0f0',
        loadSpeed: 200,
        opacity: 0.9
    },
    closeOnClick: true
}

function getParameterByName(name, strParams) {
    //strParams = '?' + strParams;
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\#&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(strParams);

    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function filterAjaxResponse(d) {
    if (typeof (d) == "string" && d != '') {
        d = JSON.parse(d);
    }

    // check if the response ask login
    if (d.response.authorized != null && d.response.authorized != 'undefined' && d.response.authorized == false) {
        redirectTo(siteUrl + '/user/signin');
        return false;
    }

    // check if there is any redirect demand
    if (d.response.redirectTo != null && d.response.redirectTo != 'undefined' && d.response.redirectTo != '') {
        redirectTo(d.response.redirectTo);
        return false;
    }

    return d;
}

function get_decimal_val(n) {
    var num = parseInt(n, 10);
    var dec = num - Math.floor(num);
    num = num - dec;
    return ("0" + num).slice(-2) + dec.toString().substr(1);
}

function digiclock_from_seconds(obj) {
    var t = parseInt(obj, 10);
    var d = Math.floor(t / (3600 * 24));
    t %= (3600 * 24);
    var h = Math.floor(t / 3600);
    t %= 3600;
    var m = Math.floor(t / 60);
    var s = Math.floor(t % 60);

    var output = (d > 0 ? d + ' day' + ((d > 1) ? 's ' : ' ') : '') + (get_decimal_val(h) + ':') + (get_decimal_val(m) + ':') + get_decimal_val(s);
    return output;
}

(function($) {
    function timeFromSeconds(obj) {
        var t = parseInt(obj, 10);
        $(this).data('original', t);
        var h = Math.floor(t / 3600);
        t %= 3600;
        var m = Math.floor(t / 60);
        var s = Math.floor(t % 60);

        var output = (h > 0 ? h + ' hour' + ((h > 1) ? 's ' : ' ') : '') +
        (m > 0 ? m + ' minute' + ((m > 1) ? 's ' : ' ') : '') +
        s + ' second' + ((s > 1) ? 's' : '');
        return output;
    }
    $.fn.time_from_seconds = function() {
        return this.each(function() {
            var t = parseInt($(this).text(), 10);
            $(this).data('original', t);
            var h = Math.floor(t / 3600);
            t %= 3600;
            var m = Math.floor(t / 60);
            var s = Math.floor(t % 60);

            var output = (h > 0 ? h + ' hour' + ((h > 1) ? 's ' : ' ') : '') +
            (m > 0 ? m + ' minute' + ((m > 1) ? 's ' : ' ') : '') +
            s + ' second' + ((s > 1) ? 's' : '');
            $(this).text(output);
        });
    };

    $.fn.showAjaxMessage = function(options) {
        var _handler = $(this);

        var settings = {
            html: 'Undefined',
            type: 'alert'
        };

        settings = $.extend(settings, options);

        if (settings.type == 'success') {
            _handler
            .addClass('alert')
            .removeClass('alert-danger')
            .addClass('alert-success')
            .removeClass('alert-info')
            .html(settings.html)
            .show();
        } else if (settings.type == 'error') {
            _handler
            .addClass('alert')
            .addClass('alert-danger')
            .removeClass('alert-success')
            .removeClass('alert-info')
            .html(settings.html)
            .show();
        } else {
            _handler
            .addClass('alert')
            .removeClass('alert-danger')
            .removeClass('alert-success')
            .removeClass('alert-info')
            .html(settings.html)
            .show();
        }
    };

    $.fn.callAjaxs = function(options) {
        var _handler = $(this);

        var settings = {
            url: '',
            data: {},
            dataType: 'json',
            crossDomain: false,
            global: true,
            processData: true,
            type: 'POST',
            respTo: $('<div>'),
            beforeSend: function() {
                settings.respTo.hide();
                _handler.show();
            },
            done: function(data, textStatus, jqXHR) {
                _handler.hide();
                settings.respTo.html(JSON.stringify(data)).show();
            },
            fail: function(jqXHR, textStatus, errorThrown) {
                _handler.hide();
                settings.respTo.html('Error: while processing the request <br/>' + errorThrown).show();
            },
            always: function(data, textStatus, jqXHR) {
            }
        };

        settings = $.extend(settings, options);

        var jqxhr = $.ajax({
            data: settings.data,
            url: settings.url,
            dataType: settings.dataType,
            crossDomain: settings.crossDomain,
            global: settings.global,
            processData: settings.processData,
            type: settings.type,
            beforeSend: settings.beforeSend
        })
        .done(settings.done)
        .fail(settings.fail)
        .always(settings.always);

        return jqxhr;
    };

    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);



var jTransport = function() {
    
    function jTransport(){
        this.handler = $('<div>');
        this.url = '';
        this.responseTo = $('<div>');
        this.data = {};
        this.dataType = 'json';
        this.crossDomain = false;
        this.global = false;
        this.processData = true;
        this.type = 'POST';
        
        this.beforeSend = function(){
            
        };
        
        this.done = function(data, textStatus, jqXHR){
            
        };
        
        this.fail = function(jqXHR, textStatus, errorThrown){
            
        };
        
        this.always = function(data, textStatus, jqXHR){
            
        };
    }
    
    jutils.mixin(jTransport.prototype, {
        sendRequest: function(){
            var that = this;
            return jXHR = $.ajax({
                data: that.data,
                url: that.url,
                dataType: that.dataType,
                crossDomain: that.crossDomain,
                global: that.global,
                processData: that.processData,
                type: that.type,
                beforeSend: that.beforeSend
            })
            .done(that.done)
            .fail(that.fail)
            .always(that.always);
        }
    });
    
    return jTransport;
}();


$(document).ready(function() {
    $('.btn-link').tooltip();
});