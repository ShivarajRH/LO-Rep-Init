/**
 * @support mrshivaraj123@gmail.com
 */

function fail(rdata){
    console.log(rdata.responseText);
}

var default_entries=35;
function loadStreamData() {
    var uid = $("#uid").val();
    var sess_uid = $("#sess_uid").val();
    
    var content_target_src = $("#content_target_src").val();
    
    $(".stream_replace_content").html('<div class="">Loading</div>');
    $.post(site_url+"api/search/?action_object=list_content&uid="+uid+"&content_type=all",{},function(rdata) {

            if(content_target_src=='stream' || content_target_src == 'manage_expenses'|| content_target_src == 'u') {

                //EXPENSES INFORMATION
                var exp_output='';
                $("#expense_total").html((Math.round(rdata.expense_total)*100)/100);

                if(content_target_src == 'manage_expenses')
                {   
                        $.post(site_url+"api/search/?action_object=list_content&uid="+uid+"&content_type=expense",{},function(expen) {
                                    var max_expenses_count = (expen.expenses).length;
                                    var str_exp='';
                                    if(max_expenses_count==0)
                                    {
                                            max_expenses_count=1;
                                            str_exp='Add Something';
                                    }
                                    if(expen.expenses != null) {
                                        $.each(expen.expenses,function(i,expense){
                                                        var expense_name=expense.expense_title;
                                                        var expense_amount = expense.expense_amount;
                                                        var content_id = expense.content_id;
                                                        var content_type='expense';
                                                        var note_options_req='yes';

                                                        str_exp+="<li class='single_expense'>\n\
                                                                    <span class=''>"+expense_name+"</span>\n\
                                                                    <span class='fl_ri'>"+expense_amount+"</span>";

                                                         if(note_options_req == 'yes' && sess_uid!='') {
                                                                str_exp += "<div>\n\
                                                                            <ul class='note-options'>\n\
                                                                                    <li class='note-options-single delete_icon fl_le'><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','expense')\">&nbsp</a></li>\n\
                                                                                    <li class='note-options-single edit_icon fl_le'>&nbsp</li>\n\
                                                                            </ul>\n\
                                                                    </div>";
                                                        }

                                                        str_exp +="</li>";
                                        });
                                    }
                                    
                                    $(".expenses_list_container").html("<ul class='expenses_list'>"+str_exp+"</ul>");
                
                        },"json");
                }
            }
            // REMINDERS INFORMATION
            if(rdata.reminders != null) {
                var total_reminders = (rdata.reminders).length;
                $("#ttl_reminders").html(total_reminders);
        
                // REMINDER CODE
                if (content_target_src =='stream')
                        var max_reminder_count=4;
                else if (content_target_src=='manage_reminders')
                        var max_reminder_count = total_reminders;
                var output = "";
                if(max_reminder_count==0)
                {
                        max_reminder_count=1;
                        output +='Add Something';
                }
                else {
                
                    $.each(rdata.reminders,function(i,reminder){

                        if(i<max_reminder_count) {

                                var reminder_id = reminder.reminder_id;
                                var reminder_name = reminder.reminder_name;
                                var reminder_time = showTimeStamp(reminder.remind_time);
                                var content_id = reminder.content_id;
                                var content_type = 'reminder';
                                var note_options_req='yes';
                                
                                output += "<li class='list_single_reminder'>\n\
                                        <span class='single_reminder_name'>"+reminder_name+"</span>\n\
                                        <span class='single_reminder_time fl_ri'>"+reminder_time+"</span>";


                                        if(note_options_req == 'yes' && sess_uid!='') {
                                                output += "<div>\n\
                                                            <ul class='note-options'>\n\
                                                                    <li class='note-options-single delete_icon fl_le'><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','reminder')\">&nbsp</a></li>\n\
                                                                    <li class='note-options-single edit_icon fl_le'>&nbsp</li>\n\
                                                            </ul>\n\
                                                    </div>";
                                        }

                                        output += "</li>";
                            }
                        });
                        if (content_target_src=='stream' && total_reminders > 4)
                        {
                                var view_all_target=site_url+'manage_reminders';
                                output += "<p class=''>\n\
                                                    <a href='"+view_all_target+"'>";
                                            output += "<span class='fl_ri' style='font-size: 75%;'>View All</span></a>\n\
                                            </p>";
                        }
                    }
                    $(".reminders_list").html(output);
                    //END REMINDER CODE
            }
            
            //NOTES INFORMATION
            if(content_target_src=='stream'|| content_target_src == 'u') {
                    var note_output='';
                    
                    if(rdata.notes != null) {
                        var max_notes_count = (rdata.notes).length;
                        
                        if(max_notes_count==0)
                        {
                                var max_notes_count=1;
                                var note_output='Add Note';
                                var note_image='';
                        }
                        else {
                            
                            //loadNotesInfo(rdata.notes,max_notes_count);
                            
                                $.each(rdata.notes,function(i,note) {
                                    
                                        if(i < default_entries) {
                                            var content_id= note.content_id;
                                            var note_id= note.note_id;
                                            var note_text = note.note_text;
                                            var note_image='';
                                            var note_options_req='yes';
                                            note_output += "<li class='pin single_note_card'>\n\
                                                                <img src='"+note_image+"' />\n\
                                                                <div class='' id='editor_"+content_id+"'>"+nl2br(note_text)+"</div>";
                                                                if(note_options_req=='yes' && sess_uid != '') {
                                                                       note_output += "<div>\n\
                                                                                   <ul class='note-options'>\n\
                                                                                            <li class='note-options-single delete_icon fl_le' id=\"deleteBtn_"+content_id+"\"><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','note')\">&nbsp</a></li>\n\
                                                                                            <li class='note-options-single edit_icon fl_le' id=\"editorBtn_"+content_id+"\" onclick=\"edit_this('"+content_id+"')\">&nbsp</li>\n\
                                                                                            \n\
                                                                                            <li class='note-options-single save_tick_icon fl_le hide' id='editor_submit_"+content_id+"' onclick=\"save_edit_text(this,'"+content_id+"','note')\"></li>\n\
                                                                                            <li class='note-options-single cancel_icon fl_le hide' id='editor_cancel_"+content_id+"' onclick=\"cancel_edit_text('"+content_id+"');\"></li>\n\
                                                                                            <li><a class='note-options-single cancel_icon fl_le pop_open_icon' id='pop_open_icon_"+content_id+"' onclick=\"popthis_out('"+content_id+"','note');\" href='"+site_url+"note/?uid="+uid+"&content_id="+content_id+"' target='_blank' class='pop_open_icon'></a></li>\n\
                                                                                    </ul>\n\
                                                                           </div>";
                                                               }

                                            note_output +="</li>";
                                        }

                                });
                        }
                        $("#max_notes_count").val(max_notes_count);
                    }
                    $(".all_note_list_box").html(note_output);
            }
            
            


                                                
            
    },"json").fail(fail);
    return false;
}

