//**** Global variables *******************************************************************
var mrl_shift_pressed = false;	// Flag indicates shift key is pressed or not
var mrl_ajax = 0;
var ctrl_pressed = false;
var mrloc_right_menu;	// Right-click menu class object
var mrloc_input_text;	// Text-input form class object
var mrloc_mouse_x, mrloc_mouse_y;
var pane_left, pane_right;	// Pane class objects
var check_right_menu = false;


var ajax_test = 0;

// function name: (none)
// description :  initialization
// argument : (void)
jQuery(document).ready(function(){   
    mrloc_right_menu = new MrlRightMenuClass();
    mrloc_input_text = new MrlInputTextClass();
    pane_left = new MrlPaneClass('mfma_rl_left', true);
    pane_right = new MrlPaneClass('mfma_rl_right', true);
    pane_left.opposite = pane_right;
    pane_right.opposite = pane_left;
    adjust_layout();
    pane_left.setdir("/");
    pane_right.setdir("/");
    jQuery(document).keydown(function (e) {
        if(e.shiftKey) {
            mrl_shift_pressed = true;
        }
    });
    jQuery(document).keydown(function (e) {
        if(e.ctrlKey) {
            ctrl_pressed = true;
        }
    });	
    jQuery(document).mousemove(function(e){
        mrloc_mouse_x = e.pageX;
        mrloc_mouse_y = e.pageY;
    }); 
    jQuery(document).keyup(function(event){
        mrl_shift_pressed = false;
        ctrl_pressed = false;
    });
    jQuery('#mfma_rl_btn_left2right').click(function() {
        if (mrl_ajax) return;
        mrloc_move(pane_left, pane_right);
        pane_right.refresh();
        pane_left.refresh();
    });
    jQuery('#mfma_rl_btn_right2left').click(function() {
        if (mrl_ajax) return;
        mrloc_move(pane_right, pane_left);
        pane_right.refresh();
        pane_left.refresh();
    });
    jQuery('#mfma_rl_test').click(function() {
        var data = {
            action: 'mfma_relocator_test'
        };
        jQuery.post(ajaxurl, data, function(response) {
            alert(response);
        });
    });
    
    jQuery(document).bind("contextmenu",function(e){
        return false;
    }); 
    
    jQuery.fn.outerHTML = function() {
        return jQuery('<div />').append(this.eq(0).clone()).html();
    };
});
//**** Pane class *******************************************************************
var MrlPaneClass = function(id_root, flg_chkbox) {
    this.cur_dir = "";
    this.dir_list = new Array();
    this.dir_disp_list = new Array();
    this.id_root = id_root;
    this.id_wrapper = id_root + "_wrapper";
    this.id_pane = id_root + "_pane";
    this.id_dir = id_root + "_path";
    this.id_dir_new = id_root + "_dir_new";
    this.id_dir_up = id_root + "_dir_up";
    this.id_dir_refresh = id_root + "_dir_refresh";
    this.flg_chkbox = flg_chkbox;
    this.checked_loc = -1;
    this.last_div_id = "";
    this.chk_prepare_id = 0;
    this.opposite=this;
    var that = this;
    
    // Refresh button
    jQuery('#'+this.id_dir_refresh).click(function() {
        that.setdir(that.cur_dir);
    });
    
    // Back button
    jQuery('#'+this.id_dir_up).click(function(ev) {
        if (mrl_ajax) return;
        if ("/" == that.cur_dir) return;
        that.chdir("..");
    });
    
    // Remove right click menu 
    jQuery('#'+this.id_pane).mousedown(function(event) {
        if (event.which == 1) { 
            jQuery('#mfma_rl_right_menu').remove();
            check_right_menu = false;
        }
    });
    
    // New dir on right click
    jQuery('#'+this.id_pane).mousedown(function(event) {
        if (event.which == 3 && check_right_menu == false) {                
            var arrMenu = new Array("New folder");
            mrloc_right_menu.make(arrMenu);
            
            jQuery('#'+mrloc_right_menu.get_item_id(0)).click(function(){
                new_dir_popup(that);
            });
        }
    });
    // New dir button
    jQuery('#'+this.id_dir_new).click(function(ev) {
        new_dir_popup(that);
    });
}
MrlPaneClass.prototype.get_chkid = function (n) {
    return this.id_pane+'_ck_'+n;
}
MrlPaneClass.prototype.get_divid = function (n) {
    return this.id_pane+'_'+n;
};

MrlPaneClass.prototype.get_div_item_id = function (n) {
    return ('mfma_item_parent_'+this.id_pane.split('_')[1]+'_'+n);
}

