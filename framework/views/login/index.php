<?php require_once(__DIR__ . '/../header.php'); ?>


<div class="container">
	<div class="row">
		<h2 class="col-12 offset-md-3 col-md-6 pt-50 pb-50">Prihlásenie</h2>
	</div>
	<div class="row">
		<form action="<?php echo $basePath ?>/login/submit" method="post" class="col-12 offset-md-3 col-md-6">
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
	</div>
</div>


<?php require_once(__DIR__ . '/../footer.php'); ?>