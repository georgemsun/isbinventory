$(document).ready(function() {
	// reseting php inputs in url
	if(window.location.href.toLowerCase().indexOf("add-name") > -1 || window.location.href.toLowerCase().indexOf("select-name") > -1) {
		window.location.href = "http://db.systemsbiology.net/MoritzInventory/";
	}
	// width of search bar and height of table
	var search_bar_width = $('.header').width() - 180 - 10;
	$('#search-name').css('width',search_bar_width);
	$('#search-space').css('width', 10);
	$(window).resize(function() {
		var search_bar_width = $('.header').width() - 180 - 10;
		$('#search-name').css('width',search_bar_width);
		$('#search-space').css('width', 10);
	});
	// highlighting/selecting rows
	$('tr:not(.table-head)').click(function() {
		if($(this).hasClass('row-selected')) {
			$('tr').removeClass('row-selected');
			//have you select chemical on edit
			$('#select-name').show();
			$('#select-name-different').hide();
			$('#select-name').val('');
		}
		else {
			$('tr').removeClass('row-selected');
			$(this).addClass('row-selected');
			//autofill chemical name on edit
			$('#edit-name').val($(this).children("#name").html());
			$('#edit-location').val($(this).children("#location").html());
			$('#edit-size').val($(this).children("#size").html());
			$('#edit-notes').val($(this).children("#notes").html());
			$('#edit-phy').val($(this).children("#phy").html());
			$('#edit-type').val($(this).children("#type").html());
			$('#edit-cas').val($(this).children("#cas").html());
			
			$("#select-name option[id='" + $(this).attr('id') + "']").attr("selected", "selected");
			$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').fadeIn('medium');
			$('#select-name, #select-name-search').hide();
			$('#select-name-different').show();
		}
	});
	// filter table by search
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
	// set tab for csv or tsv
	var tab = "	";
	// opening the add/edit popup
	$('#search-add-edit').click(function() {
		$('.fade').fadeIn('fast');
		$('.add-chemical').fadeIn('fast');
	});
	// clearing errors or fields
	function clearErrors() {
		$('.add-chemical #error, .add-chemical #error-plus, .edit-chemical #error, .edit-chemical #error-add, .edit-chemical #error-plus').css("display", "none");
	};
	function clearAdd() {
		$('#add-name, #add-location, #add-notes, #add-phy, #add-type, #add-size, #add-cas').val('');
	}
	function clearEdit() {
		$('#select-name, #edit-name, #edit-location, #edit-notes, #edit-phy, #edit-type, #edit-size, #edit-cas').val('');
	}
	function clearSelect() {
		$('#select-name-search').val(''); selected = 0;
		$('#select-name, #select-name-search').show();
		$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas, #select-name-different').hide();
	}
	// closing the popup
	function closeWindow() {
		$('.fade').fadeOut('fast');
		$('.add-chemical').fadeOut('fast');
		$('.edit-chemical').fadeOut('fast');
		clearAdd(); clearEdit(); clearSelect(); clearErrors();
	};
	$('.fade').click(function() {
		closeWindow();
	});
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			closeWindow();
			$('#search-name').val('');
			$.each($('#table tbody').find('tr'), function() {
					$(this).show();
			});
		};
	});
	// switch between adding and editing
	$('.add-chemical h3').click(function() {
		clearErrors();
		$('.add-chemical').fadeOut('fast');
		$('.edit-chemical').fadeIn('fast');
	});
	$('.edit-chemical h3').click(function() {
		clearErrors();
		$('.edit-chemical').fadeOut('fast');
		$('.add-chemical').fadeIn('fast');
	});
	// clicking submit
	$('#add-chemical-submit').click(function() {
		if($('#add-name').val() == "" || $('#add-location').val() == "") {
			clearErrors();
			$('.add-chemical #error').css("display", "block");
		}
		else if($('#add-name').val().indexOf('#') >=0 || $('#add-name').val().indexOf('&') >=0 || $('#add-name').val().indexOf('+') >=0 || $('#add-location').val().indexOf('#') >=0 || $('#add-location').val().indexOf('&') >=0 || $('#add-location').val().indexOf('+') >=0 || $('#add-notes').val().indexOf('#') >=0 || $('#add-notes').val().indexOf('&') >=0 || $('#add-notes').val().indexOf('+') >=0 || $('#add-size').val().indexOf('#') >=0 || $('#add-size').val().indexOf('&') >=0 || $('#add-size').val().indexOf('+') >=0 || $('#add-cas').val().indexOf('#') >=0 || $('#add-cas').val().indexOf('&') >=0 || $('#add-cas').val().indexOf('+') >=0) {
			clearErrors();
			$('.add-chemical #error-plus').css("display", "block");
		}
		else {
			window.location.href = "http://db.systemsbiology.net/MoritzInventory/?add-name=" + ($('#add-name').val()) + "&add-location=" + ($('#add-location').val()) + "&add-notes=" + ($('#add-notes').val()) + "&add-phy=" + $('#add-phy').val() + "&add-type=" + $('#add-type').val() + "&add-size=" + ($('#add-size').val()) + "&add-cas=" + ($('#add-cas').val());
		}
	});
	$('#edit-chemical-submit').click(function() {
		if($('#select-name').val() == "") {
			clearErrors();
			$('.edit-chemical #error').css("display", "block");
		}
		else if($('#edit-name').val() == "" || $('#edit-location').val() == "") {
			clearErrors();
			$('.edit-chemical #error-add').css("display", "block");
		}
		else if($('#edit-name').val().indexOf('#') >=0 || $('#edit-name').val().indexOf('&') >=0 || $('#edit-name').val().indexOf('+') >=0 || $('#edit-location').val().indexOf('#') >=0 || $('#edit-location').val().indexOf('&') >=0 || $('#edit-location').val().indexOf('+') >=0 || $('#edit-notes').val().indexOf('#') >=0 || $('#edit-notes').val().indexOf('&') >=0 || $('#edit-notes').val().indexOf('+') >=0 || $('#edit-size').val().indexOf('#') >=0 || $('#edit-size').val().indexOf('&') >=0 || $('#edit-size').val().indexOf('+') >=0 || $('#edit-cas').val().indexOf('#') >=0 || $('#edit-cas').val().indexOf('&') >=0 || $('#edit-cas').val().indexOf('+') >=0) {
			clearErrors();
			$('.edit-chemical #error-plus').css("display", "block");
		}
		else {
			window.location.href = "http://db.systemsbiology.net/MoritzInventory/?add-name=" + ($('#edit-name').val()) + "&add-location=" + ($('#edit-location').val()) + "&add-notes=" + ($('#edit-notes').val()) + "&add-phy=" + $('#edit-phy').val() + "&add-type=" + $('#edit-type').val() + "&add-size=" + ($('#edit-size').val()) + "&add-cas=" + ($('#edit-cas').val()) + "&select-name=" + ($('#select-name').val());
		}
	});
	$('#delete-chemical-submit').click(function() {
		if($('#select-name').val() == "") {
			clearErrors();
			$('.edit-chemical #error').css("display", "block");
		}
		else {
			window.location.href = "http://db.systemsbiology.net/MoritzInventory/?select-name=" + ($('#select-name').val());
		}
	});
	// selecting an item to edit/delete
	$('#select-name, #select-name-search').show();
	$('#select-name-different').hide();
	$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').hide();
	var selected = 0;
	$('#select-name').change(function () {
		if(selected == 0) {
			selected = 1;
			$('#edit-name, #edit-location, #edit-size, #edit-notes, #edit-phy, #edit-type, #edit-cas').fadeIn('medium');
		}
		$('#select-name, #select-name-search').hide();
		$('#select-name-different').show();
		
		var select_name = $('#select-name').val();
		var select_name_tab = "...";
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
});
