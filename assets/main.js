$(function() {

	$('.alert').on('click', function( e )
	{
		$(this).hide();
	});


	$('.delete').on('click', function( e )
	{
		if( ! confirm('Potvrďte zmazanie záznamu.') )
		{
			e.preventDefault();
			return false;
		}
	});

	$('.help').on('click', function( e )
	{
		console.log($(this).next('.help-content'));
		$(this).next('.help-content').slideToggle();
	})
});