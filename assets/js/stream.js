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
function submit_note_data(elt) {
    //$(elt).
    var note_text = $("#note_text").val();
    var uid = $("#uid").val();
    if(note_text == '') {alert("Enter note input text."); return false; }
    if(uid == '') {alert("Please login."); return false; location=""; }
    //store this data 
    //along with lat long info
    return true;
}
function submit_reminder_data(elt) {
    //$(elt).
    var reminder_title = $("#reminder_title").val();
    var reminder_date = $("#reminder_date").val();
    var reminder_time = $("#reminder_time").val();
    if(reminder_title == '') {alert("Enter note reminder title."); return false; }
    if(reminder_date == '') {alert("Please select reminder date."); return false; location=""; }
    if(reminder_time == '') {alert("Please select reminder time."); return false; location=""; }
    //store this data 
    //along with lat long info
    return true;
}
function submit_expense_data(elt) {
    //$(elt).
    var expense_title = $("#expense_title").val();
    var expense_amount = $("#expense_amount").val();
    
    if(expense_title == '') {alert("Enter note expense title."); return false; }
    if(expense_amount == '') {alert("Please select expense_amount."); return false; }
    
    //store this data 
    //along with lat long info
    return true;
}