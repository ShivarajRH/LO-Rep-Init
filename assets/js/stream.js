/**
 * @support mrshivaraj123@gmail.com
 */
    var default_entries=25;
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
        var note_visibility = $("#note_visibility").val();
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
        var postData = {note_text:enco(nl2br(note_text)),visibility:note_visibility};
        //console.log(postData);    return false;
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
        var reminder_name = $("#reminder_title").val();
        var reminder_date = $("#reminder_date").val();
        var reminder_time = $("#reminder_time").val();
        if(reminder_name == '') {alert("Enter note reminder title."); return false; }
        if(reminder_date == '') {alert("Please select reminder date."); return false; }
        if(reminder_time == '') {alert("Please select reminder time."); return false; }
        var uid = $("#uid").val();
        if(uid == '') {alert("Please Sign-In."); location=site_url+"?Please Sign-In."; return false; }

        var remind_time=reminder_date+" "+reminder_time;
        //store this data along with lat long info
        var lat='77';
        var long1='23';
        var timestamp=getTimeStamp();
        var divtext=document.getElementById("note_creator_div");


        var apiurl = "&uid="+enco(uid)+"&content_type=reminder&lat="+enco(lat)+"&long="+enco(long1)
            +"&timestamp="+timestamp;
        //console.log(apiurl);
        var postData = {remind_time:remind_time,reminder_name:enco(reminder_name)};
        //console.log(postData);

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

        //store this data, along with lat long info
        var lat='77';
        var long1='23';
        var timestamp=getTimeStamp();

        var apiurl = "&uid="+enco(uid)+"&content_type=expense&lat="+enco(lat)+"&long="+enco(long1)+"&timestamp="+timestamp;

        var postData = {title:enco(expense_title),desc:enco(expense_title),amount:(expense_amount)};

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
                                            str_exp = get_expense_list(expen.expenses);
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

                            output += get_reminders_list(rdata.reminders,max_reminder_count);

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
                                                                    <div class='' id='editor_"+content_id+"'>"+nl2br(linkHashtags(note_text))+"</div>";
                                                                    if(note_options_req=='yes') {
                                                                           note_output += "<div>\n\
                                                                                       <ul class='note-options'>\n\
                                                                                                <li class='note-options-single delete_icon fl_le' id=\"deleteBtn_"+content_id+"\"><a href='javascript:void(0)' onclick=\"delete_this(this,'"+content_id+"','note')\">&nbsp</a></li>\n\
                                                                                                <li class='note-options-single edit_icon fl_le' id=\"editorBtn_"+content_id+"\" onclick=\"edit_this('"+content_id+"')\">&nbsp</li>\n\
                                                                                                \n\
                                                                                                <li class='note-options-single save_tick_icon fl_le hide' id='editor_submit_"+content_id+"' onclick=\"save_edit_text(this,'"+content_id+"','note')\"></li>\n\
                                                                                                <li class='note-options-single cancel_icon fl_le hide' id='editor_cancel_"+content_id+"' onclick=\"cancel_edit_text('"+content_id+"');\"></li>\n\
                                                                                                <li><a class='note-options-single cancel_icon fl_le pop_open_icon' id='pop_open_icon_"+content_id+"' onclick=\"popthis_out('"+content_id+"','note');\" href='"+site_url+"note/?content_id="+content_id+"' target='_blank' class='pop_open_icon'></a></li>\n\
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

    var scrollInAction = false;
    var limit_start = default_entries+1;

    function loadNotesInfo(limit_start,limit_end) {
        var uid = $("#uid").val();
        console.log("limit_start="+limit_start+"\nlimit_end="+limit_end);
        var output='';

        var apiurl = "&uid="+enco(uid)+"&content_type=note&limit_start="+enco(limit_start)+"&limit_end="+enco(limit_end);
        $.post(site_url+"api/search/?action_object=list_content"+apiurl,{},function(rdata) {
                $(".all_note_list_box").append(get_notes_card(rdata.notes));
        },"json");  
    }

    function get_notes_card(results) {
        var note_output='';
        $.each(results,function(i,note) {

            var content_id= note.content_id;
            var note_id= note.note_id;
            var note_text = note.note_text;
            var note_image='';
            var note_options_req='yes';

            note_output += "<li class='pin single_note_card'>\n\
                            <img src='"+note_image+"' />\n\
                            <div class='' id='editor_"+content_id+"'>-"+nl2br(linkHashtags(note_text))+"</div>";

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
        //console.log(note_output);
        return note_output;
    }

    $(window).scroll(function() {
      var elt = document.getElementById("max_notes_count");
      if(elt != null) {
            var max_notes_count= elt.value;
//        alert(max_notes_count);
            if(max_notes_count > 0) {
                //console.log($(window).scrollTop() >= ($(document).height() - $(window).height() - 200));
                if  ($(window).scrollTop() >= ($(document).height() - $(window).height() - 200)) {
                      if (scrollInAction) {
                          return false;
                      }
                      else {
                             scrollInAction=true;
                             // loads content here
                             //alert("Limitstart = "+limit_start +" Default entries = "+ default_entries +"Max notes="+max_notes_count);
                             if(limit_start >= default_entries && limit_start <= max_notes_count) {
                                    if(max_notes_count >= limit_start) {
                                        var limit_end=default_entries;
                                        loadNotesInfo(limit_start,limit_end);
                                         //scrollInAction=false; // TODO: PUT this scrollInAction=false after ajax loading is completed.
                                    }
                                    else { 
                                        scrollInAction=false;
                                    }
                                    limit_start += default_entries;
                             }
                      }
                }
            }
      }
    });
     
    $(document).ready(function() {
        /*$("textarea,#tag_text,#reminder_title,#expense_title").hashtags();*/

        loadStreamData();

        $('input.cleanup').blur(function() {
    //        alert("BLUR");
            var value = $.trim( $(this).val() );
            //alert(value);
            $(this).val( value );
        });

    });

    function makeit_public(content_type) {
        if(content_type='note') {
            $("#note_visibility").val('pub');
            $("#btn_note_private").show();
            $("#btn_note_public").hide();
        }
    }
    
    function makeit_private(content_type) {
        if(content_type='note') {
            $("#note_visibility").val('pri');
            $("#btn_note_private").hide();
            $("#btn_note_public").show();
        }
    }
    
    function popthis_out(content_id,content_type) {
            //window.location.target="_blank";window.parent.location.href=site_url+"note_pop_page/?cid="+enco(content_id);
    }
    
    function search_all_stream(elt,content_type,uid) {
/*        var postData = {'requesting_uid':enco(requesting_uid),'query':enco(query),"timestamp":enco(timestamp),'lat':enco(lat),'long':enco(long),'src':enco($src)};*/
        $(".reset_filters").css({display:'block'});
        var query = $("#search_qry",elt).val();
        var src = 'streamsearch';
        var output='';
        
        var postData = {requesting_uid:enco(uid),query:enco(query),content_type:enco(content_type),src:enco(src)};

        $.post(site_url+'search/?query='+enco(query),postData,function(resp) {
            if(resp.status == 'success') {
                    // Notes
                    if(  (resp.notes) != undefined ) {
                        output += get_notes_card(resp.notes);
                        $(".all_note_list_box").html(output);
                    }
                    else {
                        $(".all_note_list_box").html("&nbsp;");
                    }
                    
                    // Reminders
                    
                    if( resp.reminders != undefined ) {
                        var ttl_reminders = (resp.reminders).length;
                        var max_reminder_count=150;
                        $("#ttl_reminders").html(ttl_reminders);
                        $(".reminders_list").html(get_reminders_list(resp.reminders,max_reminder_count));
                    }
                    else {
                        $("#ttl_reminders").html(0);
                        $(".reminders_list").html("No reminder data.");
                    }
                    
                    // EXPENSES
                    var array_push = [];
                    array_push.push(["Title","Amount"]);
                    if( (resp.expenses).length > 0 ) {
                        ttl_expense = 0;
                        $.each(resp.expenses,function(i,row) {
                                var exp_amount = parseFloat(row.expense_amount);
                                ttl_expense += exp_amount;
                                array_push.push([ row.expense_title,exp_amount]);
                        });
                        drawChart(array_push);
                        $("#expense_total").html(ttl_expense);
                        $(".expenses_list_container").html(get_expense_list(resp.expenses));
                    }
                    else {
                        $("#expense_total").html((resp.expenses).length);
                        array_push.push(['No results',(resp.expenses).length]);
                        drawChart(array_push);
                        $(".expenses_list_container").html("No results");
                    }
                    
                    //console.log("\nALL="+resp);
            }
            else {
                alert(resp.response);
            }
        },"json");
        //search_btn all_note_list_box
    }

    function get_expense_list(expenses) {
        var str_exp = '';
        $.each(expenses,function(i,expense){
                        var expense_name=expense.expense_title;
                        var expense_amount = expense.expense_amount;
                        var content_id = expense.content_id;
                        var content_type='expense';
                        var note_options_req='yes';

                        str_exp+="<li class='single_expense'>\n\
                                    <span class=''>"+linkHashtags(expense_name)+"</span>\n\
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
        return str_exp;
    }

    function get_reminders_list(reminders,max_reminder_count) {
            var output='';
            $.each(reminders,function(i,reminder){

                if(i<max_reminder_count) {

                    var reminder_id = reminder.reminder_id;
                    var reminder_name = reminder.reminder_name;
                    var reminder_time = showTimeStamp(reminder.remind_time);
                    var content_id = reminder.content_id;
                    var content_type = 'reminder';
                    var note_options_req='yes';

                    output += "<li class='list_single_reminder'>\n\
                            <span class='single_reminder_name'>"+linkHashtags(reminder_name)+"</span>\n\
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
            return output;
    }

    function reset_filters(elt) {
        $("#search_qry").val("");
        loadStreamData();
        $(elt).css({display:"none"});
    }

    var hashtag_regexp = /#([a-zA-Z0-9]+)/g;
    function linkHashtags(text) {
        return text.replace(
            hashtag_regexp,
            '<a class="hashtag" href="javascript:void(0);" onclick="tag_search(\'$1\')">#$1</a>'
        );// href="'+site_url+'tag/?q=$1" target="_blank"
    }
    
    function tag_search(tag) {
        var uid = $("#uid").val();
        var requesting_uid = uid;
        var privacy="pri";
        var time = getTimeStamp();
        var output = '';
        var postData = {uid:uid,requesting_uid:requesting_uid,privacy:privacy};
        //$.post(site_url+"tag/?q="+tag,postData,function(resp) {
        $.post(site_url+"api/search/?action_object=tag_content&content_type=all&tag="+tag,postData,function(resp) {
              if(resp.status == 'success') {
                    $(".reset_filters").css({display:'block'});
                    if(  (resp.notes).length > 0 ) {
                        output += get_notes_card(resp.notes);
                        $(".all_note_list_box").html(output);
                    }
                    else {
                        $(".all_note_list_box").html("&nbsp;");
                    }
                    var array_push = [];
                    array_push.push(["Title","Amount"]);
                    if( (resp.expenses).length > 0 ) {
                        ttl_expense = 0;
                        $.each(resp.expenses,function(i,row) {
                                ttl_expense += parseFloat(row.expense_amount);
                                array_push.push([ row.expense_title,parseFloat(row.expense_amount)]);
                        });
                        drawChart(array_push);
                        $("#expense_total").html(ttl_expense);
                        $(".expenses_list_container").html(get_expense_list(resp.expenses));
                    }
                    else {
                        $("#expense_total").html((resp.expenses).length);
                        array_push.push(['No results',(resp.expenses).length]);
                        drawChart(array_push);
                        $(".expenses_list_container").html("No results");
                    }
                    var ttl_reminders = (resp.reminders).length;
                    if( ttl_reminders > 0 ) {
                        var max_reminder_count=150;
                        $("#ttl_reminders").html(ttl_reminders);
                        $(".reminders_list").html(get_reminders_list(resp.reminders,max_reminder_count));
                    }
                    else {
                        $("#ttl_reminders").html(ttl_reminders);
                        $(".reminders_list").html("No reminder data.");
                    }
                    //console.log("\nALL="+resp);
            }
            else {
                alert(resp.response);
            }
        },"json");

        return false;
    }
