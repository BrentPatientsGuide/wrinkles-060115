var selected_items = Array();
var ctrl_is_down = false;
var current_dir = '/';
/**
 * making and inserting shortcodes.
 */
var Mfma_rlMediaSelector = function()
{
    // this function is called when the insert button is pressed.
    this.onClickSubmitButton = function(html)
    {
        self.parent.onMfma_rlMediaSelector_ShortCode(html);
    };
};
// Mfma_rlMediaSelector
var Mfma_rlMediaSelector = new Mfma_rlMediaSelector();
window.onload = function()
{
    //Mfma_rlMediaSelector.initialize();
};
var mrl_files_data;
var mrl_subdir_data;
var mrl_get_data_count = 0;
var mrl_get_data_id = -1;
// function name: (none)
// description :  initialization
// argument : (void)
jQuery(document).ready(function() {
    ctrl_management();
    jQuery('#mfma_selector').click(function() {
        if (jQuery('#mfma_media_list').length == 0) {
            jQuery('body').append(
                    '<div id="mfma_media_list" class="media-frame">' +
                    '<div class="media-frame-menu">' +
                    '<div class="media-menu">' +
                    '</div>' +
                    '</div>' +
                    '<div class="media-frame-title">' +
                    '<h1>Media File Manager Advanced Selector</h1>' +
                    '</div>' +
                    '<div class="media-frame-router">' +
                    '<div class="media-router">' +
                    // '<a class="media-menu-item" href="#">Upload Files</a>' +
                    '<a class="media-menu-item active" href="#">Media Library</a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="media-frame-content">' +
                    '<div class="attachments-browser">' +
                    '<div class="media-toolbar">' +
                    '<div class="media-toolbar-secondary">' +
                    '</div>' +
//                    '<div class="media-toolbar-primary">' +
//                    '<input type="search" placeholder="Search" class="search">' +
//                    '</div>' +
                    '</div>' +
                    '<div class="media-sidebar"></div>' +
                    '<ul id="__attachments-view-54" class="attachments ui-sortable ui-sortable-disabled"></ul>' +
                    '</div>' +
                    '</div>' +
                    '<div id="mrl_edit"></div>' +
                    '<div class="media-frame-toolbar">' +
                    '<div class="media-toolbar">' +
                    '<div class="media-toolbar-secondary">' +
                    '<div class="media-selection one empty">' +
                    '<div class="selection-info">' +
                    '<span class="count"><span>0</span> selection(s)</span>' +
                    '<a class="edit-selection" href="#">Edit</a>' +
                    '<a class="clear-selection" href="#">Clear</a>' +
                    '</div>' +
                    '<div class="selection-view">' +
                    '<ul id="__attachments-view-43" class="attachments ui-sortable">' +
                    '</ul>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="media-toolbar-primary">' +
                    '<a id="insert-button" class="button media-button button-primary button-large media-button-insert" href="#" disabled="disabled">Insert in article</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="media-frame-uploader">' +
                    '</div>' +
                    '<a class="media-modal-close" title="Close" href="#">' +
                    '<span class="media-modal-icon"></span>' +
                    '</a>' +
                    '</div>' +
                    '<div class="media-modal-backdrop"></div>');
            jQuery('#mfma_media_list .media-frame-content').css('text-align', 'center');
            var data = {
                action: 'mfma_relocator_get_media_subdir'
            };
            jQuery.post(ajaxurl, data, function(response) {
                mrl_subdir_data = JSON.parse(response);
                mrl_get_data_count++;
                jQuery('#mfma_media_list .media-menu').jstree({'core': {
                        'data': mrl_subdir_data[0]
                    }});
                jQuery("#mfma_media_list .media-menu").bind('select_node.jstree', function(e) {
                    var selected_node = jQuery("#mfma_media_list .media-menu").jstree('get_selected');
                    var dirs = jQuery("#mfma_media_list .media-menu").jstree('get_path', selected_node[0]);
                    var path = "";
                    jQuery.each(dirs, function(k, v) {
                        if (v == "/")
                            return;
                        path += v;
                        path += "/";
                    });

                    current_dir = path == "" ? '/' : path.substring(0, path.length - 1);
                    display_pic(current_dir);
                });
            });
            var data = {
                action: 'mfma_relocator_get_media_list'
            };
            jQuery.post(ajaxurl, data, function(response) {
                mrl_files_data = JSON.parse(response);
                mrl_get_data_count++;
            });
            mrl_get_data_id = setInterval(mrl_prepare, 20);
            mrl_prepare();
            jQuery('#mfma_media_list .media-modal-close').click(function() {
                close_pop_up();
                close_edit();
            });
            jQuery('#mfma_media_list #insert-button').click(function() {
                if (this.disabled === false) {
                    var obj = jQuery('.attachment.details');
                    var parts = obj.attr('id').split('_')
                    var i = parts[parts.length - 1];
                    var id = mrl_files_data[i]['ID'];
                    mrl_open_selector_insert_dialog(id);
                }
            })

        } else {
            open_pop_up();
        }
    });
});
function open_pop_up() {
    jQuery('#mfma_media_list').css('display', 'block');
    jQuery('.media-modal-backdrop').css('display', 'block');
}
function close_pop_up() {
    jQuery('#mfma_media_list').css('display', 'none');
    jQuery('.media-modal-backdrop').css('display', 'none');
    close_edit();
}