MrlPaneClass.prototype.refresh_from_server = function () {
    this.setdir(this.cur_dir);
}

MrlPaneClass.prototype.refresh = function () {
    var disp_num = 0;
    var html = "";
    this.last_chk_id = "";
    var dir = this.dir_list;
    
    for (i=0; i<dir.length; i++) {
        if (dir[i].isthumb) continue;
        
        this.dir_disp_list[disp_num] = i;
        
        html = html+'<div class="mfma_item_parent" id="'+this.get_div_item_id(disp_num)+'">';
        if (this.flg_chkbox) {
            html = html + '<div style="text-align:center;display:none;"><input type="checkbox" id="'+this.get_chkid(disp_num)+'"></div>';
        }
        html = html + '<div class="mfma_item" id="' + this.get_divid(disp_num)+'">';
        this.last_div_id = this.get_divid(disp_num);
        if (dir[i].thumbnail_url && dir[i].thumbnail_url!="") {
            html=html+'<img style="margin:0 5px 0 5px;"   data-id="'+i+'"  src="' + dir[i].thumbnail_url+'" alt="'+dir[i].name+'" width="50" />';
        }
        html = html + '<div class="mfma_rl_filename">';
        html = html + mrl_ins8203(dir[i].name);
        html = html + '</div></div></div>';
        disp_num ++;
    }
    jQuery('#'+this.id_pane +" .pane_content_selectable").html(html);
    this.prepare_checkboxes();
}

// function name: MrlPaneClass::setdir
// description : move to the directory and display directory listing
// argument : (dir)absolute path name of the target directory
MrlPaneClass.prototype.setdir = function(dir){
    jQuery('#'+this.id_wrapper).css('cursor:wait');
    var data = {
        action: 'mfma_relocator_getdir',
        dir: dir
    };
    var that = this;	
    mrl_ajax_in();
    jQuery.post(ajaxurl, data, function(response) {
        that.dir_list = that.dir_ajax(data.dir, response);
        mrl_ajax_out();
    });
}

// function name: mrl_ins8203
// description : 
// argument : (str)
function mrl_ins8203(str)
{
    var ret="", i;
    for (i=0; i<str.length; i+=3) {
        ret += str.substr(i, 3);
        ret += '&#8203;'
    }
    return ret;
}

// function name: MrlPaneClass::dir_ajax
// description : display directory list retrieved from server
// argument : (dir)target_dir: target directory; (dirj):list(JSON); 
MrlPaneClass.prototype.dir_ajax = function(target_dir, dirj) {
    if (dirj.search(/error/i) == 0) {	
        alert(dirj);
        jQuery('#'+this.id_wrapper).css('cursor:default');
        return;
    }
    this.cur_dir = target_dir;
    jQuery('#'+this.id_dir).val(target_dir);
   
    if (dirj=="") {
        jQuery('#'+this.id_pane + " .pane_content_selectable").html("");
        return new Array();
    }
    var dir;
    try {
        dir = JSON.parse(dirj);
        
    } catch (err) {
        document.write('<table border="3"><tr><td width="200">');
        document.write("<prea>"+err+"\n"+dirj+"</pre>");
        document.write("</td></tr></table>");
    }
    var disp_num = 0;
    var html = "";
    var that = this;
    this.last_chk_id = "";
    for (i=0; i<dir.length; i++) {
        if (dir[i].isthumb) continue;
        
        this.dir_disp_list[disp_num] = i;
        
        html = html+'<div class="mfma_item_parent" id="'+this.get_div_item_id(disp_num)+'">';
        if (this.flg_chkbox) {
            html = html + '<div style="text-align:center;display:none;"><input type="checkbox" id="'+this.get_chkid(disp_num)+'"></div>';
        }
        html = html + '<div class="mfma_item" id="' + this.get_divid(disp_num)+'">';
        this.last_div_id = this.get_divid(disp_num);
        if (dir[i].thumbnail_url && dir[i].thumbnail_url!="") {
            html=html+'<img style="margin:0 5px 0 5px;"   data-id="'+i+'"  src="' + dir[i].thumbnail_url+'" alt="'+dir[i].name+'" title="'+dir[i].name+'"  width="50" />';
        }
        html = html + '<div class="mfma_rl_filename">';
        html = html + mrl_ins8203(dir[i].name);
        html = html + '</div></div></div>';
        disp_num ++;
    }
    jQuery('#mfma_rl_left_pane .pane_content_selectable').droppable({
        drop: function( event, ui ) {
            side = ui.draggable.parent().parent().attr('id').split('_')[2];
            if(side == "right"){				
                /*alert( "Dropped from right to left!");*/
                
                var nb = ui.draggable.attr('id').split('_')[4];
                
                jQuery('#mfma_rl_right_pane_ck_'+nb).attr('checked','checked');
                if (mrl_ajax) return;
                
                document.body.style.cursor = "no-drop";
                if(mrloc_move(pane_right, pane_left)){
                    pane_right.refresh();
                    pane_left.refresh();
                }
                document.body.style.cursor = "default";
            }
        }
    });
    jQuery('#mfma_rl_right_pane .pane_content_selectable').droppable({
        drop: function( event, ui ) {
            side = ui.draggable.parent().parent().attr('id').split('_')[2];
            if(side == "left"){				
                /*alert( "Dropped from left to right!");*/
                
                var nb = ui.draggable.attr('id').split('_')[4];
                
                //=== old ===//
                jQuery('#mfma_rl_left_pane_ck_'+nb).attr('checked','checked');
                if (mrl_ajax) return;
                
                document.body.style.cursor = "no-drop";
                if(mrloc_move(pane_left, pane_right)){
                    //=== old ===//
                    pane_left.refresh();
                    pane_right.refresh();
                }
                document.body.style.cursor = "default";
            }
        }
    });																			
    jQuery('#'+this.id_pane + " .pane_content_selectable").html(html);

    function callMethod_chkprepare() {
        that.prepare_checkboxes();
    }
    this.chk_prepare_id = setInterval(callMethod_chkprepare, 20);
    jQuery('#'+this.id_wrapper).css('cursor:default');
    
    return dir;
}



