$(function() {

	var createRecordForm = $('#updateRecordForm');
	var createRecordFormSpecialInputs = createRecordForm.find('.specialInput');


	createRecordFormSpecialInputs.slideUp();

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