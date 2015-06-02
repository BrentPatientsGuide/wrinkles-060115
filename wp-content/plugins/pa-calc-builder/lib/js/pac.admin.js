
jQuery(document).ready(function($) {

// **************************************************************
//  add more calc fields
// **************************************************************

    $('div#calc-field-rows').on('click', 'input#calc-clone', function() {

        // remove any existing messages
        $('#wpbody div#message').remove();

        // clone the fields
        var newfield = $('li.calc-empty-row.screen-reader-text').clone(true);

        // make it visible
        newfield.removeClass('calc-empty-row screen-reader-text');

        // and now insert it
        newfield.insertAfter('div#calc-field-rows li.calc-field-row:last');

        // add the class
        newfield.addClass('calc-field-row');

        // and move the cursor
        newfield.find('input.calc-title').focus();

    });

// **************************************************************
//  add more extras fields
// **************************************************************

    $('div#calc-field-extras').on('click', 'input#extra-clone', function() {

        // remove any existing messages
        $('#wpbody div#message').remove();

        // clone the fields
        var newfield = $('li.extra-empty-row.screen-reader-text').clone(true);

        // make it visible
        newfield.removeClass('extra-empty-row screen-reader-text');

        // and now insert it
        newfield.insertAfter('div#calc-field-extras li.extra-field-row:last');

        // add the class
        newfield.addClass('extra-field-row');

        // and move the cursor
        newfield.find('input.extra-label').focus();

    });


// **************************************************************
//  add more extras cake fields
// **************************************************************

    $('div#cake-fields').on('click', 'input#cake-clone', function() {

        // remove any existing messages
        $('#wpbody div#message').remove();

        // clone the fields
        var newfield = $('li.cake-empty-row.screen-reader-text').clone(true);

        // make it visible
        newfield.removeClass('cake-empty-row screen-reader-text');

        // and now insert it
        newfield.insertAfter('div#cake-fields li.calc-cake-row:last');

        // add the class
        newfield.addClass('calc-field-row');
        newfield.addClass('calc-cake-row');

        // and move the cursor
        newfield.find('input.extra-label').focus();

    });


//********************************************************
// remove extras fields
//********************************************************

    $('li.calc-cake-row').on('click', 'i.extra-row-remove', function() {
        $(this).parents('li.extra-field-row').find('input [type="text"]').val('');
        $(this).parents('li.extra-field-row').remove();
    });


//********************************************************
// remove calc fields
//********************************************************

    $('li.calc-field-row').on('click', 'i.calc-row-remove', function() {
        $(this).parents('li.calc-field-row').find('input [type="text"]').val('');
        $(this).parents('li.calc-field-row').remove();
    });

//********************************************************
// remove extras fields
//********************************************************

    $('li.extra-field-row').on('click', 'i.extra-row-remove', function() {
        $(this).parents('li.extra-field-row').find('input [type="text"]').val('');
        $(this).parents('li.extra-field-row').remove();
    });

//********************************************************
// check the thumbnail choice
//********************************************************

    $('div#calc-field-static').each(function() {

        // run on initial load
        $(this).find('input.fields-thumb').each(function() {

            var thumbexist = $(this).is(':checked');

            if (thumbexist === true)
                $('div#calc-field-rows span.thumb').show();

            if (thumbexist === false) {
                $('div#calc-field-rows span.thumb').hide();
                $('div#calc-field-rows li.calc-field-row span.thumb input').val('');
            }

        });

        // run on field click
        $(this).find('input.fields-thumb').change(function() {

            var thumbchange = $(this).is(':checked');

            if (thumbchange === true)
                $('div#calc-field-rows span.thumb').show('slow');

            if (thumbchange === false) {
                $('div#calc-field-rows span.thumb').hide('slow');
                $('div#calc-field-rows li.calc-field-row span.thumb input').val('');
            }

        });


    });

//********************************************************
// check for duplicates
//********************************************************

    // run the check on field change
    $('input.calc-title').change(function() {

        var current = $(this);

        $('input.calc-title').each(function() {

            if ($(this).val() == current.val()) {
                $(this).addClass('row-duplicate');
            } else {
                $(this).removeClass('row-duplicate');
                $(current).removeClass('row-duplicate');
            }

        });

    });


// **************************************************************
//  trigger class change on single checks for delete
// **************************************************************

    $('input.log-check').change(function() {

        var logrow = $(this).parents('tr');
        var checked = $(this).is(':checked');

        if (checked === true)
            $(logrow).addClass('remove-row');

        if (checked === false)
            $(logrow).removeClass('remove-row');

    });

    $('input.log-all').change(function() {

        var checked = $(this).is(':checked');

        if (checked === true)
            $('tr.pa-log-item').addClass('remove-row');

        if (checked === false)
            $('tr.pa-log-item').removeClass('remove-row');

    });

//********************************************************
// display the extra fields on log
//********************************************************

    $('tr.pa-log-item').on('click', 'span.view-log-extras', function() {
        $(this).next('div.extras-display').slideToggle('slow');
    });

// **************************************************************
//  delete log rows
// **************************************************************

    function logbutton_on() {
        $('img.delete-process').css('visibility', 'hidden');
        $('p.log-actions input.log-delete').removeAttr('disabled');
    }

    function logbutton_off() {
        $('p.log-actions img.delete-process').css('visibility', 'visible');
        $('p.log-actions input.log-delete').attr('disabled', 'disabled');
    }

    function restripeRows() {
        // remove existing
        $('table#pa-logfile-table tr.pa-log-item').each(function() {
            if ($(this).attr('style')) {
                $(this).remove();
            }

            $(this).removeClass('standard');
            $(this).removeClass('alternate');
        });
        // add back
        $('table#pa-logfile-table tr.pa-log-item:even').addClass('alternate');
        $('table#pa-logfile-table tr.pa-log-item:odd').addClass('standard');

    }

    $('p.log-actions').on('click', 'input.log-delete', function(event) {

        // remove any existing messages
        $('div#wpbody div#message').remove();
        $('div#wpbody div#setting-error-settings_updated').remove();

        // adjust buttons
        logbutton_off();

        var removeArr = '';

        $('tr.remove-row').each(function() {

            var itemnum = $(this).data('num');
            removeArr += itemnum + '|';
            // clean up the row in case they do multiple
            $(this).find('input.log-delete').prop('checked', false);

            $(this).removeClass('remove-row');
            $(this).hide('slow');

            // remove the 'all' checkbox in case
            $('th.check-column').find('input.log-all').prop('checked', false);

        });

        if (removeArr === '') {
            logbutton_on();
            $('div#wpbody h2:first').after('<div id="message" class="error below-h2 pac-message"><p>No items were selected.</p></div>');
            $('div.pac-message').delay(3000).fadeOut('slow');
            return false;
        }

        var data = {
            action: 'archive_log',
            items: removeArr
        };

        jQuery.post(ajaxurl, data, function(response) {

            logbutton_on();

            var obj;
            try {
                obj = jQuery.parseJSON(response);
            }
            catch (e) {
                $('div#wpbody h2:first').after('<div id="message" class="error below-h2 pac-message"><p>There was an error. Please try again.</p></div>');
                $('div.pac-message').delay(3000).fadeOut('slow');
            }

            if (obj.success === true) {
                $('p.log-counts').find('span.count-num').text(obj.remain);
                $('div#wpbody h2:first').after('<div id="message" class="pac-message updated below-h2"><p>' + obj.message + '</p></div>');
                $('div.pac-message').delay(3000).fadeOut('slow');
                // handle our restriping
                restripeRows();

            }

            else {
            }

        });

    });

// **************************************************************
//  update log rows with notes
// **************************************************************

    function update_on() {
        $('img.update-process').css('visibility', 'hidden');
        $('p.log-actions input.log-update').removeAttr('disabled');
    }

    function update_off() {
        $('p.log-actions img.update-process').css('visibility', 'visible');
        $('p.log-actions input.log-update').attr('disabled', 'disabled');
    }

    $('p.log-actions').on('click', 'input.log-update', function(event) {

        // remove any existing messages
        $('div#wpbody div#message').remove();
        $('div#wpbody div#setting-error-settings_updated').remove();

        // adjust buttons
        update_off();

        var update_items = {};

        $('tr.pa-log-item').each(function() {

            var field_val = $(this).find('textarea.notes-input').val();
            var field_id = $(this).data('num');

            update_items[field_id] = field_val;

        });

        // set up
        var data = {
            action: 'update_log',
            items: update_items
        };

        jQuery.post(ajaxurl, data, function(response) {

            update_on();

            var obj;
            try {
                obj = jQuery.parseJSON(response);
            }
            catch (e) {
                $('div#wpbody h2:first').after('<div id="message" class="error below-h2 pac-message"><p>There was an error. Please try again.</p></div>');
                $('div.pac-message').delay(3000).fadeOut('slow');
            }

            if (obj.success === true) {
                $('div#wpbody h2:first').after('<div id="message" class="pac-message updated below-h2"><p>' + obj.message + '</p></div>');
                $('div.pac-message').delay(3000).fadeOut('slow');

            }

            else if (obj.success === false) {
                $('div#wpbody h2:first').after('<div id="message" class="pac-message error below-h2"><p>' + obj.message + '</p></div>');
                $('div.pac-message').delay(3000).fadeOut('slow');
                return false;
            }

            else {
            }

        });

    });

//********************************************************
// you're still here? it's over. go home.
//********************************************************

});
