<?php


class DnsRecordValidator extends BaseValidator
{

	const SESS_ERRORS_KEY = self::class . '-errors';
	const SESS_POST_KEY = self::class . '-post';


	public function validate()
	{
		$g = $this->get;
		$conf = $this->di->getService('Config');

		if( !in_array($g['domain'], $conf->domains) ) $this->errors['domain'] = 'Nemáte oprávnenie upravovať záznamy pre doménu ' . $g['domain'] . '.';

		$this->validateType();
		$this->validateName();
		$this->validateContent();
		$this->validateTTL();
		$this->validatePriority();
		$this->validateWeight();
		$this->validatePort();

		$this->setAllowedFieldsForType();

		return $this->errors ? FALSE : TRUE;
	}


	protected function validateType()
	{
		$type = $this->post['type'];

		if( !in_array($type, ApiBaseService::RECORD_TYPES) ) $this->errors['type'] = "Vybraný typ $type nieje validný.";
	}


	/**
	 * A, AAAA, MX, NS, TXT: subdomain name or @ if you don't want subdomain
	 * CNAME: subdomain name
	 * ANAME: value: @ or empty string
	 */
	protected function validateName()
	{
		$type = $this->post['type'];
		$name = $this->post['name'];
		// https://www.oreilly.com/library/view/regular-expressions-cookbook/9781449327453/ch08s15.html
		// https://www.geeksforgeeks.org/how-to-validate-a-domain-name-using-regular-expression/
		$regexpDomainWithAt = '/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)|@$/';
		$regexpDomain = '/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)$/';

		if( in_array($type, ['A', 'AAAA', 'MX', 'NS', 'TXT', 'SRV']) )
		{
			// https://www.oreilly.com/library/view/regular-expressions-cookbook/9781449327453/ch08s15.html
			// https://www.geeksforgeeks.org/how-to-validate-a-domain-name-using-regular-expression/
			if( !preg_match($regexpDomainWithAt, $name) ) $this->errors['name'] = "Názov $name nieje validný pre typ $type záznamu.";
		}
		elseif ( in_array($type, ['CNAME']) )
		{
			if( !preg_match($regexpDomain, $name) ) $this->errors['name'] = "Názov $name nieje validný pre typ $type záznamu.";
		}
		elseif ( in_array($type, ['ANAME']) )
		{
			if ( $name !== '' && $name !== '@' ) $this->errors['name'] = "Názov $name nieje validný pre typ $type záznamu.";
 		}
	}


	/**
	 * A: IPv4 address in dotted decimal format, i.e. 1.2.3.4
	 * AAAA: IPv6 address ex. 2001:db8::3
	 * MX: domain name of mail servers, i.e. mail1.scaledo.com
	 * ANAME, CNAME: the canonical hostname something.scaledo.com
	 * NS: the canonical hostname of the DNS server, i.e. ns1.scaledo.com
	 * TXT: text used for DKIM or other purposes
	 * SRV: the canonical hostname of the machine providing the service
	 */
	protected function validateContent()
	{
		$type = $this->post['type'];
		$content = $this->post['content'];
		// https://www.oreilly.com/library/view/regular-expressions-cookbook/9780596802837/ch07s16.html
		// https://www.regular-expressions.info/ip.html
		$regexpIPv4 = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
		// https://ihateregex.io/expr/ipv6/
		$regexpIPv6 = '/^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$/';
		// https://www.oreilly.com/library/view/regular-expressions-cookbook/9781449327453/ch08s15.html
		$regexpDomain = '/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,}$/';

		if( in_array($type, ['A']) )
		{
			if( !preg_match($regexpIPv4, $content) ) $this->errors['content'] = "Content $content nieje validný pre typ $type záznamu.";
		}
		elseif ( in_array($type, ['AAAA']) )
		{
			if( !preg_match($regexpIPv6, $content) ) $this->errors['content'] = "Content $content nieje validný pre typ $type záznamu.";
		}
		elseif ( in_array($type, ['MX', 'ANAME', 'CNAME', 'NS', 'SRV']) )
		{
			if( !preg_match($regexpDomain, $content) ) $this->errors['content'] = "Content $content nieje validný pre typ $type záznamu.";
		}
		elseif ( in_array($type, ['TXT']) )
		{
			if( empty($content) ) $this->errors['content'] = "Content $content nieje validný pre typ $type záznamu.";
		}
	}


	/**
	 * A, AAAA, MX, ANAME, CNAME, NS, TXT, SRV: time to live, default 600
	 */
	protected function validateTTL()
	{
		$type = $this->post['type'];
		$ttl = $this->post['ttl'];

		if( in_array($type, ['A', 'AAAA', 'MX', 'ANAME', 'CNAME', 'NS', 'TXT', 'SRV']) )
		{
			if( !preg_match('/^\d+$/', $ttl) ) $this->errors['ttl'] = "TTL $ttl nieje validný pre typ $type záznamu.";
		}
	}


	/**
	 * MX, SRV: record priority
	 */
	protected function validatePriority()
	{
		$type = $this->post['type'];
		$prio = $this->post['prio'];

		if( in_array($type, ['MX', 'SRV']) )
		{
			if( !preg_match('/^\d+$/', $prio) ) $this->errors['prio'] = "Priority $prio nieje validný pre typ $type záznamu.";
		}
	}


	/**
	 * SRV: a relative weight for records with the same priority
	 */
	protected function validateWeight()
	{
		$type = $this->post['type'];
		$weight = $this->post['weight'];

		if( in_array($type, ['SRV']) )
		{
			if( !preg_match('/^\d+$/', $weight) ) $this->errors['weight'] = "TTL $weight nieje validný pre typ $type záznamu.";
		}
	}


	/**
	 * SRV: the TCP or UDP port on which the service is to be found <br>
	 */
	protected function validatePort()
	{
		$type = $this->post['type'];
		$port = $this->post['port'];

		if( in_array($type, ['SRV']) )
		{
			if( !preg_match('/^\d+$/', $port) ) $this->errors['port'] = "Port $port nieje validný pre typ $type záznamu.";
		}
	}


	protected function setAllowedFieldsForType()
	{
		$newPost = [];
		$newPost['type'] = $type = $this->post['type'];
		$newPost['name'] = $this->post['name'];
		$newPost['content'] = $this->post['content'];
		$newPost['ttl'] = $this->post['ttl'];
		$newPost['note'] = $this->post['note'];

		if( in_array($type, ['MX', 'SRV']) )
		{
			$newPost['prio'] = $this->post['prio'];
		}
		if( in_array($type, ['SRV']) )
		{
			$newPost['weight'] = $this->post['weight'];
			$newPost['port'] = $this->post['port'];
		}

		$this->post = $newPost;
	}

}