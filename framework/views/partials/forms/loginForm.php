<?php
	$formErrors = $validator->errors ?? NULL;
?>

<form action="<?php echo $basePath ?>/login/submit" method="post" class="col-12 offset-md-3 col-md-6">

	<?php include(__DIR__ . '/formErrors.php') ?>

<div class="form-group">
	<label for="name">Meno</label>
	<input type="text" name="name" class="form-control">
</div>
<div class="form-group pb-25">
	<label for="password">Heslo</label>
	<input type="password" name="password" class="form-control">
</div>
<input type="submit" value="Odoslať" class="btn btn-primary">
</form>