// function name: MrlPaneClass::prepare_checkboxes
// description : prepare event for checkboxes and right-click events(mkdir, rename)
// argument : (void)
MrlPaneClass.prototype.prepare_checkboxes = function() {
    var that = this;
    if (jQuery('#'+this.last_div_id).length>0) {
        clearInterval(this.chk_prepare_id);
        for (i=0; i<this.dir_disp_list.length; i++) {
            var idx = this.dir_disp_list[i];
            jQuery('#'+this.get_divid(i)).data('order', i);
            jQuery('#'+this.get_divid(i)).data('data', idx);
            if (this.flg_chkbox) {
                jQuery('#'+this.get_chkid(i)).data('order', i);
                jQuery('#'+this.get_chkid(i)).data('data', idx);				
                jQuery('#'+this.get_chkid(i)).change(function() {
                    if (mrl_shift_pressed && that.checked_loc >= 0) {
                        var loc1 = jQuery(this).data('order');
                        var loc2 = that.checked_loc;
                        var checked = jQuery('#'+that.get_chkid(loc1)).attr('checked');
                        for (n=Math.min(loc1,loc2); n<=Math.max(loc1,loc2); n++) {
                            if (checked == 'checked') {
                                jQuery('#'+that.get_chkid(n)).attr('checked','checked');
                            } else if (checked === true) {
                                jQuery('#'+that.get_chkid(n)).attr('checked',true);
                            } else if (checked === false) { 
                                jQuery('#'+that.get_chkid(n)).attr('checked',false);
                            } else {
                                jQuery('#'+that.get_chkid(n)).removeAttr('checked');
                            }
                        }
                    }
                    that.checked_loc = jQuery(this).data('order');
                });
            }
            jQuery('#'+this.get_divid(i)).mousedown(function(ev) {
                if (ev.which == 3) {
                    ev.preventDefault();
                    var arrMenu = new Array("Preview","Rename","Delete");
                    
                    // Multi deletion
                    var nb_item_selected = 0;
                    var ids_to_delete = new Array();
                    for (var i=0; i < that.dir_list.length; i++) {
                        var attr = jQuery('#'+that.get_chkid(i)).attr('checked');
                        if (attr=='checked' || attr===true) {
                            ids_to_delete.push(jQuery('#'+ that.get_divid(i) + ' img').attr('data-id'));
                            nb_item_selected++;
                        }
                    }
                    if(nb_item_selected > 1){
                        arrMenu.push("Delete the selection")
                    }
                    
                    mrloc_right_menu.make(arrMenu);
                    
                    var that2 = this;
                    
                    jQuery('#'+mrloc_right_menu.get_item_id(3)).click(function(){ //delete all selected items
                        var variation = 0;
                        if(confirm('Are you sure you want to delete permanently the selection')){
                            for(i = 0; i < (ids_to_delete.length); i++){
                                variation += delete_item(that, (ids_to_delete[i] - variation), true);
                            }
                        }
                    });
                    
                    jQuery('#'+mrloc_right_menu.get_item_id(2)).click(function(){ //delete
                        var id_to_delete = jQuery(that2).data('data');
                        delete_item(that, id_to_delete);
                        check_right_menu = false;
                    });
                    																																						
                    jQuery('#'+mrloc_right_menu.get_item_id(0)).click(function(){ //preview
                        var id = that.dir_list[jQuery(that2).data('data')]['id'];
                        if(typeof id === 'undefined'){
                            var url = mrloc_url_root + (that.cur_dir+that.dir_list[jQuery(that2).data('data')]['name']);
                        }else{
                            var url = mrloc_url_edit_img + id + "&action=edit";
                        }
                      
                        check_right_menu = false;
                        window.open(url, 'mrlocpreview')
                    });
                    jQuery('#'+mrloc_right_menu.get_item_id(1)).click(function(){ //rename
                        if (mrl_ajax) return;
                        var target = that.dir_list[jQuery(that2).data('data')];
                        if (target['norename']) {
                            alert("Sorry, you can not rename.");
                            return false;
                        }
                        var old_name = target['name'];
                        mrloc_input_text.make("Rename ("+old_name+")",old_name,300, target['isdir'] );
                        mrloc_input_text.set_callback(function(){
                            if (old_name == mrloc_input_text.result || mrloc_input_text.result=="") {
                                return false;
                            }
                            if (that.check_same_name(mrloc_input_text.result)) {
                                alert("The same name exists.");
                                return false;
                            }
                            
                            that.dir_list[jQuery(that2).data('data')]['name'] = mrloc_input_text.result;
                            
                            if (that.opposite.cur_dir.indexOf(that.cur_dir+old_name+"/")===0) {
                                that.opposite.setdir(that.cur_dir+mrloc_input_text.result+"/"+that.opposite.cur_dir.substr((that.cur_dir+old_name+"/").length));
                            }
                            if (that.cur_dir == that.opposite.cur_dir) {
                                that.opposite.dir_list[jQuery(that2).data('data')]['name'] = mrloc_input_text.result;
                                that.opposite.refresh();
                            }
                            that.refresh();
                             
                            var data = {
                                action: 'mfma_relocator_rename',
                                dir: that.cur_dir,
                                from: old_name,
                                to: mrloc_input_text.result
                            };
                            mrl_ajax_in();
                            jQuery.post(ajaxurl, data, function(response) {
                                if (response != "") {
                                    alert(response);
                                    pane_left.refresh_from_server();
                                    pane_right.refresh_from_server();
                                }
                                mrl_ajax_out();
                            });
                        });
                        check_right_menu = false;
                    });
                }
                var dir = that.dir_list[jQuery(this).data('data')];
                check_right_menu = true;
            });
            
            
            jQuery('#'+this.get_divid(i)).dblclick(function() {
                if (mrl_ajax) return;
                var dir = that.dir_list[jQuery(this).data('data')];
                if (dir.isdir) {
                    that.chdir(dir.name);
                }
            });

            jQuery('#'+this.get_divid(i)).click(function() {
                if (ctrl_pressed){
                    tab = jQuery(this).attr('id').split('_');
                    id = tab[tab.length-1];
                    checked = jQuery('#'+ that.get_chkid(id)).attr('checked');
                    
                    if(jQuery(this).parent().hasClass('ui-selected')){
                        jQuery(this).parent().removeClass('ui-selected');
                        
                        jQuery('#'+ that.get_chkid(id)).attr('checked', false);
                    }else{
                        jQuery(this).parent().addClass('ui-selected');
                        
                        jQuery('#'+ that.get_chkid(id)).attr('checked','checked');
                    }
                }else{
                    tab = jQuery(this).attr('id').split('_');
                    id = tab[tab.length-1];
                    checked = jQuery('#'+ that.get_chkid(id)).attr('checked');
                    
                    if(jQuery(this).parent().hasClass('ui-selected')){
                        jQuery(this).parent().removeClass('ui-selected');
                        
                        jQuery('#'+ that.get_chkid(id)).attr('checked', false);
                    }else{
                        jQuery(this).parent().addClass('ui-selected');
                        
                        jQuery('#'+ that.get_chkid(id)).attr('checked','checked');
                    }
                }
            });
        }
    }
    
    jQuery('#mfma_rl_left_pane .mfma_item_parent').draggable({
        revert: true, 		
        revertDuration: 0,		
        containment: "#mfma_rl_wrapper_all",		
        cursor: "move",
        helper: function(){
            var selected = jQuery('#mfma_rl_left_pane .ui-selected');
            if (selected.length === 0) {
                selected = jQuery(this);
            }
            var container = jQuery('<div/>').attr('id', 'draggingContainer');
            container.css("max-width","500px");
            container.append(selected.clone());
            return container; 
        }
    });	
    
    jQuery('#mfma_rl_right_pane .mfma_item_parent').draggable({
        revert: true, 		
        revertDuration: 0,		
        containment: "#mfma_rl_wrapper_all",		
        cursor: "move",
        helper: function(){
            var selected = jQuery('#mfma_rl_right_pane .ui-selected');
            if (selected.length === 0) {
                selected = jQuery(this);
            }
            var container = jQuery('<div/>').attr('id', 'draggingContainer');
            container.append(selected.clone());
            container.css("max-width","500px");
            return container; 
        }
    });	
        
    jQuery(".mfma_rl_pane .pane_content_selectable").selectable({
        filter:".mfma_item_parent",
        selected: function(event, ui) {
            side = jQuery(ui.selected).parent().parent().attr('id').split('_')[2];
            jQuery('#mfma_rl_'+side+'_pane_ck_'+jQuery(ui.selected).attr("id").split('_')[4]).attr('checked','checked');
        },
        unselected: function( event, ui ) {
            side = jQuery(ui.unselected).parent().parent().attr('id').split('_')[2];
            jQuery('#mfma_rl_'+side+'_pane_ck_'+jQuery(ui.unselected).attr("id").split('_')[4]).attr('checked',false);
        }
    });
    
    
    return true;
}
// function name: check_same_name
// description : check if there is not a directory with same name
// argument : directory name
MrlPaneClass.prototype.check_same_name = function(str){
    for (var i=0; i<this.dir_list.length; i++) {
        if (this.dir_list[i]['name'] == str) {
            return true;
        }
    }
    return false;
}

