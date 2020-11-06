<?php

namespace App\ThirdParties\Sms;

class AdsmediaConnection
{
    protected $apiKey = '';
	protected $url = '';
    protected $targetPhone = '';
    protected $message = '';

	/**
	 * Connection constructor
	 * @param string $type.
	 * 	Available type:
	 * 		otp => For OTP SMS
	 * 		reguler => For Reguler SMS
	 * 		masking => For Masked SMS
	 */
	public function __construct($type = 'otp') 
	{
		$availablePaths = [
			'reguler' => '/sms/api_sms_reguler_send_json.php',
			'otp' => '/sms/api_sms_otp_send_json.php',
			'masking' => '/sms/api_sms_masking_send_json.php',
		];
		$baseUrl = trim(env('ADSMEDIA_URL', ''), '/');
		$path = array_key_exists($type, $availablePaths) ? $availablePaths[$type] : $availablePaths['reguler'];
		$this->url = $baseUrl.$path;
		$this->apiKey = env('ADSMEDIA_APIKEY', '');
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
        $url = $this->url;
		$ch = curl_init();
		$payload = json_encode([
			'apikey' => $this->apiKey,
			'datapacket' => [
				[
					'number' => $this->targetPhone,
					'message' => $this->message,
					'sendingdatetime' => date('Y-m-d H:i:s'),
				]
			]
		]);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload))
		);
		$result = curl_exec($ch);
		$curlErrno = curl_errno($ch);
		$curlError = curl_error($ch);	
		$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$finalResult = $result;
		if ($curlErrno > 0) {
			$finalResult = [
				'sending_respon' => [
					'globalstatus' => 90, 
					'globalstatustext' => $curlErrno."|".$httpCode,
					'error' => $curlError,
				]
			];
		} else {
			if ($httpCode != "200") {
				$finalResult = [
					'sending_respon' => [
						'globalstatus' => 90, 
						'globalstatustext' => $curlErrno."|".$httpCode,
						'error' => $curlError,
					]
				];
			}
		}
		return $result;
	}
}