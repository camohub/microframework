
<form action="<?php echo "$basePath/default/create-record-submit?domain=$domain" ?>" method="post" id="createRecordForm" class="col-12 offset-md-3 col-md-6">

	<?php include(__DIR__ . '/formErrors.php') ?>

	<div class="form-group">
		<label for="type">Typ</label>
		<select type="type" name="type" id="typeId" class="form-control">
			<option></option>
			<?php foreach(ApiDnsService::RECORD_TYPES as $type): ?>
				<option name="type"
						value="<?php echo $type ?>"
						<?php if( isset($post['type']) && $post['type'] == $type ) echo 'selected' ?>
				>
					<?php echo $type ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group">
		<label for="name">Názov</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>A, AAAA, MX, NS, TXT, SRV</b>: subdomain name or @ if you don't want subdomain <br>
			<b>CNAME</b>: subdomain name <br>
			<b>ANAME</b>: value: @ or empty string
		</div>
		<input type="text" name="name" class="form-control" value="<?php echo $post['name'] ?? '' ?>">
	</div>

	<div class="form-group">
		<label for="content">Content</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>A</b>: IPv4 address in dotted decimal format, i.e. 1.2.3.4 <br>
			<b>AAAA</b>: IPv6 address ex. 2001:db8::3 <br>
			<b>MX</b>: domain name of mail servers, i.e. mail1.scaledo.com <br>
			<b>ANAME, CNAME</b>: the canonical hostname something.scaledo.com <br>
			<b>NS</b>: the canonical hostname of the DNS server, i.e. ns1.scaledo.com <br>
			<b>TXT</b>: text used for DKIM or other purposes <br>
			<b>SRV</b>: the canonical hostname of the machine providing the service <br>
		</div>
		<input type="text" name="content" class="form-control" value="<?php echo $post['content'] ?? '' ?>">
	</div>

	<div class="form-group">
		<label for="ttl">TTL</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>A, AAAA, MX, ANAME, CNAME, NS, TXT, SRV</b>: time to live, default 600 <br>
		</div>
		<input type="text" name="ttl" class="form-control" value="<?php echo $post['ttl'] ?? '' ?>">
	</div>

	<div class="form-group specialInput mx-js srv-js">
		<label for="prio">Priority</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>MX, SRV</b>: record priority <br>
		</div>
		<input type="text" name="prio" class="form-control" value="<?php echo $post['prio'] ?? '' ?>">
	</div>

	<div class="form-group specialInput srv-js">
		<label for="weight">Weight</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>SRV</b>: a relative weight for records with the same priority <br>
		</div>
		<input type="text" name="weight" class="form-control" value="<?php echo $post['weight'] ?? '' ?>">
	</div>

	<div class="form-group specialInput srv-js">
		<label for="port">Port</label> <span class="material-icons float-right help">help</span>
		<div class="help-content mb-5">
			<b>SRV</b>: the TCP or UDP port on which the service is to be found <br>
		</div>
		<input type="text" name="port" class="form-control" value="<?php echo $post['port'] ?? '' ?>">
	</div>

	<div class="form-group pb-25">
		<label for="port">Poznámka</label>
		<input type="text" name="note" class="form-control" value="<?php echo $post['note'] ?? '' ?>">
	</div>

	<input type="submit" value="Odoslať" class="btn btn-primary">
</form>

<script>
	<?php include_once(__DIR__ . '/createRecordForm.js'); ?>
</script>