// function name: MrlPaneClass::chdir
// description : move directory and display its list
// argument : (dir)target directory
MrlPaneClass.prototype.chdir = function(dir) {
    var last_chr = this.cur_dir.substr(this.cur_dir.length-1,1);
    var new_dir = this.cur_dir;

    if (dir == "..") {
        if (last_chr == "/") {
            new_dir = new_dir.substr(0, new_dir.length-1);
        }
        var i=0;
        for (i=new_dir.length-1; i>=0; i--) {
            if (new_dir.substr(i, 1)=="/") {
                new_dir = new_dir.substr(0, i+1);
                break;
            }
        }
    } else {
        if (last_chr != "/") new_dir += "/";
        new_dir += dir;
        if (last_chr == "/") new_dir += "/";
    }
    this.setdir(new_dir);
}
// function name: MrlPaneClass::move
// description : moving checked files/directories
// argument : (pane_from)pane object; (pane_to)pane object 
function mrloc_move(pane_from, pane_to) {
    var i,j,k;
    var flist="";
    var pre_flist="";
    var id_to_delete = [];
    var id_parent_to_delete = [];
    var name_to_delete = [];
    
    if (pane_from.cur_dir == pane_to.cur_dir) {
        return false;
    }

    // make list of checked item
    for (i=0; i < pane_from.dir_list.length; i++) {
        var attr = jQuery('#'+pane_from.get_chkid(i)).attr('checked');
        if (attr=='checked' || attr===true) {
            
            var parent = jQuery('#'+pane_from.get_divid(i)+' img').attr('alt');
            var id_parent = jQuery('#'+pane_from.get_divid(i)+' img').attr('data-id');
           
            
            pre_flist = pane_from.dir_list[id_parent];            
            if(typeof pre_flist !== 'undefined'){
                flist += pre_flist.name + "/";
            }else{
                continue;
            }

            name_to_delete.push(parent);

            for (j=0; j<pane_from.dir_list.length; j++) {
                if (pane_from.dir_list[j].isthumb ) {
                    if(pane_from.dir_list[j].parent == parent){
                        flist += pane_from.dir_list[j].name + "/";

                        pane_to.dir_list.push(pane_from.dir_list[j]);                        
                        id_to_delete.push(j); 
                    }
                }
            }
            
            jQuery('#'+pane_from.get_divid(i)+' img').attr('data-id', pane_to.dir_list.length);
            pane_to.dir_list.push(pane_from.dir_list[id_parent]);
        }
    }
    
    for(j=0;j<id_to_delete.length; j++){
        pane_from.dir_list.remove(id_to_delete[j] - j);
    } 
    
    for(j=0;j<pane_from.dir_list.length; j++){
        for(i=0;i<name_to_delete.length; i++){
            if(name_to_delete[i] == pane_from.dir_list[j].name){
                id_parent_to_delete.push(j);
            }
        }
    } 
  
    for(j=0;j<id_parent_to_delete.length; j++){
        pane_from.dir_list.remove(id_parent_to_delete[j] - j);
    } 

    if (flist=="") {
        return false;
    }
    flist = flist.substr(0, flist.length-1);
    var data = {
        action: 'mfma_relocator_move',
        dir_from: pane_from.cur_dir,
        dir_to: pane_to.cur_dir,
        items: flist
    };
    mrl_ajax_in();
    jQuery.ajax({
        url: ajaxurl, 
        data:data, 
        type:"POST"
    }).done(function(response) {
        if (response!="") {
            alert(response);
            pane_left.refresh_from_server();
            pane_right.refresh_from_server();
            return false;
        }
        
        mrl_ajax_out();
    });    
    return true;
}

