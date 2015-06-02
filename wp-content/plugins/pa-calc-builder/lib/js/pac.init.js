//********************************************************
// function for calculating heights
//********************************************************

function equalHeight(group) {
    var tallest = 0;
    group.each(function() {
        var thisHeight = jQuery(this).height();
        if (thisHeight > tallest) {
            tallest = thisHeight;
        }
    });
    group.height(tallest);
}

// **************************************************************
//  enable or disable submit if error triggered
// **************************************************************

function button_enable(submit_id) {
    if (jQuery(submit_id).length)
    {
        jQuery(submit_id).removeAttr('disabled');
        jQuery(submit_id).removeClass('submit-disabled');
        jQuery(submit_id).css('opacity', '1');
    }
}

function button_disable(submit_id) {
    if (jQuery(submit_id).length)
    {
        jQuery(submit_id).addClass('submit-disabled');
        jQuery(submit_id).attr('disabled', 'disabled');
        jQuery(submit_id).css('opacity', '0.6');
    }
}
//Intentionaly diabling submit button to stop accedential submission before document is completly loaded
button_disable('input#pa-submit');
button_disable('input#pa-calculate');
//********************************************************
// now start the engine
//********************************************************
jQuery(document).ready(function($) {

    button_enable('input#pa-submit');
    button_enable('input#pa-calculate');

//********************************************************
// set equal height where appropriate
//********************************************************

    /*
     $('div.pa-final-steps div.pa-return-column').each(function() {
     
     equalHeight($('div.pa-column-inner-wrap'));
     
     });
     
     */

// **************************************************************
//  trigger checkbox if thumbnail is clicked
// **************************************************************

    $('ul.calc-field-group').on('click', 'img.calc-thumb', function(event) {

        var option = $(this).parents('li').find('input');
        var checked = $(this).parents('li').find('input').is(':checked');

        $(this).toggleClass('checked');
        $(this).parent().find('label').toggleClass('checked');

        if (checked === true)
            $(option).prop('checked', false);

        if (checked === false)
            $(option).prop('checked', true);

    });


// **************************************************************
//  Add checked class to checked label and thumb
// **************************************************************

    $('ul.calc-field-group input').change(function() {

        $(this).parent('label').toggleClass('checked');

        $(this).parent('label').next('.calc-thumb').toggleClass('checked');


    });

// **************************************************************
//  mark provider list item if unchecked
// **************************************************************

    function doctor_include(id) {
        // add back the value from the field
        $('div.pa-cost-form').find('input[data-docid="' + id + '"]').val(id);
        // add back the name
        $('div.pa-cost-form').find('input[data-docid="' + id + '"]').attr('name', 'cost-submit[doc-id][]');
        // set the opacity
        $('div.provider-single[data-docid="' + id + '"]').removeClass('provider-unchecked');
    }

    function doctor_remove(id) {
        // remove the value from the field
        $('div.pa-cost-form').find('input[data-docid="' + id + '"]').val('');
        // remove the name
        $('div.pa-cost-form').find('input[data-docid="' + id + '"]').attr('name', '');
        // set the opacity
        $('div.provider-single[data-docid="' + id + '"]').addClass('provider-unchecked');
    }

    $('div.provider-single').each(function() {

        var box = $(this).find('input.provider-choice');
        var id = $(this).find('input.provider-choice').val();
        var current = $(this).find('input.provider-choice').is(':checked');

        // check on load. only relevant when they go back in browser
        if (current === true)
            doctor_include(id);

        if (current === false)
            doctor_remove(id);

        // look for checkbox changes
        $(box).change(function() {

            var check = $(this).is(':checked');

            if (check === true)
                doctor_include(id);

            if (check === false)
                doctor_remove(id);

        });

        // look for picture clicks
        $(this).on('click', 'img.headshot', function(event) {

            var block = $(this).parents('div.provider-single');
            var id = $(block).find('input.provider-choice').val();
            var checked = $(block).find('input.provider-choice').is(':checked');

            if (checked === true) {
                doctor_remove(id);
                $(block).find('input.provider-choice').prop('checked', false);
            }

            if (checked === false) {
                doctor_include(id);
                $(block).find('input.provider-choice').prop('checked', true);
            }

        });

    });

// **************************************************************
//  set up error messages
// **************************************************************
    /*
     var clickerror	= '<p class="message"><span class="error-message error-check">Select at least one choice.</span></p>';
     var droperror	= '<p class="message"><span class="error-message error-check">Select a choice from the menu.</span></p>';
     var texterror	= '<p class="message"><span class="error-message error-check">Enter a value.</span></p>';
     var ziperror	= '<p class="message"><span class="error-message error-check">Enter a valid ZIP code</span></p>';
     var emailerror	= '<p class="message"><span class="error-message error-check">Enter a valid email address.</span></p>';
     */
    var clickerror = '<span class="error-message item-error error-check">Select at least one choice.</span>';
    var droperror = '<span class="error-message item-error error-dropdown">Select a choice from the menu.</span>';
    var texterror = '<span class="error-message item-error error-text">Enter a value.</span>';
    var ziperror = '<span class="error-message item-error error-zipcode">Enter a valid ZIP code.</span>';
    var emailerror = '<span class="error-message item-error error-email">Enter a valid email address.</span>';

    var checkerror = '<span class="error-message error-submit">Please check the areas in red.</span>';

// **************************************************************
//  validation checks based on input type
// **************************************************************

    // US ONLY
    /*
     function zip_validate( zipcode ) {
     
     var zipReg = /^\d{5}(-\d{4})?(?!-)$/;
     return zipReg.test( zipcode );
     }
     */

    // US & CANADA
    function zip_validate(zipcode) {

        var zipReg = /(^([0-9]{5})$)|(^[ABCEGHJKLMNPRSTVXYabceghjklmnprstvxy]{1}\d{1}[A-Za-z]{1} *\d{1}[A-Za-z]{1}\d{1}$)/;
        return zipReg.test(zipcode);
    }

    function email_validate(email) {
        var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return emailReg.test(email);
    }

// **************************************************************
//  clear pre-existing error messages
// **************************************************************

    function notice_remove() {

        $('div.pa-field-group').each(function() {

            $(this).find('input').removeClass('user-error');
            $(this).find('p.message').remove();

        });

    }


// **************************************************************
//  count errors for validation
// **************************************************************

    function error_count() {

        var counts = $('form.pa-form-group').find('div.error-group').length;

        return counts;

    }

// **************************************************************
//  clear errors on re-entry
// **************************************************************

    function error_recheck() {

        $('div.pa-field-group').each(function() {

            // look for those flagged with errors
            if ($(this).hasClass('error-group')) {

                var errorcount;

                // clear out text fields
                $(this).find('input[type="text"]').focus(function() {

                    // remove error messages
                    $(this).val('');
                    $(this).removeClass('user-error');
                    $(this).parents('div.pa-field-group').removeClass('error-group');
                    $(this).parents('div.pa-field-group').find('p.message').remove();

                    errorcount = error_count();
                    console.log(errorcount);

                    if (errorcount === 0) {
                        button_enable();
                        $('span.error-submit').remove();
                    }

                });

                // look for radio button changes
                $(this).find('input[type="radio"]').change(function() {

                    // remove error messages
                    $(this).parents('div.pa-field-group').removeClass('error-group');
                    $(this).parents('div.pa-field-group').find('p.message').remove();

                    errorcount = error_count();
                    console.log(errorcount);

                    if (errorcount === 0) {
                        button_enable();
                        $('span.error-submit').remove();
                    }

                });

                // look for radio button changes
                $(this).find('input[type="checkbox"]').change(function() {

                    // remove error messages
                    $(this).parents('div.pa-field-group').removeClass('error-group');
                    $(this).parents('div.pa-field-group').find('p.message').remove();

                    errorcount = error_count();
                    console.log(errorcount);

                    if (errorcount === 0) {
                        button_enable();
                        $('span.error-submit').remove();
                    }

                });

                // look for select dropdown changes
                $(this).find('select').change(function() {

                    // remove error messages
                    $(this).parents('div.pa-field-group').removeClass('error-group');
                    $(this).parents('div.pa-field-group').find('p.message').remove();

                    errorcount = error_count();
                    console.log(errorcount);

                    if (errorcount === 0) {
                        button_enable();
                        $('span.error-submit').remove();
                    }

                });

            }

        });
    }

// **************************************************************
//  handle the step one form validaton
// **************************************************************

    $('div.pa-form-wrap').on('click', 'input#pa-submit', function(event) {
        // remove error messages
        notice_remove();
        button_disable('input#pa-submit');

        var paform = $('form.pa-form-setup');

        $(paform).find('div.pa-field-group').each(function() {

            var entry;
            var valid;
            var empty;

            // checkbox & radio fields
            if ($(this).hasClass('pa-checkbox-group') || $(this).hasClass('pa-radio-group')) {

                entry = $(this).find('input:checked').length;
                empty = (entry === 0) ? true : false;

                if (empty === true) {
                    $(this).addClass('error-group');
                    $(this).find('h4').append(clickerror);
                }

            }

            // dropdown
            if ($(this).hasClass('pa-select-group')) {

                entry = $(this).find('select').val();
                empty = (entry == 'none') ? true : false;

                if (empty === true) {
                    $(this).addClass('error-group');
                    $(this).find('h4').append(droperror);
                }

            }

            // standard text field
            if ($(this).hasClass('pa-text-group')) {

                entry = $(this).find('input').val();
                empty = (entry === '') ? true : false;

                if (empty === true) {
                    $(this).addClass('error-group');
                    $(this).find('input').addClass('user-error');
                    $(this).find('h4').append(texterror);
                }

            }

            // zip code field
            if ($(this).hasClass('pa-zip-group')) {

                entry = $(this).find('input').val();
                valid = zip_validate(entry);
                empty = (entry === '') ? true : false;

                if (empty === true || valid === false) {
                    $(this).addClass('error-group');
                    $(this).find('input').addClass('user-error');
                    $(this).find('h4').append(ziperror);
                }

            }

        });

        var errorcount = error_count();

        if (errorcount !== 0) {
            error_recheck();
            $('input#pa-submit').after(checkerror);
            button_enable('input#pa-submit');
            return false;
        }

        if (errorcount === 0) {
            //button_enable();
            $('.pa-form-group').submit();
            return true;
        }

    });


// **************************************************************
//  handle the step two form validaton
// **************************************************************

    $('div.pa-cost-form').on('click', 'input#pa-calculate', function(event) {

        // remove error messages
        notice_remove();
        button_disable('input#pa-calculate');

        var paform = $('form.pa-cost-submit');

        $(paform).find('div.cost-form-field').each(function() {

            // get field type
            var type = $(this).data('type');

            var entry;
            var valid;
            var empty;

            // text fields
            if (type == 'text') {

                entry = $(this).find('input').val();
                empty = (entry === '') ? true : false;

                if (empty === true) {
                    $(this).addClass('error-group');
                    $(this).find('input').addClass('user-error');
                    $(this).append(texterror);
                }

            }

            // email fields
            if (type == 'email') {

                entry = $(this).find('input').val();
                valid = email_validate(entry);
                empty = (entry === '') ? true : false;

                if (empty === true || valid === false) {
                    $(this).addClass('error-group');
                    $(this).find('input').addClass('user-error');
                    $(this).append(emailerror);
                }

            }

        });

        var errorcount = error_count();

        if (errorcount !== 0) {
            error_recheck();
            $('input#pa-calculate').after(checkerror);
            button_enable('input#pa-calculate');
            return false;
        }

        if (errorcount === 0) {
            $('.pa-form-group').submit();
            return true;
        }

    });

//********************************************************
// you're still here? it's over. go home.
//********************************************************

});
