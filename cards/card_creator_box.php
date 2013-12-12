<input type="hidden" value="<?=$uid;?>" name="uid" id="uid"/>

<li class="pin-box new_content_card standard_card always_first">
    <div>
        <div class="creator_box">
            <div class="creator_options"><ul>
                
                <li class="create_note">
                    <div class="share_box_icon create_note_icon" onclick="return show_actions('note');"></div>
                </li>
                <li class="create_reminder">
                    <div class="share_box_icon create_reminder_icon" onclick="return show_actions('reminder');"></div>
                </li>
                <li class="create_expense">
                    <div class="share_box_icon create_expense_icon" onclick="return show_actions('expense');"></div>
                </li>
            </ul></div>
            <div class="clear"></div>
            <div class="creator_replace_box">
                <div id="note_creator" class="note_creator">
                    <form method="post" name="note_submit_form" id="note_submit_form" onsubmit="return submit_note_data(this);">
                        <textarea name="note_text" id="note_text" style="display: none;"></textarea>
                        <input type="hidden" value="pri" name="note_visibility" id="note_visibility"/>
                        <div id="note_creator_div" class="note_creator_div" contenteditable="true" onclick="clear_text(this);">Enter New Note Text...</div>
                        <br>
                        <div>
                              <div class="fl_le note-options-single visibility_private_icon" title="This note is public. Click again to make it private" id="btn_note_private" onclick="makeit_private('note');" style="display:none;"></div>
                                <div class="fl_le note-options-single visibility_public_icon" title="This note is private. Click again to make it public" id="btn_note_public" onclick="makeit_public('note');"></div>
                                <!--<button class="button fl_ri" style="margin-top:0%;">Save</button>-->
                        </div>
                        <button class="button fl_ri">Save</button>
                    </form>

                </div>
                <div id="reminder_creator" class="reminder_creator hide">
                        <form name="reminder_submit_form" id="reminder_submit_form" action="" method="POST" onsubmit="return submit_reminder_data(this);">
                            <input type="text" name="reminder_title" id="reminder_title" class="fl_le reminder_title" required maxlength="26" placeholder="Reminder Name">
                            <input type="date" name="reminder_date" id="reminder_date" class="fl_le reminder_date" required>
                            <input type="time" name="reminder_time" id="reminder_time" class="fl_le reminder_time" required>
                            <input type="submit" class="button fl_ri" value="+">
                           
                        </form>
                </div>
                <div id="expense_creator" style="clear:both;" class="expense_creator hide">
                        <form name="expense_submit_form" id="expense_submit_form" action="" method="POST" onsubmit="return submit_expense_data(this);">
                                <input type="text" name="expense_title" id="expense_title" placeholder="Name" class="fl_le expense_title" maxlength="30" required>
                                <input type="number" name="expense_amount" id="expense_amount" placeholder="Amount" class="fl_le expense_amount" min="-999999" max="999999" step="any" required>
                                <input type="submit" class="button fl_ri" value="+">
                                
                        </form>
                </div>
            </div>

        </div>
    </div>
</li>