//**** right-menu class *******************************************************************
var MrlRightMenuClass = function() {
    var num=0;
    var flgRegisterRemoveFunc = false;
    var pos_left = 0;
    var pos_right = 0;
}
// function name: MrlRightMenuClass::make
// description : make and display right-click menu
// argument : (items)array of menu items 
MrlRightMenuClass.prototype.make = function(items) {
    var html="";
    var i;
    jQuery('body').append('<div id="mfma_rl_right_menu"></div>');
    this.num = items.length;
    for (i=0; i<items.length; i++) {
        html += '<div class="mfma_rl_right_menu_item" id="mfma_rl_right_menu_item_' + i + '">';
        html += items[i];
        html += '</div>';
    }
    this.pos_left = mrloc_mouse_x;
    this.pos_top = mrloc_mouse_y;

    jQuery('#mfma_rl_right_menu').html(html);
    jQuery('#mfma_rl_right_menu').css('top',this.pos_top+"px");
    jQuery('#mfma_rl_right_menu').css('left',this.pos_left+"px");
    for (i=0; i<items.length; i++) {
        var id = 'mfma_rl_right_menu_item_' + i;
    /*
        jQuery('#'+id).hover(
            function(){
                this.removeClass('mrl_right_menu_item');
                this.addClass('mrl_right_menu_item_hover');
            },
            function(){
                this.removeClass('mrl_right_menu_item_hover');
                this.addClass('mrl_right_menu_item');
            }
            );
         */
    }
    if (!this.flgRegisterRemoveFunc) {
        jQuery(document).click(function(){
            jQuery('#mfma_rl_right_menu').remove();
        });
        this.flgRegisterRemoveFunc = true;
    }
}