function mrl_prepare() {
    if (mrl_get_data_count < 2)
        return;
    if (mrl_get_data_id > 0) {
        clearInterval(mrl_get_data_id);
        mrl_get_data_id = -1;
    }
    mrl_make_selector_control();
    mrl_make_file_list(mrl_subdir_data);
    display_pic('/');
}
var mrl_prev_disp = 'list';
function read_tree(tree, x, parent) {
    for (var i = 0; i < tree.length; i++) {
        var name = tree[i]['text'];
        if (tree[i]['text'] != '/') {
            if (parent != '/') {
                name = parent + '/' + tree[i]['text'];
            }
        }
        // tree[i]['name']
        jQuery('#mfma_media_list .media-menu').append('<a class="media-menu-item" href="#" data-path="' + name + '">' + name + '</a>');
        if (tree[i]['children'].length > 0) {
            read_tree(tree[i]['children'], x + 1, name);
        }
    }
}

function display_pic(sel_subdir, type) {
    if (typeof type === 'undefined') {
        type = 'all';
    }
    for (var i = 0; i < mrl_files_data.length; i++) {
        var disp = true;
        var tmp_path = sel_subdir == '/' ? sel_subdir : sel_subdir + '/';
        if (sel_subdir != 'all') {
            if (sel_subdir == '/') {
                if (mrl_files_data[i]['file'].indexOf("/") >= 0) {
                    disp = false;
                }
            } else if (mrl_files_data[i]['subfolder'] != tmp_path) {
                disp = false;
            }
        }
        if (type != 'all') {
            if (mrl_files_data[i]['post_mime_type'].substr(0, 5) != type) {
                disp = false;
            }
        }
        jQuery('#mfma_media_list #mrl_media_tl_' + i).css('display', disp ? 'block' : 'none');
    }
}


// function name: mrl_make_selector_control
// description :  display pull-down menus and prepare events for menu changes.
// argument : (void)
function mrl_make_selector_control() {
    var html;
    // Types
    html = '<select id="sel_type" name="sel_type" class="attachment-filters">';
    html += '<option value="all">All media items</option>';
    html += '<option value="image">Images</option>';
    html += '<option value="audio">Audio</option>';
    html += '<option value="video">Video</option>';
    html += "</select>";
//    // Display
//    html += 'Display:<select id="sel_disp" name="sel_disp">';
//    html += '<option value="list">List</option>';
//    html += '<option value="tile">Tile</option>';
//    html += "</select>";

    jQuery('#mfma_media_list .attachments-browser .media-toolbar .media-toolbar-secondary').html(html);

    jQuery("select").change(function() {
        var i;
//        var sel_subdir = jQuery('#sel_subdir').val();
        var sel_type = jQuery('#mfma_media_list #sel_type').val();
//        var sel_disp = jQuery('#sel_disp').val();
//        var sel_disp = 'list';
        // Choose display
//        if (mrl_prev_disp != sel_disp) {
//            if (sel_disp == 'list') {
//                mrl_make_file_list(mrl_subdir_data);
//            } else {
//                mrl_make_thumbnail_table();
//            }
//            mrl_prev_disp = sel_disp;
//        }

        for (i = 0; i < mrl_files_data.length; i++) {
            display_pic(current_dir, sel_type);
//            var disp = true;
//            if (sel_subdir != 'all') {
//                if (sel_subdir == '/') {
//                    if (mrl_files_data[i]['file'].indexOf("/") >= 0) {
//                        disp = false;
//                    }
//                } else if (mrl_files_data[i]['file'].substr(0, sel_subdir.length) != sel_subdir) {
//                    disp = false;
//                }
//            }
        }
    });
}

