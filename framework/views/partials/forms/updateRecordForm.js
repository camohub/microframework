$(function() {

	var createRecordForm = $('#updateRecordForm');

	if(type == 'mx' || type == 'srv')
	{
		var selector = '.' + type + '-js';
		createRecordForm.find(selector).slideDown();
	}

	if(type == 'srv')
	{
		var selector = '.' + type + '-js';
		createRecordForm.find(selector).slideDown();
	}

});