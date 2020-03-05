$(document).ready(function() {
	//Add datatable to all tables allowing paging and search
	
	$('#userTable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 }
		]
	});
	
	$('#adminTable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 3 }
		]
	});
	
	$('#contactTable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 }
		]
	});
	
	/*
	* FAQ related tables
	*/
	$('#faqtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 }
		]
	});

	$('#faqquestable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 }
		]
	});
	
	/*
	* Forum related tables
	*/
	$('#dbCattable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 }
		]
	});
	
	$('#dbtopictable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 }
		]
	});
	
	/*
	* Group support related tables
	*/
	$('#applytable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 }
		]
	});
	
	$('#grouptable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 }
		]
	});
	
	$('#groupmemtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 1 }
		]
	});
	
	/*
	* Blog related tables
	*/
	$('#submitblogtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 4 },
			{ "orderable": false, "targets": 5 }
		]
	});
	
	$('#postblogcattable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 }
		]
	});
	
	$('#postblogtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 }
		]
	});
	
	/*
	* Report related tables
	*/
	$('#repBlogtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 },
			{ "orderable": false, "targets": 7 }
		]
	});
	
	$('#repGStable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 },
			{ "orderable": false, "targets": 7 }
		]
	});
	
	$('#repDBtable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 },
			{ "orderable": false, "targets": 7 }
		]
	});
	
	$('#repChattable').DataTable({
		 "columnDefs": [
			{ "orderable": false, "targets": 5 },
			{ "orderable": false, "targets": 6 }
		]
	});
});