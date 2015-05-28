<html>
	<head>
		<title>Chemical Inventory | Moritz Lab</title>
		
		<link rel="stylesheet" href="main.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
		
		<script type="text/javascript">
			$(document).ready(function() {
				<!--row-selected-->
				$('tr:not(.table-head)').click(function() {
					$('tr').removeClass('row-selected');
					$(this).addClass('row-selected');
				});
				<!--search-->
				$('#search-name').keyup(function() {
					_this = this;
					$.each($('#table tbody').find('tr'), function() {
						console.log($(this).text());
						if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
							$(this).hide();
						else
							$(this).show();
					});
				});
				
				$('.fade').hide();
				$('.add-chemical').hide();
				$('.edit-chemical').hide();
				$('#search-add-edit').click(function() {
					$('.fade').fadeIn('fast');
					$('.add-chemical').fadeIn('fast');
				});
				$('.add-chemical h3').click(function() {
					$('.add-chemical').fadeOut('fast');
					$('.edit-chemical').fadeIn('fast');
				});
				$('.edit-chemical h3').click(function() {
					$('.edit-chemical').fadeOut('fast');
					$('.add-chemical').fadeIn('fast');
				});
				$('.fade, #add-chemical-submit, #edit-chemical-submit, #delete-chemical-submit').click(function() {
					$('.fade').fadeOut('fast');
					$('.add-chemical').fadeOut('fast');
					$('.edit-chemical').fadeOut('fast');
				});
				$('#add-chemical-submit').click(function() {
					//Code
					$('.troubleshooting').html("ADD WAS SELECTED");
				});
				$('#edit-chemical-submit').click(function() {
					//Code
					$('.troubleshooting').html("EDIT WAS SELECTED");
				});
				$('#delete-chemical-submit').click(function() {
					//Code
					$('.troubleshooting').html("DELETE WAS SELECTED");
				});
			});
		</script>
		
		<!--TAB LOGO-->
		<link rel="apple-touch-icon" sizes="57x57" href="icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="icons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="icons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="icons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="icons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="icons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="icons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="icons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="icons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="icons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="icons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">
		<link rel="manifest" href="icons/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="icons/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body>
		<!--<span class="troubleshooting">IGNORE FOR NOW</span>-->
		
		<div class="tagline"></div>
		
		<div class="fade"></div>
		
		<div class="add-chemical-container">
			<div class="add-chemical">
				<h3>Add Chemical<span style="color: #CCCCCC"> / Edit Chemical</span></h3>
				<input type="text" id= "add-name" placeholder="Name">
				<input type="text" id= "add-location" placeholder="Location">
				<input type="text" id= "add-notes" placeholder="Notes">
				<select id="add-phy">
					<option value="" disabled selected>Physical State</option>
					<option value="S">Solid</option>
					<option value="L">Liquid</option>
				</select>
				<select id="add-type">
					<option value="" disabled selected>Bottle Type</option>
					<option value="P">Plastic</option>
					<option value="G">Glass</option>
				</select>
				<input type="text" id= "add-size" placeholder="Size">
				<input type="text" id= "add-cas" placeholder="CAS">
				</br>
				
				<button type="button" id="add-chemical-submit">Add Chemical</button>
			</div>
			<div class="edit-chemical">
				<h3>Edit Chemical<span style="color: #CCCCCC"> / Add Chemical</span></h3>
				<select id= "add-name">
					<option value="" disabled selected>Name</option>
				</select>
				<input type="text" id= "add-location" placeholder="Location">
				<input type="text" id= "add-notes" placeholder="Notes">
				<select id="add-phy">
					<option value="" disabled selected>Physical State</option>
					<option value="S">Solid</option>
					<option value="L">Liquid</option>
				</select>
				<select id="add-type">
					<option value="" disabled selected>Bottle Type</option>
					<option value="P">Plastic</option>
					<option value="G">Glass</option>
				</select>
				<input type="text" id= "add-size" placeholder="Size">
				<input type="text" id= "add-cas" placeholder="CAS">
				</br>
				
				<button type="button" id="edit-chemical-submit">Edit Chemical</button>
				<div class="delete-chemical-submit">
					<button type="button" id="delete-chemical-submit">Delete Chemical</button>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="header">
				<h1>Moritz Lab &ndash; Chemical Inventory</h1>
				<input type="text" data-table="order-table" id="search-name" placeholder="Name">
				<!--<input type="text" data-table="order-table" id="search-cas" placeholder="CAS">
				<input type="text" data-table="order-table" id="search-location" placeholder="Location">-->
				<button type="button" id="search-add-edit">Add/Edit Chemical</button>
			</div>
			
			<?php
				$filename = "tsv.txt";
				$file = fopen($filename, "r") or die("Unable to open inventory file! If this message appears after reloading, try locating '" . $filename . "'");
			?>
			
			<div class="table">
				<table id="table">
					<thead>
						<tr class="table-head">
							<th>Name</th>
							<th>Location</th>
							<th>Size</th> 
							<th>Notes</th>
							<th>Physical</br>State</th>
							<th>Bottle</br>Type</th>
							<th>CAS</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tab = "	";
							while (($line = fgets($file)) !== false) {
								echo "<tr>";
									echo "<td id=\"name\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"location\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"size\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"notes\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"phy\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"type\">" . substr($line, 0, strpos($line, $tab)) . "</td>";
									$line = substr($line, strpos($line, $tab)+1);
									echo "<td id=\"cas\">" . $line . "</td>";
								echo "</tr>";
							//fclose($file);
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
