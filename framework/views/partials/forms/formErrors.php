<?php

if( !empty($formErrors) )
{
	echo '<div class="alert alert-danger mb-15">';
	foreach ($validator->errors as $error) echo '<div>' . $error . '</div>';
	echo '</div>';
}

?>