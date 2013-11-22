<?php 

include_once 'head.php'; 
?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				
				<?php include_once 'cards/expenses_list_card.php'; ?>
				
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>