function save_edit_text(elt,content_id,cont_type) {
    var editorBtn = $('#editorBtn_'+content_id);
    var deleteBtn = $('#deleteBtn_'+content_id);
    var element = document.getElementById('editor_'+content_id);
    var note_text = $.trim(element.innerHTML);
        //alert(note_text);
    if(note_text == '') {
        alert("enter text");
        element.focus();
        return false;
    }
            
    var elementSubmitBtn = $('#editor_submit_'+content_id);
    var elementCancelBtn = $('#editor_cancel_'+content_id);
    
    element.contentEditable = 'false';removeClass("editable_block edit_block"+content_id);
    elementSubmitBtn.addClass("hide");
    elementCancelBtn.addClass("hide");
    editorBtn.removeClass("hide");
    deleteBtn.removeClass("hide");
    
    //here call modify API
    var uid = $("#uid").val();
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    //if(!confirm("Are you sure you want to modify this "+cont_type+"?") ) {return false;}
    
    var lat='77';
    var long1='23';
    var timestamp=getTimeStamp();
    
    var apiurl ="&lat="+enco(lat)+"&long="+enco(long1)+"&timestamp="+timestamp;
    var postData = {uid:enco(uid),content_type:enco(cont_type),content_id:enco(content_id),note_text:enco(note_text)};
    //console.log(postData);
    $.post(site_url+"api/modify/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            loadStreamData();
        }
        else {
            console.log("\n"+rdata.response);
        }
    },"json").fail(fail);
}

function cancel_edit_text(content_id) {
    var editorBtn = $('#editorBtn_'+content_id);
    var deleteBtn = $('#deleteBtn_'+content_id);
    var popopenBtn = $('#pop_open_icon_'+content_id);
    var element = document.getElementById('editor_'+content_id);
    var elementSubmitBtn = $('#editor_submit_'+content_id);
    var elementCancelBtn = $('#editor_cancel_'+content_id);
    //editorBtn.addEventListener('click', function(e) {});
     
     element.contentEditable = 'false';removeClass("editable_block edit_block"+content_id);
     editorBtn.removeClass("hide");
     deleteBtn.removeClass("hide");
     popopenBtn.removeClass("hide");
     elementSubmitBtn.addClass("hide");
     elementCancelBtn.addClass("hide");
}

