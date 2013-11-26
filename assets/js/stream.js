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
    var postData = {note_text:note_text};
    //console.log(postData);
    //&note_text=God%20gives%20as%20much%20as%20we%20can%20satisfy%20for%20life
    //&lat=77&long=33&timestamp=2013-02-01%2022:11:00
    //call note api
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            alert("Note information stored successfully.");
            $("#note_submit_form").clearForm();
            divtext.innerHTML = defaultNoteText;
        }
        else {
            console.log("\n"+rdata.response);
        }
        
    },"json").fail(fail);
    
    return false;
}
function fail(rdata){
    alert(rdata.responseText);
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
    var postData = {remind_time:remind_time,reminder_name:reminder_name};
    console.log(postData);
    
    //&content_type=reminder&remind_time=2013-11-07%2001:23:22
    //&reminder_name=God%20textfor%20develpment%20ashhd&lat=77&long=33&timestamp=2013-11-06%2022:11:00
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            alert("Reminder Added.");
            $("#reminder_submit_form").clearForm();
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
    var postData = {title:expense_title,desc:expense_title,amount:expense_amount};
    //console.log(postData);
    //return false;
    //api/write/?action_object=single_content&uid=54694568990687&content_type=expense
    //&title=God%20gives&desc=God%20textfor%20develpment%20ashhd&amount=1000&lat=77
    //&long=33&timestamp=2013-02-01%2022:11:00
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            alert("Expense Info Added.");
            $("#expense_submit_form").clearForm();
        }
        else {
            console.log("\n"+rdata.response);
        }
    },"json").fail(fail);
    
    return false;
}

function loadStreamData() {
    var uid = $("#uid").val();
    //api/search/?action_object=list_content&uid=6585877897&content_type=all
    $(".stream_replace_content").html('<div class="">Loading</div>');
    $.post(site_url+"api/search/?action_object=list_content&uid="+uid+"&content_type=all",{},function(rdata) {
            $("#expense_total").html(rdata.expense_total);
            var total_reminders = (rdata.reminders).length;
            $("#ttl_reminders").html(total_reminders);
            
            
            var content_target_src ='stream';
            
        if (content_target_src =='stream')
                var max_reminder_count=4;
        else if (content_target_src=='manage_reminders')
                var max_reminder_count = total_reminders;
        
        if(max_reminder_count==0)
        {
                max_reminder_count=1;
                var reminder_name='Add Something';
        }
        
        var output = "";
        $.each(rdata.reminders,function(i,reminder){
            
        
        
                var reminder_id = reminder.reminder_id;
                var reminder_name = reminder.reminder_name;
                var reminder_time = reminder.remind_time;
                var content_id = reminder.content_id;
                var content_type = 'reminder';
                //$uid;
                var note_options_req='yes';
                output = "<li class='list_single_reminder'>\n\
                                <span class='single_reminder_name'>"+reminder_name+"</span>\n\
                                <span class='single_reminder_time fl_ri'>"+reminder_time+"</span>";
        
                                
                                if(note_options_req=='yes') {
                                        output += "<div>\n\
                                                    <ul class='note-options'>\n\
                                                            <li class='note-options-single fl_le'><img class='' src='http://commondatastorage.googleapis.com/lyfeon%2Ficons%2Fdelete.png' alt='Delete' title='Delete'/></li>\n\
                                                            <li class='note-options-single fl_le'><img class='' src='http://commondatastorage.googleapis.com/lyfeon%2Ficons%2Fedit.png' alt='Edit' title='Edit'/></li>\n\
                                                    </ul>\n\
                                            </div>";
                                }
                                
                                output += "</li>";
                        
                if (content_target_src=='stream' && total_reminders > 4)
                {
                        var view_all_target='/manage_reminders';
                        output += "<p class=''>\n\
                                            <a href='"+view_all_target+"'>";
                                    output += "<span class='fl_ri' style='font-size: 75%;'>View All</span></a>\n\
                                    </p>";
                }
                
                
            });
            $(".reminders_block").html(output);





                                                
            $(".stream_replace_content").html(rdata);
    },"json").fail(fail);
    return false;
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