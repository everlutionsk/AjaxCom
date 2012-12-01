// ajaxcom.js
// https://github.com/advertize/AjaxCom
(function($) {
    // Intercept click and submit events and perform an ajax request then
    // handle instructions returned
    //
    // Exported as $.fn.ajaxcom
    //
    // Returns the jQuery object
    function fnAjaxcom(selector, options) {
        var context = this;
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
        var defaults = {
            dataType: 'json'
        };
        options = $.extend(true, {}, $.ajaxSettings, defaults, options);

        options.beforeSend = function(xhr, settings) {
            xhr.setRequestHeader('X-AjaxCom', 'true');
        }

        options.success = function(data, status, xhr) {
            if (data.ajaxcom) {
                $.each(data.ajaxcom, function(index, operation) {
                    handleOperation(operation);
                });
            }
        }

        return $.ajax(options);
    }

    // Handle click events
    //
    // Exported as $.ajaxcom.click
    function handleClick(event, container, options)
    {
        // Middle, cmd, ctrl, shift, alt clicks shouod open in a new tab as normal
        if (event.which>1 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        var link = event.currentTarget;
        if (link.tagName.toUpperCase()!=='A') {
            throw "$.fn.ajaxcom requires an anchor element";
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
    function handleSubmit(event, container, options)
    {
        console.warn('handleSubmit is not yet implemented');
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
        console.warn('doModal is not yet implement');
    }

    // Handle change urls
    function handleChangeUrl(options) {
        console.warn('doChangeUrl is not yet implement');
    }

    // Handle callbacks
    function handleCallback(options) {
        console.warn('doCallback is not yet implement');
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
            default:
                throw "Container method " + options.method + " is not supported";
                break;
        }

        function replaceWith() {
            $(options.target).replaceWith(options.value);
        }
        function append() {
            $(options.target).append(options.value);
        }
        function prepend() {
            $(options.target).prepend(options.value);
        }
        function html() {
            $(options.target).html(options.value);
        }
        function val() {
            $(options.target).val(options.value);
        }
    }

    $.fn.ajaxcom = fnAjaxcom;
    $.ajaxcom = ajaxcom;
    $.ajaxcom.click = handleClick;
    $.ajaxcom.submit = handleSubmit;
})(jQuery);
