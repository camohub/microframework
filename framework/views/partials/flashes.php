<div class="container">
	<div class="row">
		<div class="col-12">
			<?php
				$flashes = DIContainer::getContainer()->getService('SessionService')->getFlashes();

				foreach ($flashes as $f)
				{
					echo '<div class="alert alert-' . $f[1]. ' mb-5">' . $f[0] . '</div>';
				}
			?>
		</div>
	</div>
</div>
