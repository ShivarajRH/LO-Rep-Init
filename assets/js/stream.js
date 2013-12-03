/**
 * @support mrshivaraj123@gmail.com
 */
var defaultNoteText='Enter New Note Text...';
function clear_text(elt) {
    var notetxt = $(elt).text();
    if(notetxt==defaultNoteText) {
        $(elt).text("");
    }
}
function getDivContent(){
    var divtext=document.getElementById("note_creator_div");
    if(divtext.innerHTML!=defaultNoteText) {
        document.getElementById("note_text").value = divtext.innerHTML;
    }
    else {
        divtext.innerHTML="";divtext.focus();
    }
}
function submit_note_data(elt) {
    //$(elt).
    getDivContent();
    var note_text = $("#note_text").val();
    var uid = $("#uid").val();
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    if(note_text == '') { alert("Enter note input text."); return false; }
    
    
    //store this data 
    var lat='77';
    var long1='23';
    var timestamp=getTimeStamp();
    var divtext=document.getElementById("note_creator_div");
    
    
    var apiurl = "&uid="+enco(uid)+"&content_type=note&lat="+enco(lat)+"&long="+enco(long1)+"&timestamp="+timestamp;
    //console.log(apiurl);
    var postData = {note_text:enco(nl2br(note_text))};
    //console.log(postData);
    //&note_text=God%20gives%20as%20much%20as%20we%20can%20satisfy%20for%20life
    //&lat=77&long=33&timestamp=2013-02-01%2022:11:00
    //call note api
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            //alert("Note information stored successfully.");
            $("#note_submit_form").clearForm();
            divtext.innerHTML = defaultNoteText;
            loadStreamData();
        }
        else {
            console.log("\n"+rdata.response);
        }
        
    },"json").fail(fail);
    
    return false;
}
function fail(rdata){
    console.log(rdata.responseText);
}
function submit_reminder_data(elt) {
    //$(elt).
    var reminder_name = $("#reminder_title").val();
    var reminder_date = $("#reminder_date").val();
    var reminder_time = $("#reminder_time").val();
    if(reminder_name == '') {alert("Enter note reminder title."); return false; }
    if(reminder_date == '') {alert("Please select reminder date."); return false; }
    if(reminder_time == '') {alert("Please select reminder time."); return false; }
    var uid = $("#uid").val();
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    
    var remind_time=reminder_date+" "+reminder_time;
    //store this data 
    //along with lat long info
    //store this data 
    var lat='77';
    var long1='23';
    var timestamp=getTimeStamp();
    var divtext=document.getElementById("note_creator_div");
    
    
    var apiurl = "&uid="+enco(uid)+"&content_type=reminder&lat="+enco(lat)+"&long="+enco(long1)
        +"&timestamp="+timestamp;
    //console.log(apiurl);
    var postData = {remind_time:remind_time,reminder_name:enco(reminder_name)};
    console.log(postData);
    
    //&content_type=reminder&remind_time=2013-11-07%2001:23:22
    //&reminder_name=God%20textfor%20develpment%20ashhd&lat=77&long=33&timestamp=2013-11-06%2022:11:00
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            //alert("Reminder Added.");
            $("#reminder_submit_form").clearForm();
            loadStreamData();
        }
        else {
            console.log("\n"+rdata.response);
        }
        
    },"json").fail(fail);
    
    return false;
    
}

function submit_expense_data(elt) {
    //$(elt).
    var expense_title = $("#expense_title").val();
    var expense_amount = $("#expense_amount").val();
    
    if(expense_title == '') { alert("Enter note expense title."); return false; }
    if(expense_amount == '') { alert("Please select expense_amount."); return false; }
    
    var uid = $("#uid").val();
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    
    //store this data 
    //along with lat long info
    
    //store this data 
    var lat='77';
    var long1='23';
    var timestamp=getTimeStamp();
    
    var apiurl = "&uid="+enco(uid)+"&content_type=expense&lat="+enco(lat)+"&long="+enco(long1)+"&timestamp="+timestamp;
    //console.log(apiurl);
    var postData = {title:enco(expense_title),desc:enco(expense_title),amount:(expense_amount)};
    //console.log(postData);
    //return false;
    //api/write/?action_object=single_content&uid=54694568990687&content_type=expense
    //&title=God%20gives&desc=God%20textfor%20develpment%20ashhd&amount=1000&lat=77
    //&long=33&timestamp=2013-02-01%2022:11:00
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            //alert("Expense Info Added.");
            $("#expense_submit_form").clearForm();
            loadStreamData();
        }
        else {
            console.log("\n"+rdata.response);
        }
    },"json").fail(fail);
    
    return false;
}