// function name: MrlRightMenuClass::get_item_id
// description : get the id of the specified item
// argument : (n)index of item (starting from 0)
MrlRightMenuClass.prototype.get_item_id = function(n) {
    return 'mfma_rl_right_menu_item_' + n;
}

//**** Text input form class *******************************************************************
var MrlInputTextClass = function()
{
    var flgRegisterRemoveFunc = false;
    var pos_left = 0;
    var pos_right = 0;
    var result = "";
    var flgOK = false;
    var callback;
}
// function name: MrlInputTextClass::make
// description : make and display a text input form
// argument : (title)title; (init_text)initial text; (textbox_width)width of textbox
MrlInputTextClass.prototype.make = function(title, init_text, textbox_width, is_dirname) {
    this.is_dirname = is_dirname;
    var html="";
    jQuery('body').append('<div id="mfma_rl_input_text"></div>');
    html = '<div class="title">'+title+'</div>';
    html += '<input type="textbox" id="mfma_rl_input_textbox" style="width:'+textbox_width+'px"/>';
    html += '<div class="mfma_rl_input_text_button_wrapper">';
    html += '<button class="mfma_rl_input_text_button" id="mfma_rl_input_text_ok">Submit</button>';
    html += '<button class="mfma_rl_input_text_button" id="mfma_rl_input_text_cancel">Cancel</button>';
    html += '</div>';
    this.pos_left = mrloc_mouse_x;
    this.pos_top = mrloc_mouse_y;
    jQuery('#mfma_rl_input_text').html(html);
    jQuery('#mfma_rl_input_text').css('top',this.pos_top+"px");
    jQuery('#mfma_rl_input_text').css('left',this.pos_left+"px");
    jQuery('#mfma_rl_input_textbox').val(init_text);
    var that = this;
    jQuery('#mfma_rl_input_text_ok').click(function(){
        var result = jQuery('#mfma_rl_input_textbox').val();
        if (that.check_dotext(result, that.is_dirname)) {
            alert("Please do not use 'dot + file extension' pattern in the directory name because that can cause problems.");
            return;
        }
        if (that.check_invalid_chr(result)) {
            alert("The name is not valid.");
            return;
        }
        jQuery('body').unbind('click.mrlinput');
        that.result = result;
        jQuery('#mfma_rl_input_text').remove();
        that.callback();
    });
    jQuery('#mfma_rl_input_text_cancel').click(function(){
        jQuery('#mfma_rl_input_text').remove();
        jQuery('body').unbind('click.mrlinput');
    });
    jQuery('body').bind('click.mrlinput', function(e){
        e.preventDefault();
    })
    jQuery('#mfma_rl_input_textbox').focus();
}

