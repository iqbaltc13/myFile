<?php

namespace App\ThirdParties\Sms;

class OneWaySMSConnection
{
    protected $userKey = '';
    protected $passKey = '';
	protected $url = '';
    protected $targetPhone = '';
    protected $message = '';

	public function __construct() 
	{
		$this->url = env('ONEWAYSMS_URL', '');
		$this->userKey = env('ONEWAYSMS_USERKEY', '');
        $this->passKey = env('ONEWAYSMS_PASSKEY', '');
		$this->senderId = env('ONEWAYSMS_SENDERID', '');
		return $this;
	}

	public function setMessage($targetPhone = '', $message = '') 
	{
        $this->targetPhone = $targetPhone;
        $this->message = $message;
		return $this;
	}

	public function send() 
	{

        $url = $this->url.'?apiusername='.$this->userKey.'&apipassword='.$this->passKey.'&mobileno='.$this->targetPhone.'&senderid='.$this->senderId.'&message='.urlencode($this->message);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

		return $result;
	}
}