<?php


class DomainValidator extends BaseValidator
{


	public function validate()
	{
		$g = $this->get;
		$conf = $this->di->getService('Config');

		if( !in_array($g['domain'], $conf->domains) ) $this->errors['domain'] = 'Nemáte oprávnenie upravovať záznamy pre doménu ' . $g['domain'] . '.';

		return $this->errors ? FALSE : TRUE;
	}

}