(function($) {
    $.fn.appear = function(f, o) {
        var s = $.extend({
            one: true
        }, o);
        return this.each(function() {
            var t = $(this);
            t.appeared = false;
            if (!f) {
                t.trigger('appear', s.data);
                return;
            }
            var w = $(window);
            var c = function() {
                if (!t.is(':visible')) {
                    t.appeared = false;
                    return;
                }
                var a = w.scrollLeft();
                var b = w.scrollTop();
                var o = t.offset();
                var x = o.left;
                var y = o.top;
                if (y + t.height() >= b && y <= b + w.height() && x + t.width() >= a && x <= a + w.width()) {
                    if (!t.appeared)
                        t.trigger('appear', s.data);
                } else {
                    t.appeared = false;
                }
            };
            var m = function() {
                t.appeared = true;
                if (s.one) {
                    w.unbind('scroll', c);
                    var i = $.inArray(c, $.fn.appear.checks);
                    if (i >= 0)
                        $.fn.appear.checks.splice(i, 1);
                }
                f.apply(this, arguments);
            };
            if (s.one)
                t.one('appear', s.data, m);
            else
                t.bind('appear', s.data, m);
            w.scroll(c);
            $.fn.appear.checks.push(c);
            (c)();
        });
    };
    $.extend($.fn.appear, {
        checks: [],
        timeout: null,
        checkAll: function() {
            var l = $.fn.appear.checks.length;
            if (l > 0)
                while (l--)
                    ($.fn.appear.checks[l])();
        },
        run: function() {
            if ($.fn.appear.timeout)
                clearTimeout($.fn.appear.timeout);
            $.fn.appear.timeout = setTimeout($.fn.appear.checkAll, 20);
        }
    });
    $.each(['append', 'prepend', 'after', 'before', 'attr', 'removeAttr', 'addClass', 'removeClass', 'toggleClass', 'remove', 'css', 'show', 'hide'], function(i, n) {
        var u = $.fn[n];
        if (u) {
            $.fn[n] = function() {
                var r = u.apply(this, arguments);
                $.fn.appear.run();
                return r;
            }
        }
    });
})(jQuery);
function check_button() {
    if (selected_items.length > 0) {
        jQuery('#mfma_media_list #insert-button').removeAttr('disabled');
    } else {
        jQuery('#mfma_media_list #insert-button').attr('disabled', 'true');
    }
    create_thumb_selected_list();
}

function create_thumb_selected_list() {
    var nb = selected_items.length;
    jQuery('#mfma_media_list .count span').html(nb);
    if (nb > 0) {
        jQuery('#mfma_media_list .media-toolbar-secondary .media-selection').removeClass('empty');
    } else {
        jQuery('#mfma_media_list .media-toolbar-secondary .media-selection').addClass('empty');
    }

    var html = '';
    for (var i = 0; i < mrl_files_data.length; i++) {
        if (jQuery.inArray(mrl_files_data[i]['ID'], selected_items) != -1) {
            var item = mrl_files_data[i];
            var _uploadurl = uploadurl;
            if (item['thumbnail'].substr(0, 4) == 'http') {
                _uploadurl = '';
            }

            html += '<li class="attachment selection details selected save-ready" style="position: relative; left: 0px; top: 0px;">' +
                    '<div class="attachment-preview type-image subtype-jpeg landscape">' +
                    '<div class="thumbnail">' +
                    '<div class="centered">' +
                    '<img draggable="false" src="' + _uploadurl + item['thumbnail'] + '">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';
        }
    }
    jQuery('#mfma_media_list #__attachments-view-43').html(html);
}


