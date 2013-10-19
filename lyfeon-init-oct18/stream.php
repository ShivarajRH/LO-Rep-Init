<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="assets/css/global.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://lyfeon.com/fonts/font.css">
	<link rel="shortcut icon" type="image/png" href="assets/logos/favicon.png"/>
    </style>   
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	
	<title>LyfeOn : Your Stuff</title>
	<meta name="description" content="Manage your notes, reminders and expenses.">
</head>	
<body>
	<div class="header">
			<div class="logo">
				<a href="">
					<img class="fl_le" src="assets/logos/lyfeon.png" style="padding-left:1%;width:30px;margin-top:-0.3%;height:24px;"></img>
					<span class="fl_le" style="padding-left:0.6%;">LyfeOn</span>
				</a>
			</div>
			<div class="fl_ri menu_drop">
				<ul>
					<li class="menu_drop_list fl_ri"><img class="" src="assets/images/info.png" alt="About" title="About"></img></a>
						<ul>
							<li><a href="about.html#help" target="_blank"><span class="">Help</span></a></li>
							<li><a href="about.html#terms" target="_blank"><span class="">Terms</span></a></li>
							<li><a href="about.html#contact" target="_blank"><span class="">Contact</span></a></li>
							<li class="last"><a href="https://plus.google.com/118335972259503633372/posts" target="_blank"><span class="">Google+</span></a></li>
							<li><a href="about.html#about" target="_blank"><span class="">About</span></a></li>
						</ul>
					</li>
					<li class="menu_drop_list last fl_ri"><a href=""><img class="" src="assets/images/settings.png" alt="Settings" title="Settings"></img></a>
						<ul>
							<li><a href=""><span class="">Account</span></a></li>
							<li class="last"><a href=""><span class="">Logout</span></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<li class="pin-box new_content_card standard_card always_first">
					<div>
						<div class="creator_box">
							<div class="creator_options">
								<ul>
									<li class="share_box_icon create_note">
										<img onclick="" class="fl_le" src="assets/images/note.png" title="Create Note"></img>
									</li>
									<li class="share_box_icon create_reminder">
										<img onclick="" class="fl_le" src="assets/images/clock.png" title="Create Reminder"></img>
									</li>
									<li class="share_box_icon create_expense">
										<img onclick="" class="" src="assets/images/expenses.png"  title="Record Expense"></img>
									</li>
									
									<!--
									<li class="share_box_icon create_location">
										<img onclick="" class="" src="assets/images/location.png" title="Record Location"></img>
									</li>
									<li class="share_box_icon create_message">
										<img onclick="" class="" src="assets/images/message.png"  title="Create Message"></img>
									</li>
									<li class="share_box_icon create_list">
										<img onclick="" class="" src="assets/images/list.png"  title="Create List"></img>
									</li>
									-->
									
								</ul>
							</div>
							<div id="note_creator" class="note_creator" contentEditable="true">Erase this and Create New ...</div>
							<button class="button fl_ri">Save</button>
							<div id="reminder_creator" class="reminder_creator">
								<form name="reminder_submit_form" action="" method="POST">
									<input type="text" name="reminder_title" class="fl_le reminder_title" maxlength="26" placeholder="Reminder Name">
									<input type="date" name="reminder_date" class="fl_le reminder_date" required>
									<input type="time" name="reminder_time" class="fl_le reminder_time" required>
									<input type="submit" class="button fl_ri" value="+">
								</form>
							</div>
							<div id="expense_creator" style="clear:both;" class="expense_creator">
								<form name="expense_submit_form" action="" method="POST">
									<input type="text" name="expense_title" placeholder="Name" class="fl_le expense_title" maxlength="30">
									<input type="number" name="expense_amount" placeholder="Amount" class="fl_le expense_amount" min="-999999" max="999999"  required>
									<input type="submit" class="button fl_ri" value="+">
								</form>
							</div>
							
							<!-- ************* ALTERNATE METHOD
							
								<div class="creator_box">
									<ul>
										<li class="share_box_icon create_note">
											<img onclick="" class="" src="assets/images/note.png"></img>
											<ul><li>
												<div id="note_creator" class="note_creator" contentEditable="true">Erase this and Create New ...</div>
											</li></ul>
										</li>
										<li class="share_box_icon create_reminder">
											<img onclick="" class="" src="assets/images/clock.png"></img>
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
											<img onclick="" class="" src="assets/images/expenses.png"></img>
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
				<li class="pin standard_card always_second reminders_list_card">
					<div>
						<div>
							<div>
								<p class="card_heading">
									<span class="card_heading_text">Reminders</span>
									<span class="intime_total fl_ri">2</span>
								</p>
								<ul class="reminders_list">
									<li class="list_single_reminder">
										<span class="single_reminder_name">Pay credit card bill</span>
										<span class="single_reminder_time fl_ri">Oct 29</span>
										<div>
											<ul class="note-options">
												<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
												<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
											</ul>
										</div>
									</li>
									<li  class="list_single_reminder">
										<span class="single_reminder_name">Meet Derek</span>
										<span class="single_reminder_time fl_ri">Oct 29</span>
										<div>
											<ul class="note-options">
												<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
												<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</li>
				<li class="pin standard_card always_third expenses_list_card">
					<div>
						<div>
							<div class="expenses_details">
								<p class="card_heading">
									<span class="card_heading_text">Expenses</span>
									<span class="intime_total fl_ri">180 900</span>
								</p>
								<ul class="time_filter_list">
									<li class="time_filter fl_le active">1w</li>
									<li class="time_filter fl_le">1m</li>
									<li class="time_filter fl_le">1q</li>
									<li class="time_filter fl_le">1y</li>
									<li class="time_filter fl_le">2y</li>
									<li class="time_filter fl_le">5y</li>
									<li class="time_filter fl_le">max</li>
								</ul>
								<ul class="expenses_list">
									<li>
										<p class="expenses_timeframe">
											<span class="expenses_timeframe_name">October</span>
											<span class="expenses_timeframe_total fl_ri">1031.36</span>
										</p>
										<ul>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
											<li class="single_expense">
												<span class="">Pizza</span>
												<span class="fl_ri">128.92</span>
												<div>
													<ul class="note-options">
														<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
														<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
													</ul>
												</div>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</li>
				<li class="pin single_note_card">
					<p>
						1Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Sed feugiat consectetur pellentesque. Nam ac elit risus, 
						ac blandit dui. Duis rutrum porta tortor ut convallis.
						Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/1/1swi3Qy.png" />
					<p>
						2Donec a fermentum nisi. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/6/6f3nXse.png" />
					<p>
						3Nullam eget lectus augue. Donec eu sem sit amet ligula 
						faucibus suscipit. Suspendisse rutrum turpis quis nunc 
						convallis quis aliquam mauris suscipit.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/8/8kEc1hS.png" />
					<p>
						4Nullam eget lectus augue. Donec eu sem sit amet ligula 
						faucibus suscipit. Suspendisse rutrum turpis quis nunc 
						convallis quis aliquam mauris suscipit.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/1/1swi3Qy.png" />
					<p>
						Donec a fermentum nisi. Integer dolor est, commodo ut 
						sagittis vitae, egestas at augue. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/6/6f3nXse.png" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Sed feugiat consectetur pellentesque. Nam ac elit risus, 
						ac blandit dui. Duis rutrum porta tortor ut convallis.
						Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>	
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/2/2v3VhAp.png" />
					<p>
						Nullam eget lectus augue. Donec eu sem sit amet ligula 
						faucibus suscipit. Suspendisse rutrum turpis quis nunc 
						convallis quis aliquam mauris suscipit.
						Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/1/1swi3Qy.png" />
					<p>
						Nullam eget lectus augue. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/8/8kEc1hS.png" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Sed feugiat consectetur pellentesque. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/2/2v3VhAp.png" />
					<p>
						Donec a fermentum nisi. Integer dolor est, commodo ut 
						sagittis vitae, egestas at augue. Suspendisse id nulla 
						ac urna vestibulum mattis. Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/1/1swi3Qy.png" />
					<p>
						Donec a fermentum nisi. Integer dolor est, commodo ut 
						sagittis vitae, egestas at augue. Suspendisse id nulla 
						ac urna vestibulum mattis. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/6/6f3nXse.png" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Sed feugiat consectetur pellentesque. Nam ac elit risus, 
						ac blandit dui. Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>	
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/2/2v3VhAp.png" />
					<p>
						Donec a fermentum nisi. Integer dolor est, commodo ut 
						sagittis vitae, egestas at augue. Suspendisse id nulla 
						ac urna vestibulum mattis. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/1/1swi3Qy.png" />
					<p>
						Donec a fermentum nisi. Integer dolor est, commodo ut 
						sagittis vitae, egestas at augue. Suspendisse id nulla 
						ac urna vestibulum mattis. 
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
				<li class="pin single_note_card">
					<img src="http://cssdeck.com/uploads/media/items/6/6f3nXse.png" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						Sed feugiat consectetur pellentesque. Nam ac elit risus, 
						ac blandit dui. Duis rutrum porta tortor ut convallis.
					</p>
					<ul class="note-options">
						<li class="note-options-single fl_le"><img class="" src="assets/images/delete.png" alt="Delete" title="Delete"></img></li>
						<li class="note-options-single fl_le"><img class="" src="assets/images/edit.png" alt="Edit" title="Edit"></img></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</body>