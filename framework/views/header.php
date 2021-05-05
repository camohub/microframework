<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title></title>
	<style>
		<?php require_once(__DIR__ . '/../../assets/main.css'); ?>
	</style>
</head>
<body>
<div class="header">
	<div class="container">
		<div class="row">
			<h1 class="col-12">Websupport DNS</h1>
		</div>
	</div>
	<div class="top-menu">
		<div class="container">
			<div class="row">
				<div class="col-12 top-menu">
					<a href="<?php echo $basePath ?>">DNS záznamy</a>
					<?php if( !$sessionService->get('login') ): ?>
						<a href="<?php echo $basePath ?>/login">Prihlásenie</a>
					<?php else: ?>
						<a href="<?php echo $basePath ?>/logout">Odhlásiť</a>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>