// function name: mrl_make_file_list
// description :  display a list of media
// argument : (void)
function mrl_make_file_list(tree) {
    var html = '';
    for (var i = 0; i < mrl_files_data.length; i++) {
        var _uploadurl = uploadurl;
        if (mrl_files_data[i]['thumbnail'].substr(0, 4) == 'http') {
            _uploadurl = '';
        }

        html += '<li id="mrl_media_tl_' + i + '" class="attachment save-ready" data-id="' + mrl_files_data[i]['ID'] + '">';
        html += '<div class="attachment-preview type-image subtype-jpeg landscape">';

        var mime_type = mrl_files_data[i]['post_mime_type'];
        if (mime_type.substring(0, 15) == "application/vnd" || mime_type.substring(0, 4) == "text" || mime_type == "application/msword") {
            html += '<img src="' + _uploadurl + mrl_files_data[i]['thumbnail'] + '" class="icon">';
            html += '<div class="filename">';
            html += '<div>' + mrl_files_data[i]['file'].substring(mrl_files_data[i]['subfolder'].length) + '</div>';
            html += '</div>';
        } else {
            html += '<div class="thumbnail">';
            html += '<div class="centered">';
            html += '<img src="' + _uploadurl + mrl_files_data[i]['thumbnail'] + '">';
            html += '</div>';
            html += '</div>';
        }

        html += '<a class="check" title="Désélectionner" href="#">';
        html += '<div class="media-modal-icon"></div>';
        html += '</a>';
        html += '</div>';
        html += '</li>';
    }
    jQuery('#mfma_media_list #__attachments-view-54').html(html);
    jQuery('#mfma_media_list #mrl_media_tl_' + i).css('display', 'none');
    jQuery('#mfma_media_list .attachment').click(function() {

        // TODO: Remove item on - click

//        if (ctrl_is_down == true) {
//            if (jQuery(this).hasClass('selected')) {
//                // Delete others selected items
//                jQuery(this).removeClass('details selected');
//                jQuery('.selected').removeClass('details');
//                jQuery('.selected').first().addClass('details');
//                selected_items.removeByValue(jQuery(this).attr('data-id'));
//                check_button();
//            } else {
//                // Add item
//                jQuery('.selected').removeClass('details');
//                jQuery(this).addClass('details selected');
//                selected_items.push(jQuery(this).attr('data-id'));
//                check_button();
//            }
//        } else {
        if (jQuery(this).hasClass('selected')) {
            if (jQuery(this).hasClass('details')) {
                // Delete item
                jQuery(this).removeClass('details selected');
                jQuery('#mfma_media_list .selected').first().addClass('details');
                selected_items.removeByValue(jQuery(this).attr('data-id'));
                check_button();
            } else {
                // Move the focus
                jQuery('#mfma_media_list .selected').removeClass('details');
                jQuery(this).addClass('details');
            }
        } else {
            // Delete all items and add the new one
            mfma_mrl_remove_all_selected_items()
            jQuery(this).addClass('details selected');
            selected_items.push(jQuery(this).attr('data-id'));
            check_button();
        }
//        }

        // Clear all selection
        jQuery('#mfma_media_list .clear-selection').click(function() {
            mfma_mrl_remove_all_selected_items()
            check_button();
        })
    });
    mrl_set_selector_event();
}


function mfma_mrl_remove_all_selected_items() {
    selected_items = Array();
    jQuery('#mfma_media_list .selected').removeClass('details selected');
}