function loadStreamData() {
    var uid = $("#uid").val();
    
    var content_target_src = $("#content_target_src").val();
    
    $(".stream_replace_content").html('<div class="">Loading</div>');
    $.post(site_url+"api/search/?action_object=list_content&uid="+uid+"&content_type=all",{},function(rdata) {

            if(content_target_src=='stream' || content_target_src == 'manage_expenses') {

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
                                                        content_type='expense';
                                                        note_options_req='yes';

                                                        str_exp+="<li class='single_expense'>\n\
                                                                    <span class=''>"+expense_name+"</span>\n\
                                                                    <span class='fl_ri'>"+expense_amount+"</span>";

                                                         if(note_options_req == 'yes') {
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
            // ====================
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
                                //$uid;
                                var note_options_req='yes';
                                output += "<li class='list_single_reminder'>\n\
                                        <span class='single_reminder_name'>"+reminder_name+"</span>\n\
                                        <span class='single_reminder_time fl_ri'>"+reminder_time+"</span>";


                                        if(note_options_req=='yes') {
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
            
            
            if(content_target_src=='stream') {
                    //NOTES CODE
                    var note_output='';
                    
                    if(rdata.notes != null) {
                        var max_notes_count = (rdata.notes).length;
                        if(max_notes_count==0)
                        {
                                var max_notes_count=1;
                                var note_text='';
                                var note_image='';
                        }
                        $.each(rdata.notes,function(i,note) {
                                var content_id= note.content_id;
                                var note_id= note.note_id;
                                var note_text = note.note_text;
                                var note_image='';
                                var note_options_req='yes';
                                note_output += "<li class='pin single_note_card'>\n\
                                                    <img src='"+note_image+"' />\n\
                                                    <div class='editable_block' id='editor_"+content_id+"'>"+nl2br(note_text)+"</div>";
                                                    
                                                    if(note_options_req=='yes') {
                                                           note_output += "<div>\n\
                                                                       <ul class='note-options'>\n\
                                                                                <li class='note-options-single delete_icon fl_le' id=\"deleteBtn_"+content_id+"\"><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','note')\">&nbsp</a></li>\n\
                                                                                <li class='note-options-single edit_icon fl_le' id=\"editorBtn_"+content_id+"\" onclick=\"edit_this(this,'"+content_id+"','note')\">&nbsp</li>\n\
                                                                                \n\
                                                                                <li class='note-options-single save_tick_icon fl_le hide' id='editor_submit_"+content_id+"'></li>\n\
                                                                                <li class='note-options-single cancel_icon fl_le hide' id='editor_cancel_"+content_id+"'></li>\n\
                                                                        </ul>\n\
                                                               </div>";
                                                   }

                                note_output +="</li>";

                        });
                    }
                    $(".all_note_list_box").html(note_output);
            }
            
            


                                                
            
    },"json").fail(fail);
    return false;
}

function edit_this(elt,content_id,cont_type) {
    
    var editorBtn = $('#editorBtn_'+content_id);
    var deleteBtn = $('#deleteBtn_'+content_id);
    var element = document.getElementById('editor_'+content_id);
    var elementSubmitBtn = $('#editor_submit_'+content_id);
    var elementCancelBtn = $('#editor_cancel_'+content_id);
    //editorBtn.addEventListener('click', function(e) {});
     
      if (element.isContentEditable) {
        // Disable Editing
        element.contentEditable = 'false';
        var note_text = element.innerHTML;
        
        elementSubmitBtn.addClass("hide");
        elementCancelBtn.addClass("hide");
        editorBtn.removeClass("hide");
        deleteBtn.removeClass("hide");
        
        
        //here call modify API
        
            
            
        // You could save any changes here.
      } else {
        element.contentEditable = 'true';
        elementSubmitBtn.removeClass("hide");
        elementCancelBtn.removeClass("hide");
        editorBtn.addClass("hide");
        deleteBtn.addClass("hide");
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

$(document).ready(function() {
    loadStreamData();
    //clearing form fields...
    $.fn.clearForm = function() {
      return this.each(function() {
            var type = this.type, tag = this.tagName.toLowerCase();
            if (tag == 'form')
              return $(':input',this).clearForm();
            if (type == 'text' || type == 'password' || tag == 'textarea')
              this.value = '';
            else if (type == 'checkbox' || type == 'radio')
              this.checked = false;
            else if (tag == 'select')
              this.selectedIndex = -1;
      });
    };

});