// function name: MrlInputTextClass::set_callback
// description : register callback function called when OK is pressed
// argument : (c)callback function
MrlInputTextClass.prototype.set_callback = function(c) {
    this.callback = c;
}
// function name: MrlInputTextClass::check_dotext
// description : check if '.+file extension' pattern exists in the name (ex)abc.jpgdef
// argument : (str: target string, isdir: the name is of a directory)
// return : true(exists), false(not exists)
MrlInputTextClass.prototype.check_dotext = function(str, isdir) {
    var ext = ['.jpg', '.jpeg', '.gif', '.png', '.mp3','.m4a','.ogg','.wav',
    '.mp4v', '.mp4', '.mov', '.wmv', '.avi', '.mpg', '.ogv', '.3gp', '.3g2',  
    '.pdf', '.docx', '.doc', '.pptx', 'ppt', '.ppsx', '.pps', '.odt', '.xlsx', '.xls'];
    var i;
    for (i=0; i<ext.length; i++) {
        if (str.toLowerCase().indexOf(ext[i]) >= 0) {
            if (isdir) return true;
        }
    }
    return false;
}

// function name: MrlInputTextClass::invalid_chr
// description : check if invalid character exists in the name.
// argument : (str: target string)
// return : true(exists), false(not exists)
MrlInputTextClass.prototype.check_invalid_chr = function(str) {
    var chr = ["\\", "/", ":", "*", "?", "\"", "<", ">", "|", "%", "&"];
    var i;
    for (i=0; i<chr.length; i++) {
        if (str.indexOf(chr[i]) >= 0) {
            return true;
        }
    }
    return false;
}


//**** Global functions*********************************************************************************
// function name: adjust_layout
// description : adjust layout when resized
// argument : (void)
function adjust_layout() {
    var width_all = jQuery('#mfma_rl_wrapper_all').width();
    var height_all = jQuery('#mfma_rl_wrapper_all').height();
    var width_center =jQuery('#mfma_rl_center_wrapper').width(); 
    var height_mrl_box = jQuery('.mfma_rl_box1').height();
    var pane_w = (width_all - width_center)/2-1;
    jQuery('.mfma_rl_wrapper_pane').width(pane_w);
    jQuery('.mfma_rl_pane').width(pane_w);
    jQuery('.mfma_rl_pane').height(height_all - height_mrl_box);	
    jQuery('.mfma_rl_filename').width(pane_w-200);
    jQuery('#mfma_rl_center_wrapper').css('margin-top',height_all/2);
}
// function name: mrl_ajax_in
// description : recognize entering ajax procedure to avoid user interrupt while data processing
// argument : (void)
function mrl_ajax_in() {
    ajax_test ++;
/*
    mrl_ajax ++;
    document.body.style.cursor = "wait";
    if (mrl_ajax==1) jQuery(document).bind('click.mrl', function(e){
        e.cancelBubble = true;
        if (e.stopPropagation) {
            e.stopPropagation();
        }		
        e.preventDefault();
    });
     */
}
// function name: mrl_ajax_out
// description : recognize finishing ajax procedure
// argument : (void)
function mrl_ajax_out() {
    ajax_test --;
    
    mrl_ajax = 0;
    //mrl_ajax --;
    if (mrl_ajax == 0) {
        document.body.style.cursor = "default";
        jQuery(document).unbind('click.mrl');
    }
}



function dump(obj, v) {
    var out = '';
    for (var i in obj) {
        if(v){
            for (var j in obj[i]) {
                out += i+" "+j + ": " + obj[i][j] + "\n";
            }   
            out += "\n";
        }else{
            out += i+ ": " + obj[i] + "\n";
        }
    }

    alert(out);
}

Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};