// function name: mrl_make_thumbnail_table
// description :  display a list of media (tile style)
// argument : (void)
function mrl_make_thumbnail_table() {
    var html = "", i;
    for (i = 0; i < mrl_files_data.length; i++) {
        html += '<table id="mrl_media_tl_' + i + '" style="display:inline-table; overflow:hidden;"><tr>';
        html += '<td id="mrl_media_' + i + '" title="' + mrl_files_data[i]['post_title'] + '" width="150" height="150">';
        html += '</td></tr></table>';
    }
    jQuery('#mfma_media_list .media-frame-content').html(html);
    for (i = 0; i < mrl_files_data.length; i++) {
        var _uploadurl = uploadurl;
        if (mrl_files_data[i]['thumbnail'].substr(0, 4) == 'http') {
            _uploadurl = '';
        }
        jQuery('#mfma_media_list #mrl_media_' + i).data('thumbnail', _uploadurl + mrl_files_data[i]['thumbnail']);
        jQuery('#mfma_media_list #mrl_media_' + i).appear(function() {
            html = '<img src="' + jQuery(this).data('thumbnail') + '" width="150" />';
            jQuery(this).html(html);
            jQuery(this).unbind('appear');
        });
    }
    mrl_set_selector_event()
}

// function name: mrl_set_selector_event
// description : set event to open a insert dialog to each images
// argument : (void)
function mrl_set_selector_event() {
//    for (i = 0; i < mrl_files_data.length; i++) {
////        mrl_media_
//        id = '#mrl_media_tl_' + i;
//        jQuery(id).data('id', mrl_files_data[i]['ID']);
//        jQuery(id).click(function() {
//            mrl_open_selector_insert_dialog(jQuery(this).data('id'));
//        });
//    }
}

// function name: mrl_open_selector_insert_dialog
// description :  open a media insert dialog
// argument : (id) post-id of media
function mrl_open_selector_insert_dialog(id) {
    var data = {
        action: 'mfma_relocator_get_image_insert_screen',
        id: id
    };
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajaxurl, data, function(response) {
        mrl_open_selector_insert_dialog_main(response);
    });
}


function open_edit() {
    jQuery('#mfma_media_list .media-frame-content').css('display', 'none');
    jQuery('#mfma_media_list .media-frame-menu').css('display', 'none');
    jQuery('#mfma_media_list .media-frame-router').css('display', 'none');
    jQuery('#mfma_media_list .media-frame-toolbar').css('display', 'none');
    jQuery('#mfma_media_list #mrl_control').css('display', 'none');
    jQuery('#mfma_media_list #mrl_edit').html('');
    jQuery('#mfma_media_list #mrl_edit').append('<div id="mrl_insert_dialog"></div>');
}
function close_edit() {
    jQuery('#mfma_media_list #mrl_edit').html('');
    jQuery('#mfma_media_list .media-frame-content').css('display', 'block');
    jQuery('#mfma_media_list .media-frame-menu').css('display', 'block');
    jQuery('#mfma_media_list .media-frame-router').css('display', 'block');
    jQuery('#mfma_media_list .media-frame-toolbar').css('display', 'block');
    jQuery('#mfma_media_list #mrl_control').css('display', 'block');
}

