// ajaxcom.js
// https://github.com/advertize/AjaxCom
(function($) {
    "use strict";

    $.event.props.push('state');
    $(window).on('popstate.ajaxcom', function(event) {
        if (typeof event.state === 'object' && event.state !== null) {
            window.location.reload();
        }
    });
    history && history.replaceState && history.replaceState({}, null);

    // Intercept click and submit events and perform an ajax request then
    // handle instructions returned
    //
    // Exported as $.fn.ajaxcom
    //
    // Returns the jQuery object
    function fnAjaxcom(selector, options) {
        if (!selector) {
            selector = 'a, form';
        }
        this.on('click', selector, function(event) {
            var opts = $.extend({}, options);
            handleClick(event, opts);
        });
        this.on('submit', selector, function(event) {
            var opts = $.extend({}, options);
            opts.triggerElement = this;
            handleSubmit(event, opts);
        });
        return this;
    }

    // Does the ajax request
    //
    // Exported as $.ajaxcom
    //
    // Returns the same as $.ajax
    function ajaxcom(options) {
        var defaults = {
            dataType: 'json',
            beforeSend : function(xhr, settings){
                if ($(options.triggerElement).attr('multi-submission') === 'false'){
                    $(options.triggerElement).find('input[type=submit]').attr('disabled', 'disabled');
                }
                xhr.setRequestHeader('X-AjaxCom', 'true');
            },
            success : function(data, status, xhr){
                if (data.ajaxcom) {
                    $.each(data.ajaxcom, function(index, operation) {
                        handleOperation(operation);
                    });
                }
            },
            complete : function(jqXHR, textStatus){
                if ($(options.triggerElement).attr('multi-submission') === 'false'){
                    $(options.triggerElement).find('input[type=submit]').removeAttr('disabled');
                }
            }
        };
        
        
        options = $.extend(true, {}, $.ajaxSettings, defaults, options);

        //If exists a definition, runs the external function and then the bit defined in defaults
        var preBeforeSend = options.beforeSend;
        options.beforeSend = (typeof preBeforeSend === 'function')?
                function(xhr, settings) {
                    preBeforeSend(xhr, settings);
                    defaults.beforeSend(xhr, settings);
                }
                : defaults.beforeSend;
        
        //If exists a definition, runs the external function and then the bit defined in defaults
        var preSuccess = options.success;
        options.success = (typeof preSuccess === 'function')?
            function(data, status, xhr) {
                preSuccess(data, status, xhr);
                defaults.success(data, status, xhr);
            }
            : defaults.success;
        //If exists a definition, runs the external function and then the bit defined in defaults
        var preComplete = options.complete;
        options.complete = (typeof preComplete === 'function')?
            function(jqXHR, textStatus) {
                preComplete(jqXHR, textStatus);
                defaults.complete(jqXHR, textStatus);
            }
            : defaults.complete;
        
        return $.ajax(options);
    }

    // Handle click events
    //
    // Exported as $.ajaxcom.click
    function handleClick(event, options)
    {
        // Middle, cmd, ctrl, shift, alt clicks should open in a new tab as normal
        if (event.which>1 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        var link = event.currentTarget;

        // Ignore non anchor elements
        if (link.tagName.toUpperCase()!=='A') {
            return;
        }

        // Ignore external links
        if (location.protocol!==link.protocol || location.host!==link.host) {
            return;
        }

        // Ignore anchors on the same page
        if (link.hash && link.href.replace(link.hash, '')===location.href.replace(location.hash, '')) {
            return;
        }

        // Ignore empty anchors
        if (link.href===location.href + '#') {
            return;
        }

        var defaults = {
            url: link.href
        };

        ajaxcom($.extend({}, defaults, options));

        event.preventDefault();
    }

    // Handle submit events
    //
    // Exported as $.ajaxcom.submit
    function handleSubmit(event, options)
    {
        var form = event.currentTarget;

        // Ignore nonform elements
        if (form.tagName.toUpperCase()!=='FORM') {
            return;
        }

        var data = $(form).serializeArray();
        $(form).find('input[type=file]').each(function(index, value) {
            data.push({
                name: $(value).attr('name'),
                value: $(value).val()
            });
        });

        var defaults = {
            type: form.method,
            url: form.action,
            data: data
        }

        ajaxcom($.extend({}, defaults, options));

        event.preventDefault();
    }

    // Delegates operations to their handler
    function handleOperation(operation) {
        switch (operation.operation) {
            case 'container':
                handleContainer(operation.options)
                break;
            case 'modal':
                handleModal(operation.options);
                break;
            case 'changeurl':
                handleChangeUrl(operation.options);
                break;
            case 'callback':
                handleCallback(operation.options);
                break;
            default:
                throw "Operation " + operation.operation + " is not supported";
                break;
        }
    }

    // Handle modals
    function handleModal(options) {
        switch (options.type) {
            case 'twitterbootstrap':
                twitterbootstrap();
                break;
            default:
                throw "Modal type " + options.type + " is not supported";
                break;
        }

        function twitterbootstrap() {
            if (options.close === true) {
                $(options.html).modal('hide');
            } else {
                var $html = $(options.html);
                $html.modal();
                if (options.autoremove) {
                    $html.on('hidden', function(event) {
                        $(this).remove();
                    });
                }
            }
        }
    }

    // Handle change urls
    function handleChangeUrl(options) {
        console.warn('handleChangeUrl is not yet fully implement');
        switch (options.method) {
            case 'push':
                setTimeout(function() {
                    history && history.pushState && history.pushState({}, null, options.url);
                }, options.wait);
                break;
            case 'replace':
                setTimeout(function() {
                    history && history.replaceState && history.replaceState({}, null, options.url);
                }, options.wait);
                break;
            case 'redirect':
                setTimeout(function() {
                    window.location.href = options.url;
                }, options.wait);
                break;
            default:
                throw "ChangeUrl method " + options.method + " is not supported";
                break;
        }
    }

    // Handle callbacks
    function handleCallback(options) {
        if ($.isFunction(window[options.callFunction])) {
            window[options.callFunction](options.params);
        } else {
            console.warn('Callback ' + options.callFunction + ' is not a function');
        }
    }

    // Handle containers
    function handleContainer(options) {
        switch (options.method) {
            case 'replaceWith':
                replaceWith();
                break;
            case 'append':
                append();
                break;
            case 'prepend':
                prepend();
                break;
            case 'html':
                html();
                break;
            case 'val':
                val();
                break;
            case 'remove':
                remove();
                break;
            default:
                throw "Container method " + options.method + " is not supported";
                break;
        }

        function removeClass() {
            if (options.removeClass) {
                $(options.target).removeClass(options.removeClass);
            }
        }

        function addClass() {
            if (options.addClass) {
                $(options.target).addClass(options.addClass);
            }
        }

        function replaceWith() {
            var $element = $(options.value);
            $element.hide();
            if (options.animate===true) {
                $(options.target).fadeOut(600, function() {
                    $(options.target).replaceWith($element);
                    $element.fadeIn(600);
                });
            } else {
                $(options.target).replaceWith($element.show());
            }
        }
        function append() {
            
            if (options.animate===true) {
                var $element = $(options.value);
                $element.hide();
                $(options.target).append($element);
                $element.fadeIn(600);
            } else {
                $(options.target).append(options.value);
            }
        }
        function prepend() {
           
            if (options.animate===true) {
                var $element = $(options.value);
                $element.hide();
                $(options.target).prepend($element);
                $element.fadeIn(600);
            } else {
                $(options.target).prepend(options.value);
            }
        }
        function html() {
            if (options.animate===true) {
                $(options.target).fadeOut(600, function() {
                    $(options.target).html(options.value);
                    removeClass();
                    addClass();
                    $(options.target).fadeIn(600);
                });
            } else {
                $(options.target).html(options.value);
                removeClass();
                addClass();
            }
        }
        function val() {
            $(options.target).val(options.value);
            removeClass();
            addClass();
        }
        function remove() {
            if (options.animate===true) {
                $(options.target).fadeOut(600, function() {
                    $(options.target).remove();
                });
            } else {
                $(options.target).remove();
            }
        }
    }

    $.fn.ajaxcom = fnAjaxcom;
    $.ajaxcom = ajaxcom;
    $.ajaxcom.click = handleClick;
    $.ajaxcom.submit = handleSubmit;
})(jQuery);
