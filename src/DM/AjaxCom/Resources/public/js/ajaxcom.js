// ajaxcom.js
// https://github.com/advertize/AjaxCom
(function($) {
    "use strict";

    $.ajaxcomProperties = {isPopstateEvent: false};

    var ajaxcomStackOptions = {};
    var ajaxcomLastPushId = null;

    $.event.props.push('state');
    $(window).on('popstate.ajaxcom', function(event) {
        if (typeof event.state === 'object' && event.state !== null) {
            if (event.state.ajaxcomPushId == null || ajaxcomStackOptions[ajaxcomLastPushId] == undefined) {
                window.location.reload();
            } else {
                $.ajaxcomProperties.isPopstateEvent = true;
                ajaxcomStackOptions[ajaxcomLastPushId]['scrollTop'] = $(document).scrollTop();
                ajaxcomLastPushId = event.state.ajaxcomPushId;

                var firstOnComplete = {};
                if (ajaxcomStackOptions[ajaxcomLastPushId]['scrollTop'] != null) {
                    firstOnComplete = {firstOnComplete: function (){
                        $(document).scrollTop(ajaxcomStackOptions[ajaxcomLastPushId]['scrollTop']);
                    }};
                }

                ajaxcom($.extend(true, {}, ajaxcomStackOptions[ajaxcomLastPushId]['options'], firstOnComplete));
            }
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
        var ajaxcomOptions = $.extend(true, {}, options);
        var customBeforeSend = options.beforeSend;
        delete options.beforeSend;
        var customSuccess = options.success;
        delete options.success;
        var customComplete = options.complete;
        delete options.complete;
        if (typeof options.firstOnComplete != 'undefined') {
            var customFirstOnComplete = options.firstOnComplete;
            delete options.firstOnComplete;
        }

        var defaults = {
            dataType: 'json',
            beforeSend : function(xhr, settings){
                doAutodisableButton(true, options);
                //Running external definition

                if (typeof customBeforeSend === 'function') {
                    customBeforeSend(xhr, settings, options);
                }

                xhr.setRequestHeader('X-AjaxCom', 'true');
                xhr.setRequestHeader('Accept', 'application/json');
            },
            success : function(data, status, xhr){
                //Running external definition
                if (typeof customSuccess === 'function') {
                    customSuccess(data, status, xhr, options);
                }

                if (data.ajaxcom) {
                    $.each(data.ajaxcom, function(index, operation) {
                        handleOperation(operation, ajaxcomOptions);
                    });
                }
            },
            complete : function(jqXHR, textStatus){
                doAutodisableButton(false, options);
                if (typeof customFirstOnComplete != 'undefined') {
                    customFirstOnComplete(jqXHR, textStatus, options);
                }

                if (typeof customComplete === 'function') {
                    customComplete(jqXHR, textStatus, options);
                }

                $.ajaxcomProperties.isPopstateEvent = false;
            }
        };

        options = $.extend(true, {}, $.ajaxSettings, defaults, options);
        return $.ajax(options);
    }

    function ajaxcomIsPopEvent() {
        return $.ajaxcomProperties.isPopstateEvent;
    }

    /*
     *
     * param boolean disabled
     * param json options
     */
    function doAutodisableButton(disabled, options)
    {
        if (options.submitButton) {
            $(options.submitButton).prop('disabled', disabled);
        }
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
        var locationHost = "";
        if (location.port !== "") {
            locationHost = location.hostname + ":" +  location.port;
        } else {
             if (location.protocol == "https:") {
                locationHost = location.hostname + ":443";
             } else {
                locationHost = location.hostname + ":80";
             }
        }

        var linkHost = "";
        if (link.port !== "") {
            linkHost = link.hostname + ":" +  link.port;
        } else {
             if (link.protocol == "https:") {
                linkHost = link.hostname + ":443";
             } else {
                linkHost = link.hostname + ":80";
             }
        }

        if (location.protocol!==link.protocol || locationHost!==linkHost) {
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
            url: link.href,
            element: event.currentTarget
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
        //Find the button which launched the event
        var submitButton = $(form).find("[data-ajaxcom-autodisable]");

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
            data: data,
            submitButton: submitButton.length > 0? submitButton : null,
            element: event.currentTarget
        };

        ajaxcom($.extend({}, defaults, options));

        event.preventDefault();
    }

    // Delegates operations to their handler
    function handleOperation(operation, ajaxcomOptions) {
        switch (operation.operation) {
            case 'container':
                handleContainer(operation.options)
                break;
            case 'modal':
                handleModal(operation.options);
                break;
            case 'changeurl':
                handleChangeUrl(operation.options, ajaxcomOptions);
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
            case 'twitterbootstrap3':
                twitterbootstrap3();
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

        /**
         * modals background not closing with bootstrap3
         */
        function twitterbootstrap3() {
            if (options.close === true) {
                $('.modal').last().modal('hide');
            } else {
                var $html = $(options.html);
                $('body').append($html);
                $('.modal').last().modal();
                if (options.autoremove) {
                    $('.modal').last().on('hidden.bs.modal', function (e) {
                        $(this).remove();
                    });
                }
            }
        }
    }

    // Handle change urls
    function handleChangeUrl(options, ajaxcomOptions) {
        var changeUrl = function() {};

        switch (options.method) {
            case 'push':
                if ($.ajaxcomProperties.isPopstateEvent) {
                    break;
                }

                var scrollPosition = $(document).scrollTop();

                changeUrl = function() {
                    // this condition is needed to prevent form resubmiting
                    var currentUrlHref = window.location.href + window.location.search;
                    var currentUrlPath = window.location.pathname + window.location.search;
                    if (currentUrlHref != options.url
                        && currentUrlPath != options.url
                        ) {
                        if (ajaxcomLastPushId != null) {
                            ajaxcomStackOptions[ajaxcomLastPushId]['scrollTop'] = scrollPosition;
                        }
                        ajaxcomLastPushId = new Date().getTime() + options.url;
                        ajaxcomStackOptions[ajaxcomLastPushId] = {options: ajaxcomOptions};
                        history && history.pushState && history.pushState(
                            {
                                ajaxcomPushId: ajaxcomLastPushId
                            },
                            null,
                            options.url
                        );
                    }
                };

                break;
            case 'replace':
                changeUrl = function() {
                    history && history.replaceState && history.replaceState({}, null, options.url);
                };

                break;
            case 'redirect':
                changeUrl = function() {
                    window.location.href = options.url;
                };

                break;
            default:
                throw "ChangeUrl method " + options.method + " is not supported";
                break;
        }

        (options.wait > 0) ? setTimeout(changeUrl, options.wait) : changeUrl();
    }

    // Handle callbacks
    function handleCallback(options) {
        if ($.isFunction(window[options.callFunction])) {
            window[options.callFunction](options.params);
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
            case 'addClass':
                addClass();
                break;
            case 'removeClass':
                removeClass();
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
