<?php require_once(__DIR__ . '/../header.php'); ?>

<?php

	$formErrors = $sessionService->getAndForget(DnsRecordValidator::SESS_ERRORS_KEY);
	$post = $sessionService->getAndForget(DnsRecordValidator::SESS_POST_KEY);

?>


<div class="container">
	<div class="row pb-25">
		<h2 class="col-12">DNS záznamy - <?php echo $domain ?></h2>
		<h3 class="col-12">Vytvoriť nový záznam</h3>
	</div>

	<div class="row">
		<div class="col-12">
			<?php include(__DIR__ . '/../partials/forms/createRecordForm.php') ?>
		</div>
	</div>
</div>


<?php require_once(__DIR__ . '/../footer.php'); ?>