jQuery(function($){
	
    // data table
	$('#data-table').DataTable();
	$('#data-table2').DataTable();
    // data table 2 
	$('a[href="#tab2"]').one('shown.bs.tab', function (e) {
		$('#data-table2').DataTable();
	  	e.preventDefault();
	});
	// generate a slug when the user types a title in
	pyro.generate_slug('input[name="title"]', 'input[name="slug"]');
});