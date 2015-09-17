<html>
	<head>
		<title>Chemical Inventory | Moritz Lab</title>
		
		<link rel="stylesheet" type="text/css" href="main.css">
		<script type="text/javascript" src="jquery.min.js"></script>
		<script src="sorttable.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
			
		<?php
			$tab = "	";
			$filename = "tsv.txt";
			$file = fopen($filename, 'r') or die("Unable to open inventory file. If this message appears after reloading, try locating '" . $filename . "'");
			
			if($_GET["add-name"] != "") {
				$file = fopen($filename, 'r+') or die("Unable to open inventory file! If this message appears after reloading, try locating '" . $filename . "'");
				
				file_put_contents($filename, "\n" . $_GET["add-name"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-location"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-size"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-notes"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-phy"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-type"] . $tab, FILE_APPEND);
				file_put_contents($filename, $_GET["add-cas"], FILE_APPEND);
			}
			
			$select_name_tab = "———";
			if($_GET["select-name"] != "") {
				// read into array
				$arr = file($filename);
				// remove line containing matching text
				$search = str_replace($select_name_tab, $tab, $_GET["select-name"]);
				$line_number = false;
				while(list($key, $line) = each($arr) and !$line_number) {
				   $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
				}
				unset($arr[$line_number - 1]);
				// reindex array
				$arr = array_values($arr);
				// write back to file
				file_put_contents($filename,implode($arr));
			}
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				<!--row-selected-->
				$('tr:not(.table-head)').click(function() {
					if($(this).hasClass('row-selected')) {
						$('tr').removeClass('row-selected');
						//have you select chemical on edit
					//	$('#select-name').show();
					//	$('#select-name-different').hide();
					//	$('#select-name').val('');
					}
					else {
						$('tr').removeClass('row-selected');
						$(this).addClass('row-selected');
						//autofill chemical name on edit
					//	$('#edit-name').val($(this).children("#name").html());
					//	$('#edit-location').val($(this).children("#location").html());
					//	$('#edit-size').val($(this).children("#size").html());
					//	$('#edit-notes').val($(this).children("#notes").html());
					//	$('#edit-phy').val($(this).children("#phy").html());
					//	$('#edit-type').val($(this).children("#type").html());
					//	$('#edit-cas').val($(this).children("#cas").html());
					//	
					//	var select_name_tab = "———";
					//	var highlighted_name = $('#edit-name').val() + select_name_tab + $('#edit-location').val() + select_name_tab + $('#edit-size').val() + select_name_tab + $('#edit-notes').val() + select_name_tab + $('#edit-phy').val() + select_name_tab + $('#edit-type').val() + select_name_tab + $('#edit-cas').val();
					//	$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').fadeIn('medium');
					//	$('#select-name').hide();
					//	$('#select-name-different').show();
					}
				});
				<!--search-->
				$('#search-name').keyup(function() {
					_this = this;
					$.each($('#table tbody').find('tr'), function() {
						console.log($(this).text());
						if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
							$(this).hide();
						else {
							$(this).show();
						}
					});
				});
				<!--set tab for csv or tsv-->
				var tab = "	";
				<!--open or close window-->
				$('.fade').hide();
				$('.add-chemical').hide();
				$('.edit-chemical').hide();
				$('#search-add-edit').click(function() {
					$('.fade').fadeIn('fast');
					$('.add-chemical').fadeIn('fast');
				});
				function closeWindow() {
					$('.fade').fadeOut('fast');
					$('.add-chemical').fadeOut('fast');
					$('.add-chemical #error').css("display", "none");
					$('#add-name, #add-location, #add-notes, #add-phy, #add-type, #add-size, #add-cas').val('');
					$('.edit-chemical').fadeOut('fast');
					$('.edit-chemical #error').css("display", "none");
					$('#select-name, #edit-name, #edit-location, #edit-notes, #edit-phy, #edit-type, #edit-size, #edit-cas').val('');
					//resets edit select
					$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas, #select-name-different').hide();
					$('#select-name, #select-name-search').show();
					$('#select-name-search').val('');
					selected = 0;
				};
				$('.fade').click(function() {
					closeWindow();
				});
				$(document).keyup(function(e) {
					if (e.keyCode == 27) {
						closeWindow();
						$('#search-name').val('');
						//this runs the search on the blank value
						_this = this;
						$.each($('#table tbody').find('tr'), function() {
							console.log($(this).text());
							if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
								$(this).hide();
							else
								$(this).show();
						});
					};
				});
				<!--switch between add and edit-->
				$('.add-chemical h3').click(function() {
					$('.add-chemical').fadeOut('fast');
					$('.edit-chemical #error').css("display", "none");
					$('.edit-chemical').fadeIn('fast');
				});
				$('.edit-chemical h3').click(function() {
					$('.edit-chemical').fadeOut('fast');
					$('.add-chemical #error').css("display", "none");
					$('.add-chemical').fadeIn('fast');
				});
				<!--effects of clicking submit-->
				$('.add-chemical #error-plus').css("display", "block");
				$('.edit-chemical #error-plus').css("display", "block");
				$('#add-chemical-submit').click(function() {
					if($('#add-name').val() == "" || $('#add-location').val() == "") {
						$('.add-chemical #error').css("display", "block");
					}
					else {
						window.location.href = "http://db.systemsbiology.net/MoritzInventory/?add-name=" + $('#add-name').val() + "&add-location=" + $('#add-location').val() + "&add-notes=" + $('#add-notes').val() + "&add-phy=" + $('#add-phy').val() + "&add-type=" + $('#add-type').val() + "&add-size=" + $('#add-size').val() + "&add-cas=" + $('#add-cas').val();
						
						$('.fade').fadeOut('fast');
						$('.add-chemical').fadeOut('fast');
						$('.add-chemical #error').css("display", "none");
						$('#add-name, #add-location, #add-notes, #add-phy, #add-type, #add-size, #add-cas').val('');
					}
				});
				$('#edit-chemical-submit').click(function() {
					if($('#select-name').val() == "") {
						$('.edit-chemical #error').css("display", "block");
					}
					else if($('#edit-name').val() == "" || $('#edit-location').val() == "") {
						$('.edit-chemical #error-add').css("display", "block");
					}
					else {
						window.location.href = "http://db.systemsbiology.net/MoritzInventory/?add-name=" + $('#edit-name').val() + "&add-location=" + $('#edit-location').val() + "&add-notes=" + $('#edit-notes').val() + "&add-phy=" + $('#edit-phy').val() + "&add-type=" + $('#edit-type').val() + "&add-size=" + $('#edit-size').val() + "&add-cas=" + $('#edit-cas').val() + "&select-name=" + $('#select-name').val();
						
						$('.fade').fadeOut('fast');
						$('.edit-chemical').fadeOut('fast');
						$('.edit-chemical #error').css("display", "none");
						$('#select-name, #edit-name, #edit-location, #edit-notes, #edit-phy, #edit-type, #edit-size, #edit-cas').val('');
					}
				});
				$('#delete-chemical-submit').click(function() {
					if($('#select-name').val() == "") {
						$('.edit-chemical #error').css("display", "block");
					}
					else {
						window.location.href = "http://db.systemsbiology.net/MoritzInventory/?select-name=" + $('#select-name').val();
						
						$('.fade').fadeOut('fast');
						$('.edit-chemical').fadeOut('fast');
						$('.edit-chemical #error').css("display", "none");
						$('#select-name, #edit-name, #edit-location, #edit-notes, #edit-phy, #edit-type, #edit-size, #edit-cas').val('');
					}
				});
				
				var selected = 0;
				$('#select-name').change(function () {
					if(selected == 0) {
						selected = 1;
						$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').fadeIn('medium');
					}
					$('#select-name, #select-name-search').hide();
					$('#select-name-different').show();
					
					var select_name = $('#select-name').val();
					var select_name_tab = "———";
					$('#edit-name').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					$('#edit-location').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					$('#edit-size').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					$('#edit-notes').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					$('#edit-phy').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					$('#edit-type').val(select_name.substring(0, select_name.indexOf(select_name_tab)));
					select_name = select_name.substring(select_name.indexOf(select_name_tab) + select_name_tab.length, select_name.length);
					if(select_name.indexOf(select_name_tab) < 0) { //because some entries have tab at the end
						$('#edit-cas').val(select_name.substring(0, select_name.length));
					}
					else {
						$('#edit-cas').val(select_name.indexOf(select_name_tab));
					}
				});
				$('#select-name-different').click(function() {
					selected = 0;
					$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').fadeOut('medium');
					$('#select-name, #select-name-search').show();
					$('#select-name').val('');
					$('#select-name-different').hide();
				});
				$('#select-name-search').keyup(function() {
					_this = this;
					$.each($('#select-name').find('option'), function() {
						console.log($(this).text());
						if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
							$(this).hide();
						else {
							$(this).show();
						}
					});
				});	
				<!--shitty solution-->
				if(window.location.href.toLowerCase().indexOf("add-name") > -1) {
					window.location.href = "http://db.systemsbiology.net/MoritzInventory/";
				}
				if(window.location.href.toLowerCase().indexOf("select-name") > -1) {
					window.location.href = "http://db.systemsbiology.net/MoritzInventory/";
				}
				closeWindow();
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
	
		<div class="tagline"></div>
		
		<div class="fade"></div>
		
		<div class="add-chemical-container">
			<div class="add-chemical">
				<form>
					<h3>Add Chemical<span style="color: #CCCCCC"> / Edit Chemical</span></h3>
					<input type="text" id="add-name" name="add-name" placeholder="Name">
					<input type="text" id="add-location" name="add-location" placeholder="Location">
					<input type="text" id="add-notes" name="add-notes" placeholder="Notes">
					<select id="add-phy" name="add-phy">
						<option value="" disabled selected>Physical State</option>
						<option value="S">Solid</option>
						<option value="L">Liquid</option>
					</select>
					<select type="text" id="add-type" name="add-type">
						<option value="" disabled selected>Bottle Type</option>
						<option value="P">Plastic</option>
						<option value="G">Glass</option>
					</select>
					<input type="text" id= "add-size" name="add-size" placeholder="Size">
					<input type="text" id= "add-cas" name="add-cas" placeholder="CAS">
					</br>
					
					<input type="button" id="add-chemical-submit" value="Add Chemical"></input>
					<p id="error">Please include at least a name and a location.</p>
					<p id="error-plus">The following characters may not process correctly: !, @, #, $, %, ^, &, *, +</p>
				</form>
			</div>
			<div class="edit-chemical">
				<form>
					<h3>Edit Chemical<span style="color: #CCCCCC"> / Add Chemical</span></h3>
					<button type="button" id="select-name-different" style="text-align: left; border: none; font-style: italic;">Click here to select a different chemical</button>
					<input type="text" id="select-name-search" placeholder="Type here to filter menu below">
					<select id="select-name"  name="select-name">
						<option value="" disabled selected>Select</option>
						<?php
							$file = fopen($filename, 'r') or die("Unable to open inventory file! If this message appears after reloading, try locating '" . $filename . "'");
							while (($line = fgets($file)) !== false) {
								if($line != "\n") {
									$line = str_replace($tab, $select_name_tab, $line);
									$name = substr($line, 0, strlen($line)); /* strpos($line, $tab) strlen($line) */
									echo "<option value=\"" . $name . "\">" . $name . "</option>";
								}
							}
						?>
					</select>
					<input type="text" id= "edit-name" name="edit-name" placeholder="Name" value="<?php echo $select_name; ?>">
					<input type="text" id= "edit-location" name="edit-location" placeholder="Location" value="<?php echo $edit_location; ?>">
					<input type="text" id= "edit-notes" name="edit-notes" placeholder="Notes" value="<?php echo $edit_notes; ?>">
					<select id="edit-phy" name="edit-phy" value="<?php echo $edit_phy; ?>">
						<option value="" disabled selected>Physical State</option>
						<option value="" <?=$edit_phy == "" ? ' selected="selected"' : '';?>></option>
						<option value="S" <?=$edit_phy == "S" ? ' selected="selected"' : '';?>>Solid</option>
						<option value="L" <?=$edit_phy == "L" ? ' selected="selected"' : '';?>>Liquid</option>
					</select>
					<select id="edit-type" name="edit-type"  value="<?php echo $edit_type; ?>">
						<option value="" disabled selected>Bottle Type</option>
						<option value="" <?=$edit_type == "" ? ' selected="selected"' : '';?>></option>
						<option value="P" <?=$edit_type == "P" ? ' selected="selected"' : '';?>>Plastic</option>
						<option value="G" <?=$edit_type == "G" ? ' selected="selected"' : '';?>>Glass</option>
					</select>
					<input type="text" id= "edit-size" name="edit-size" placeholder="Size"  value="<?php echo $edit_size; ?>">
					<input type="text" id= "edit-cas" name="edit-cas" placeholder="CAS"  value="<?php echo $edit_cas; ?>">
					</br>
					
					<input type="button" id="edit-chemical-submit" value="Edit Chemical"></input>
					<div class="delete-chemical-submit">
						<input type="button" id="delete-chemical-submit" value="Delete Chemical"></input>
					</div>
					<p id="error">Please select a chemical to edit or delete.</p>
					<p id="error-add">Please include at least a name and a location.</p>
					<p id="error-plus">The following characters may not process correctly: !, @, #, $, %, ^, &, *, +</p>
				</form>
			</div>
		</div>
		
		<div class="container">
			<div class="header">
				<h1>Moritz Lab &ndash; Chemical Inventory</h1>
				<input type="text" data-table="order-table" id="search-name" placeholder="Type here to search">
				<button type="button" id="search-add-edit">Add/Edit Chemical</button>
			</div>
			
			<div class="table">
				<table id="table" class="sortable">
					<thead>
						<tr class="table-head">
							<th><a href="#" bubbletooltip="Click to sort rows by Name">Name</a></th>
							<th><a href="#" bubbletooltip="Click to sort rows by Location">Location</a></th>
							<th><a href="#" bubbletooltip="Click to sort rows by Size">Size</a></th>
							<th><a href="#" bubbletooltip="Click to sort rows by Notes">Notes</a></th>
							<th><a href="#" bubbletooltip="Click to sort rows by Physical State">Physical</br>State</a></th>
							<th><a href="#" bubbletooltip="Click to sort rows by Bottle Type">Bottle</br>Type</a></th>
							<th>CAS</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$file = fopen($filename, 'r') or die("Unable to open inventory file! If this message appears after reloading, try locating '" . $filename . "'");
							while (($line = fgets($file)) !== false) {
								if($line != "\n") {
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
								}
							//fclose($file);
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
