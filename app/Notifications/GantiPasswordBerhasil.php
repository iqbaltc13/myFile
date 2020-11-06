<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ThirdParties\Firebase\FirebasePushNotification;
use App\Notifications\Channels\Firebase;

class GantiPasswordBerhasil extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $passwordChangeDate;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $passwordChangeDate = date('Y-m-d H:i:s');
        $this->title = 'Perubahan Password Berhasil';
        $this->body = 'Password anda berhasil diubah pada tanggal '.$passwordChangeDate;
        $this->passwordChangeDate = $passwordChangeDate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (strtoupper(env('APP_ENV')) !== 'STANDALONE_TESTING')
            return ['database', 'mail', Firebase::class];        
        else 
            return ['database'];
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
            ->subject($this->title)
            ->markdown('vendor.notifications.gantiPasswordBerhasilEmail', [
                'notifiable' => $notifiable,
                'passwordChangeDate' => $this->passwordChangeDate,
            ]);
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
            'title' => $this->title,
            'body' => $this->body,
            'passwordChangeDate' => $this->passwordChangeDate,
        ];
    }
    
    /**
     * Get the FirebasePushNotification object representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toFirebase($notifiable)
    {
        return new FirebasePushNotification($notifiable->firebase_token, $this->title, $this->body, []);
    }
}