function edit_this(content_id) {
    
    var editorBtn = $('#editorBtn_'+content_id);
    var deleteBtn = $('#deleteBtn_'+content_id);
    var popopenBtn = $('#pop_open_icon_'+content_id);
    var element = document.getElementById('editor_'+content_id);
    var elementSubmitBtn = $('#editor_submit_'+content_id);
    var elementCancelBtn = $('#editor_cancel_'+content_id);
    
      if (element.isContentEditable) {
            
        // You could save any changes here.
      } else {
        element.contentEditable = 'true';
        element.setAttribute("class","editable_block edit_block"+content_id);
        
        elementSubmitBtn.removeClass("hide");
        elementCancelBtn.removeClass("hide");
        editorBtn.addClass("hide");
        deleteBtn.addClass("hide");
        popopenBtn.addClass("hide");
      }
}

function delete_this(elt,content_id,cont_type) {
    
    var uid = $("#uid").val();
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    //if(!confirm("Are you sure you want to delete this "+cont_type+"?") ) {return false;}
    
    var postData = {uid:uid,content_type:cont_type,content_id:content_id};
    //console.log(postData);
    $.post(site_url+"api/delete/?action_object=single_content",postData,function(rdata) {
        if(rdata.status == "success") {
            //alert("Reminder Deleted.");
            loadStreamData();
        }
        else {
            console.log("\n"+rdata.response);
        }
    },"json").fail(fail);
    
}
function removeClass(className) {
    // convert the result to an Array object
    var els = Array.prototype.slice.call(
        document.getElementsByClassName(className)
    );
    for (var i = 0, l = els.length; i < l; i++) {
        var el = els[i];
        el.className = el.className.replace(
            new RegExp('(^|\\s+)' + className + '(\\s+|$)', 'g'),
            '$1'
        );
    }
    
}
var scrollInAction = false;
var limit_start = default_entries;

function loadNotesInfo(limit_start,limit_end) {
    var uid = $("#uid").val();
    
    var apiurl = "&uid="+enco(uid)+"&content_type=note&limit_start="+enco(limit_start)+"&limit_end="+enco(limit_end);
    
    $.post(site_url+"api/search/?action_object=list_content"+apiurl,{},function(rdata) {
            var note_output='';
            //console.log(rdata.notes);
            $.each(rdata.notes,function(i,note) {
                       
                        var content_id= note.content_id;
                        var note_id= note.note_id;
                        var note_text = note.note_text;
                        var note_image='';
                        var note_options_req='yes';
                        note_output += "<li class='pin single_note_card'>\n\
                                            <img src='"+note_image+"' />\n\
                                            <div class='' id='editor_"+content_id+"'>"+nl2br(note_text)+"</div>";

                                            if(note_options_req=='yes') {
                                                   note_output += "<div>\n\
                                                               <ul class='note-options'>\n\
                                                                        <li class='note-options-single delete_icon fl_le' id=\"deleteBtn_"+content_id+"\"><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','note')\">&nbsp</a></li>\n\
                                                                        <li class='note-options-single edit_icon fl_le' id=\"editorBtn_"+content_id+"\" onclick=\"edit_this('"+content_id+"')\">&nbsp</li>\n\
                                                                        \n\
                                                                        <li class='note-options-single save_tick_icon fl_le hide' id='editor_submit_"+content_id+"' onclick=\"save_edit_text(this,'"+content_id+"','note')\"></li>\n\
                                                                        <li class='note-options-single cancel_icon fl_le hide' id='editor_cancel_"+content_id+"' onclick=\"cancel_edit_text('"+content_id+"');\"></li>\n\
                                                                </ul>\n\
                                                       </div>";
                                           }

                        note_output +="</li>";
                        
                        
                        scrollInAction=false;
                        
            });
            
            
            $(".all_note_list_box").append(note_output);
    },"json");
    
}
  $(window).scroll(function(){
        var max_notes_count= document.getElementById("max_notes_count").value;
        
        if(max_notes_count > 0) {
                //console.log($(window).scrollTop() >= ($(document).height() - $(window).height() - 200));
                   if  ($(window).scrollTop() >= ($(document).height() - $(window).height() - 200)){

                         if (scrollInAction)
                         {
                             return false;
                         }
                         else
                         {
                                scrollInAction=true;
                                //do stuff // load of more content here
                                //console.log("Down");
                                
                                
                                if(limit_start >= default_entries && limit_start <= max_notes_count) {
                                        limit_start += 10;

                                        if(max_notes_count >= limit_start) {

                                            var limit_end=1;
//                                            console.log(limit_start);
                                            loadNotesInfo(limit_start,limit_end);
                                             //scrollInAction=false; // TODO: PUT this scrollInAction=false after ajax loading is completed.
                                        }
                                        else { 
                                            scrollInAction=false;
                                        }
                                }
                         }
                   }
        }
  });
  
     
$(document).ready(function() {
    loadStreamData();
});

    function popthis_out(content_id,content_type) {
            //window.location.target="_blank";
            //window.parent.location.href=site_url+"note_pop_page/?cid="+enco(content_id);
    }

