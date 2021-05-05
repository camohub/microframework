<?php require_once(__DIR__ . '/../header.php'); ?>


<div class="container">
	<div class="row pb-25">
		<h2 class="col-12">Upraviť DNS záznam - <?php echo $domain ?></h2>
	</div>

	<?php dump($response) ?>

	<?php if( $response->code > 299 ): ?>
		<div class="row">
			<div class="col text-danger">
				Pri spracovaní requestu došlo k chybe.
			</div>
		</div>
	<?php elseif( $response !== FALSE && !empty($response->items) ): ?>
	<?php else: ?>
		<div class="row">
			<div class="col">Nenašli sa žiadne záznamy.</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col">
			<?php dump($response) ?>
		</div>
	</div>
</div>


<?php require_once(__DIR__ . '/../footer.php'); ?>