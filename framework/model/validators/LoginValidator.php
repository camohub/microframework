<?php




class LoginValidator extends BaseValidator
{


	public function validate()
	{
		$p = $this->post;
		$conf = $this->di->getService('Config');

		if( empty( $p['name'] ) ) $this->errors['name'] = 'Vyplňte prosím meno.';

		if( empty( $p['password'] ) ) $this->errors['password'] = 'Vyplňte prosím heslo.';

		if( $this->errors ) return FALSE;


		if( $p['name'] == $conf->loginName && $p['password'] == $conf->loginPassword ) return TRUE;

		$this->errors['invalidCredentilas'] = 'Neplatné meno alebo heslo.';
		return FALSE;
	}

}