function new_dir_popup(that) {
    if (mrl_ajax){
        return;
    } 
    mrloc_input_text.make("Name of the new folder","",300, true);		
    mrloc_input_text.set_callback(function(){
        var dir  =  mrloc_input_text.result;
        if (dir=="") return;
        if (that.check_same_name(dir)) {
            alert("A folder with the same name already exists.");
            return;
        }
        var data = {
            action: 'mfma_relocator_mkdir',
            dir: that.cur_dir,
            newdir: dir
        };
        mrl_ajax_in();
        jQuery.post(ajaxurl, data, function(response) {
            if (response != ""){
                alert(response);
                pane_left.refresh_from_server();
                pane_right.refresh_from_server();
            }
            mrl_ajax_out();
        });
        
        function item_new_dir(id, dir){
            var new_dir = new Array();
            new_dir['ids'] = id;
            new_dir['name'] = dir;
            new_dir['isdir'] = 1;
            new_dir['isemptydir'] = 1;
            new_dir['isthumb'] = 0;
            new_dir['norename'] = 0;
            new_dir['thumbnail_url'] = mrloc_plugin_url + '/images/dir.png';
            return new_dir;
        }
             
        that.dir_list.push(item_new_dir(that.dir_list.length, dir));
        that.refresh();    
             
        if (that.cur_dir == that.opposite.cur_dir) {
            that.opposite.dir_list.push(item_new_dir(that.opposite.dir_list.length, dir));
            that.opposite.refresh();
        }
    });
}

function delete_item(pane, id, multi){
    var target = pane.dir_list[id];
    var dirname = target['name'];
    var is_dir = target['isdir'];
    var is_confirmed = false;
    
    multi = typeof multi !== 'undefined' ? multi : false;
    if(!multi){
        is_confirmed = confirm('Are you sure you want to delete permanently "' + target['name'] + '"');
    }else{
        is_confirmed = true;
    }
    
    if(is_confirmed){
        if(is_dir){
            var isEmptyDir = target['isemptydir'];
            if (!isEmptyDir) {
                pane_left.refresh_from_server();
                pane_right.refresh_from_server();
                alert('The folder is not empty.');
                return 0;
            }
            pane.dir_list.remove(id);     
            
            pane.refresh();
            if (pane.cur_dir == pane.opposite.cur_dir) {
                pane.opposite.dir_list.remove(id);
                pane.opposite.refresh();
            }
            if (pane.cur_dir+dirname+"/" == pane.opposite.cur_dir) {
                pane.opposite.dir_list.remove(id);
                pane.opposite.refresh();
            }
                                
            var data = {
                action: 'mfma_relocator_delete_empty_dir',
                dir: pane.cur_dir,
                name: dirname
            };
    
            mrl_ajax_in();
            jQuery.post(ajaxurl, data, function(response) {
                if (response != "") {
                    pane_left.refresh_from_server();
                    pane_right.refresh_from_server();
                    alert(response);
                    return 0;
                }								
                mrl_ajax_out();
            });
            return 1;
        }else{
            var post_id = (typeof target['id'] === 'undefined') ? null : target['id'];
                                
            var variation = 0;
            for(var y = 0; y < pane.dir_list.length; y++){
                if(pane.dir_list[y]['parent'] ==  pane.dir_list[id - variation]['name']){
                    pane.dir_list.remove(y);
                    if (pane.cur_dir == pane.opposite.cur_dir) {
                        pane.opposite.dir_list.remove(y);
                    }
                    y--;
                    variation++;
                }
            }
            pane.dir_list.remove(id - variation);
                                
            pane.refresh();
            if (pane.cur_dir == pane.opposite.cur_dir) {
                pane.opposite.dir_list.remove(id - variation); 
                pane.opposite.refresh();
            }
                                
            var data = {
                action: 'mfma_relocator_delete',
                id: post_id,
                dir: pane.cur_dir,
                name: dirname
            };
                                
            mrl_ajax_in();
            jQuery.post(ajaxurl, data, function(response) {
                if (response != 0) {
                    pane_left.refresh_from_server();
                    pane_right.refresh_from_server();
                    alert(response);
                    return 0;
                }		
                mrl_ajax_out();
            });
            
            return variation + 1;
        }
    }
}

function check_dir(){
    
}

window.onerror = function(message, url, lineNumber) {  
    jQuery( "#dialog-confirm textarea" ).val("Line:" + lineNumber + "\n"+message);
    
    jQuery( "#dialog-confirm" ).dialog({
        resizable: false,
        height:300,
        modal: true,
        buttons: {
            "Contact administrator": function() {
                jQuery( this ).dialog( "close" );
                window.open('http://wordpress.org/support/plugin/media-file-manager-advanced');
            },
            "Continue": function() {
                jQuery( this ).dialog( "close" );
            }
        }
    }); 
       
    
    pane_left.refresh_from_server();
    pane_right.refresh_from_server();
    
    return true;
};
