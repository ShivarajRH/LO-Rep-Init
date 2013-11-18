<input type="hidden" value="" name="uid" id="uid"/>

<li class="pin-box new_content_card standard_card always_first">
    <div>
        <div class="creator_box">
            <div class="creator_options"><ul>
                
                <!--return show_actions1();-->
                <li class="create_note">
                    <div class="share_box_icon" onclick="return show_actions('note');">
                        <img class="fl_le" src="<?=$img_url?>icons/note.png" title="Create Note"/>
                    </div>
                </li>

                <li class="create_reminder">
                    <div class="share_box_icon" onclick="return show_actions('reminder');">
                        <img class="fl_le" src="<?=$img_url?>icons/clock.png" title="Create Reminder"/>
                    </div>
                </li>
                <li class="create_expense">
                    <div class="share_box_icon" onclick="return show_actions('expense');">
                        <img class="" src="<?=$img_url?>icons/expenses.png" title="Record Expense"/>
                    </div>
                </li>
                    <!--
                    <li class="share_box_icon create_location">
                            <img onclick="" class="" src="http://commondatastorage.googleapis.com/lyfeon%2Ficons%2Flocation.png" title="Record Location"></img>
                    </li>
                    <li class="share_box_icon create_message">
                            <img onclick="" class="" src="http://commondatastorage.googleapis.com/lyfeon%2Ficons%2Fmessage.png"  title="Create Message"></img>
                    </li>
                    <li class="share_box_icon create_list">
                            <img onclick="" class="" src="http://commondatastorage.googleapis.com/lyfeon%2Ficons%2Flist.png"  title="Create List"></img>
                    </li>
                    -->

            </ul></div>
            <div class="clear"></div>
            <div class="creator_replace_box">
                <div id="note_creator" class="note_creator">
                    <form method="post" name="note_submit_form" onsubmit="return submit_note_data(this);">
                        <input type="text" value="" placeholder="Erase this and Create New ..." name="note_text" id="note_text"/>
                        <button class="button fl_ri">Save</button>
                    </form>
                </div>
                <div id="reminder_creator" class="reminder_creator hide">
                        <form name="reminder_submit_form" action="" method="POST" onsubmit="return submit_reminder_data(this);">
                            <input type="text" name="reminder_title" id="reminder_title" class="fl_le reminder_title" required maxlength="26" placeholder="Reminder Name">
                            <input type="date" name="reminder_date" id="reminder_date" class="fl_le reminder_date" required>
                            <input type="time" name="reminder_time" id="reminder_time" class="fl_le reminder_time" required>
                            <input type="submit" class="button fl_ri" value="+">
                        </form>
                </div>
                <div id="expense_creator" style="clear:both;" class="expense_creator hide">
                        <form name="expense_submit_form" action="" method="POST" onsubmit="return submit_expense_data(this);">
                                <input type="text" name="expense_title" placeholder="Name" class="fl_le expense_title" maxlength="30" required>
                                <input type="number" name="expense_amount" placeholder="Amount" class="fl_le expense_amount" min="-999999" max="999999"  required>
                                <input type="submit" class="button fl_ri" value="+">
                        </form>
                </div>
            </div>

                <!-- ************* ALTERNATE METHOD

                <div class="creator_box">
                        <ul>
                                <li class="share_box_icon create_note">
                                        <img onclick="" class="" src="../assets/images/note.png"></img>
                                        <ul><li>
                                                <div id="note_creator" class="note_creator" contentEditable="true">Erase this and Create New ...</div>
                                        </li></ul>
                                </li>
                                <li class="share_box_icon create_reminder">
                                        <img onclick="" class="" src="../assets/images/clock.png"></img>
                                        <ul><li>
                                                <div id="reminder_creator" class="reminder_creator">
                                                        <form name="reminder_submit_form" action="" method="POST">
                                                                <input type="text" name="reminder_title" class="fl_le reminder_title" maxlength="30" placeholder="Reminder Name">
                                                                <input type="date" name="reminder_date" class="fl_le reminder_date" required>
                                                                <input type="time" name="reminder_time" class="fl_le reminder_time" required>
                                                                <input type="submit" class="button fl_ri" value="+">
                                                        </form>
                                                </div>
                                        </li></ul>
                                </li>
                                <li class="share_box_icon create_expense">
                                        <img onclick="" class="" src="../assets/images/expenses.png"></img>
                                        <ul><li>
                                                <div id="expense_creator" style="clear:both;" class="expense_creator">
                                                        <form name="expense_submit_form" action="" method="POST">
                                                                <input type="text" name="expense_title" placeholder="Name" class="fl_le expense_title" maxlength="30">
                                                                <input type="number" name="expense_amount" placeholder="Amount" class="fl_le expense_amount" min="-999999" max="999999"  required>
                                                                <input type="submit" class="button fl_ri" value="+">
                                                        </form>
                                                </div>
                                        </li></ul>
                                </li>
                        </ul>
                </div>


            -->

        </div>
    </div>
</li>
<script>
function show_actions1() {
    alert("Hi");
    return false;
}
</script>