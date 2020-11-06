<?php

namespace App\ThirdParties\Firebase;

class FirebasePushNotification
{
    protected $recipientToken;
    protected $title;
    protected $body;
    protected $data = [
        'title' => '',
        'body' => '',
    ];
    protected $jenisOS;

    /**
     * @param string $recipientToken .Recipient's firebase token.
     * @param string $title .Message title.
     * @param string $body .Message body.
     * @param array $data .Data to be attached in message.
     */
    public function __construct($recipientToken = NULL, $title = NULL, $body = NULL, $data = [], $notification = [], $jenis_os = NULL)
    {
        $this->recipientToken = $recipientToken;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->notification = $notification;
        $this->jenisOS = $jenis_os;
    }

    public function setRecipientToken($recipientToken = '')
    {
        $this->recipientToken = $recipientToken;
        return $this;
    }

    public function getRecipientToken()
    {
        return $this->recipientToken;
    }

    public function setTitle($title = '')
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setBody($body = '')
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setData($data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function toArray()
    {
        $data['title']  = $this->title;
        $data['body']   = $this->body;
        $data           = array_merge($data, $this->data);
        $notification   = $this->notification;
        $jenisOS        = $this->jenisOS;

        if($jenisOS == 'android')
        {
            $payload = [
                'to' => $this->recipientToken,
                'data' => (object)$data
            ];
        }
        else
        {
            $payload = [
                'to' => $this->recipientToken,
                'data' => (object)$data,
                'notification' => $notification
            ];
        }
        return $payload;
    }
}