// function name: mrl_open_selector_insert_dialog_main
// description :  Display a media insert dialog, and make the code for insersion
// argument : (dat)html of the edit screen
function mrl_open_selector_insert_dialog_main(dat) {
    mrl_selector_html = jQuery('.media-frame-content').html();
    open_edit();
    jQuery('#mfma_media_list #mrl_insert_dialog').html(dat);
    jQuery('#mfma_media_list #mrl_cancel').click(function() {
        jQuery('#mfma_media_list .media-frame-menu').css('display', 'block');
        close_edit();
    });
    jQuery('#mfma_media_list #urlnone').click(function() {
        jQuery('#mfma_media_list #attachments_url').val(jQuery('#urlnone').data("link-url"))
    });
    jQuery('#mfma_media_list #urlfile').click(function() {
        jQuery('#mfma_media_list #attachments_url').val(jQuery('#urlfile').data("link-url"))
    });
    jQuery('#mfma_media_list #urlpost').click(function() {
        jQuery('#mfma_media_list #attachments_url').val(jQuery('#urlpost').data("link-url"))
    });
    jQuery('#mfma_media_list #send').click(function() {
        var mrl_data = JSON.parse(jQuery('#mfma_media_list #mrl_data').html());
        var title = jQuery('#mfma_media_list input#attachments_post_title').val();
        var caption = jQuery('#mfma_media_list input#attachments_post_excerpt').val();
        var description = jQuery('#mfma_selectortextarea#attachments_post_content').val();
        var link_url = jQuery('#mfma_media_list input#attachments_url').val();
        var is_image = mrl_data['is_image'];
        if (is_image) {
            var alt_org = jQuery('#mfma_media_list input#attachments_image_alt').val();
            var align = jQuery('#mfma_media_list input:radio[name=attachments_align]:checked').val();
            var size = jQuery('#mfma_media_list input:radio[name=attachments-image-size]:checked').val();
            var width = 0, height = 0;
            var iclass = '';
            alt = mrl_htmlEncode(alt_org);
        } else {
            alt = "$none$";
        }
        var data = {
            action: 'mfma_relocator_update_media_information',
            id: mrl_data['posts']['ID'],
            title: title,
            caption: caption,
            description: description,
            alt: alt_org
        };
        jQuery.post(ajaxurl, data, function(response) {
        });
        title = mrl_htmlEncode(title);
        caption = mrl_htmlEncode(caption);
        description = mrl_htmlEncode(description);
        if (is_image) {
            img_url = /*uploadurl;*/mrl_data['urldir'];
            if (size == 'full') {
                width = mrl_data['meta']['width'];
                height = mrl_data['meta']['height'];
                img_url = uploadurl + mrl_data['meta']['file'];
                iclass = 'size-full';
            }
            if (size == 'thumbnail') {
                width = mrl_data['meta']['sizes']['thumbnail']['width'];
                height = mrl_data['meta']['sizes']['thumbnail']['height'];
                img_url += mrl_data['meta']['sizes']['thumbnail']['file'];
                iclass = 'size-thumbnail';
            }
            if (size == 'medium') {
                width = mrl_data['meta']['sizes']['medium']['width'];
                height = mrl_data['meta']['sizes']['medium']['height'];
                img_url += mrl_data['meta']['sizes']['medium']['file'];
                iclass = 'size-medium';
            }
            if (size == 'large') {
                width = mrl_data['meta']['sizes']['large']['width'];
                height = mrl_data['meta']['sizes']['large']['height'];
                img_url += mrl_data['meta']['sizes']['large']['file'];
                iclass = 'size-large';
            }
        }
        var html = '';
        if (is_image) {
            if (caption != "") {
                html += '[caption id="attachment_' + mrl_data['posts']['ID'] + '" align="align' + align + '" width="' + width + '" caption="' + caption + '"]';
            }
        }
        if (link_url != "") {
            html += '<a href="' + link_url + '">';
        }
        if (is_image) {
            html += '<img src="' + img_url + '" ';
            if (alt != "") {
                html += 'alt="' + alt + '" ';
            }
            if (title != "") {
                html += 'title="' + title + '" ';
            }
            html += 'width="' + width + '" height="' + height + '" class="';
            if (caption == "") {
                html += 'align' + align + ' ';
            }
            html += iclass + ' wp-image-' + mrl_data['posts']['ID'] + '" />';
        } else {
            html += title;
        }
        if (link_url != "") {
            html += '</a>';
        }
        if (is_image) {
            if (caption != "") {
                html += '[/caption]';
            }
        }

        Mfma_rlMediaSelector.onClickSubmitButton(html);

        // Clear selection
        mfma_mrl_remove_all_selected_items()
        check_button();

        close_pop_up();
        close_edit();
    });
}

// function name: mrl_htmlEncode
// description : 
// argument : (value)
function mrl_htmlEncode(value) {
    if (value) {
        value = jQuery('<div />').text(value).html();
        var escaped = value;
        var findReplace = [[/&/g, "&amp;"], [/</g, "&lt;"], [/>/g, "&gt;"], [/"/g, "&quot;"]]
        for (var item in findReplace) {
            escaped = escaped.replace(findReplace[item][0], findReplace[item][1]);
        }
        return escaped;
    } else {
        return '';
    }
}


Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};
Array.prototype.removeByValue = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
function ctrl_management() {
    jQuery(document).keydown(function(e) {
        if (e.ctrlKey) {
            ctrl_is_down = true;
        }
    });
    jQuery(document).keyup(function(event) {
        mrl_shift_pressed = false;
        ctrl_is_down = false;
    });
}