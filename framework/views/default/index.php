<?php require_once(__DIR__ . '/../header.php'); ?>


<div class="container">
	<div class="row pb-25">
		<h2 class="col-12">DNS záznamy</h2>
	</div>

	<div class="row">
		<div class="col">
			<div class="mb-15"><b>Vyberte doménu</b></div>

			<?php include( __DIR__ . '/../partials/forms/formErrors.php' ) ?>

			<?php foreach ($domains as $d): ?>
				<div>
					<a href="<?php echo $basePath ?>/default/show-records?domain=<?php echo $d; ?>"><?php echo $d ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>


<?php require_once(__DIR__ . '/../footer.php'); ?>