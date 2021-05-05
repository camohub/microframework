$(function() {

	var createRecordForm = $('#createRecordForm');
	var createRecordFormType = createRecordForm.find('#typeId')
	var createRecordFormSpecialInputs = createRecordForm.find('.specialInput');

	createRecordFormType.on('change', function( e )
	{
		createRecordFormSpecialInputs.slideUp();
		var type = $(this).val().toLowerCase();

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

});