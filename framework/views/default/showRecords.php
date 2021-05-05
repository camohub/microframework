<?php require_once(__DIR__ . '/../header.php'); ?>


<div class="container">
	<div class="row pb-25">
		<h2 class="col-12">
			DNS záznamy - <?php echo $domain ?>
			<a href="<?php echo "$basePath/default/create-record?domain=$domain" ?>" class="btn btn-primary float-right">Nový záznam</a>
		</h2>
	</div>

	<?php if( $response->code > 299 ): ?>
		<div class="row">
			<div class="col text-danger">
				Pri spracovaní requestu došlo k chybe.
			</div>
		</div>
	<?php elseif( $response !== FALSE && !empty($response->items) ): ?>

		<?php
			$keys = [];

			foreach ($response->items as $i)
			{
				foreach ((array)$i as $key => $val) $keys[$key] = $key;
			}

			unset($keys['id']);
		?>
		<table class="table table-bordered table-hover table-striped">

				<tr class="thead-dark">
					<?php
						foreach ($keys as $key): echo "<th>$key</th>"; endforeach;
					?>
					<th class="">action</th>
				</tr>


			<?php foreach ($response->items as $item): ?>
				<tr>
					<?php
						foreach ($keys as $key): echo "<td>" . ($item->$key ?? '') . "</td>"; endforeach;
					?>
					<td class="">
						<a href="<?php echo "$basePath/default/show-record?domain=$domain&amp;id=$item->id"; ?>">edit</a>
						<a class="delete text-danger" href="<?php echo "$basePath/default/delete-record?domain=$domain&amp;id=$item->id"; ?>">delete</a>
					</td>
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
			<?php foreach ($response->items as $i) dump((array)$i) ?>
		</div>
	</div>
</div>


<?php require_once(__DIR__ . '/../footer.php'); ?>