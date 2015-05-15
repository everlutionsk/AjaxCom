[![Build Status](https://scrutinizer-ci.com/g/everlutionsk/AjaxCom/badges/build.png?b=master)](https://scrutinizer-ci.com/g/everlutionsk/AjaxCom/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/everlutionsk/AjaxCom/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/everlutionsk/AjaxCom/?branch=master)

#AjaxCom
AjaxCom is a PHP library that allows developers to write their ajax code in PHP with minimal javascript.

###Demo
http://ajaxcom.everlution.sk/

##Features
- Append html to elements
- Prepend html to elements
- Replace elements with new html
- Set html of elements
- Set value of elements
- Display flash messages
- Display modals
- Change URL
- Call functions

##Requirements
- PHP >= 5.3.3
- jQuery >= 1.7.x

##Installation 
Via composer:

``` json
{
    "require": {
        "dm/ajaxcom": "dev-master"
    }
}
```

##Usage
###Javascript
Include the javascript library located at `src/DM/AjaxCom/Resources/public/js/ajaxcom.js`

Intercept all click events on anchors and submit events on forms:
``` javascript
$(document).ajaxcom();
```

Or just intercept those which have `data-ajaxcom`
``` javascript
$(document).ajaxcom('[data-ajaxcom]');
```

###PHP
``` php
use DM\AjaxCom\Handler;

if (isset($_SERVER['X-AjaxCom'])) {
    // Render page using AjaxCom library
    $handler = new Handler();
    // Change URL to /newurl
    $handler->changeUrl('/newurl');
    // Call funcname()
    $handler->callback('funcname');
    // Append some html to an element
    $handler->container('#table')
        ->append('<tr><td>This is a new row</td></tr>');
    // Replace element with some new html
    $handler->container('#something')
        ->replaceWith('<span id="somethingnew">Some text</span>');
    // Display modal
    $handler->modal(
        '<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body.</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </div>'
    );

    header('Content-type: application/json');
    echo json_encode($handler->respond());
} else {
    // Render page normally
}
```

