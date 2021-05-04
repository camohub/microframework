<?php require_once(__DIR__ . '/../header.php'); ?>


<div class="container">
	<div class="row pb-25">
		<h1 class="col-12">Zóny</h1>
	</div>

	<?php if( $response->code > 299 ): ?>
		<div class="row">
			<div class="col text-danger">
				Pri spracovaní requestu došlo k chybe.
			</div>
		</div>
	<?php elseif( $response !== FALSE && !empty($response->items) ): ?>
		<table class="table table-bordered table-hover table-striped table-responsive">
			<thead class="thead-dark">
				<tr>
					<td class="">#</td>
					<td class="col-9">Name</td>
					<td class="col-9">Action</td>
				</tr>
			</thead>

			<?php foreach ($response->items as $zone): ?>
				<tr>
					<td><?php echo $zone->id ?></td>
					<td style="white-space: pre"><?php echo $zone->name ?></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
		</table>
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