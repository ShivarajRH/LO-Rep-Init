/**
 * @support mrshivaraj123@gmail.com
 */
function show_actions(content_type) {
    if(content_type=='note') {
        $(".note_creator").removeClass("hide");
        $(".reminder_creator").addClass("hide");
        $(".expense_creator").addClass("hide");
    }
    else if(content_type=='reminder') {
        $(".note_creator").addClass("hide");
        $(".reminder_creator").removeClass("hide");
        $(".expense_creator").addClass("hide");
    }
    else if(content_type=='expense') {
        $(".note_creator").addClass("hide");
        $(".reminder_creator").addClass("hide");
        $(".expense_creator").removeClass("hide");
    }
}

function getDivContent(){
    var divtext=document.getElementById("note_creator_div");
    if(divtext.innerHTML!='Erase this and Create New ...') {
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
    if(note_text == '') { alert("Enter note input text."); return false; }
    if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }
    
    //store this data 
    var lat='77';
    var long1='23';
    var timestamp=getTimeStamp(); 
    $("#note_submit_form").clearForm();
return false;
    var apiurl = "&uid="+enco(uid)+"&content_type=note&lat="+enco(lat)+"&long="+enco(long1)+"&timestamp="+timestamp;
    //console.log(apiurl);
    var postData = {note_text:note_text};
    console.log(postData);
    //&note_text=God%20gives%20as%20much%20as%20we%20can%20satisfy%20for%20life
    //&lat=77&long=33&timestamp=2013-02-01%2022:11:00
    //call profile api
    $.post(site_url+"api/write/?action_object=single_content"+apiurl,postData,function(rdata) {
        if(rdata.status == "success") {
            console.log("Note information stored successfully.");
            $("#note_submit_form").clearForm();
        }
        else {
            console.log("\n"+rdata.response);
        }
        
    },"json");
    
    return false;
}
function submit_reminder_data(elt) {
    //$(elt).
    var reminder_title = $("#reminder_title").val();
    var reminder_date = $("#reminder_date").val();
    var reminder_time = $("#reminder_time").val();
    if(reminder_title == '') {alert("Enter note reminder title."); return false; }
    if(reminder_date == '') {alert("Please select reminder date."); return false; }
    if(reminder_time == '') {alert("Please select reminder time."); return false; }
    //store this data 
    //along with lat long info
    return true;
}

function submit_expense_data(elt) {
    //$(elt).
    var expense_title = $("#expense_title").val();
    var expense_amount = $("#expense_amount").val();
    
    if(expense_title == '') { alert("Enter note expense title."); return false; }
    if(expense_amount == '') { alert("Please select expense_amount."); return false; }
    
    //store this data 
    //along with lat long info
    return true;
}

$(document).ready(function() {
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