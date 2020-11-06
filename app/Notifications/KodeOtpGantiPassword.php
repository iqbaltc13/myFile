<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\Sms;
use App\ThirdParties\Sms\SmsNotification;

class KodeOtpGantiPassword extends Notification
{
    use Queueable;

    protected $smsNotification;
    public $type = 'otp';
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($phoneNumber = '', $otpCode = '')
    {
        $message = '[MKI] Kode keamanan ganti password: '.$otpCode;
        $this->smsNotification = new SmsNotification($phoneNumber, $message);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [Sms::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the SmsNotification object representation of the notification.
     * @see App\ThirdParties\Sms\SmsNotification
     * @param  mixed  $notifiable
     * @return array
     */
    public function toSms($notifiable)
    {
        return $this->smsNotification;
    }
}