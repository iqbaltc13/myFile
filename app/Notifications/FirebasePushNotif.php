<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

// Pastikan Channel Firebase dan FirebasePushNotification tersedia
// Kelas FirebasePushNotification berguna untuk menyimpan notifikasi dan mengolahnya sehingga
// bisa dikirim melalui channel Firebase
use App\ThirdParties\Firebase\FirebasePushNotification;
use App\Notifications\Channels\Firebase;

class FirebasePushNotif extends Notification
{
    use Queueable;

    protected $jenisOS = '';
    protected $data = [
        'title' => '',
        'body' => '',
        'label' => '',
        'icon' => 'default',
        'sound' => 'default',
        'image' => null,
    ];

    protected $notification = [
        'title' => '',
        'body' => '',
        'click-action' => '',
    ];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title = '', $body = '', $label = '', $detail = '', $data = [], $jenisOS = '')
    {
        // Kita bisa mendefinisikan nilai dari title dan body di sini, sehingga nantinya bisa
        // dipanggil pada fungsi lainnya
        $this->data['title']    = $title;
        $this->data['body']     = $body;
        $this->data['label']    = $label;   // label bisa dimanfaatkan oleh mobile apps untuk mengetahui fungsi yang berkaitan dengan notifikasi,
                                            // sehingga bisa menentukan aksi selanjutnya
        $this->data['detail']   = $detail;

        $this->notification['title']        = $title;
        $this->notification['body']         = $body;
        $this->notification['click-action'] = $label;

        $this->data             = (is_array($data)) ? array_merge($this->data, $data) : $this->data;
        $this->jenisOS          = $jenisOS;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Pastikan channel yang digunakan adalah Firebase dan Database (untuk menyimpan notifikasi di database jika sewaktu-waktu ingin dibaca kembali)
        return ['database', Firebase::class];
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
            'to'            => $notifiable->token_firebase,
            'data'          => $this->data,
            'notification'  => $this->notification
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
        // Pastikan bahwa kembalian dari fungsi toFirebase adalah object FirebasePushNotification
        // Object ini sudah memiliki fungsi-fungsi yang secara otomatis akan dimanfaatkan
        // oleh channel Firebase untuk memroses notifikasi dan mengirimkannya ke client.
        // Push notification juga bisa menyisipkan data tertentu selain title dan body.
        // Jika ingin menyisipkan data tambahan, sertakan pada parameter ke 4 constructor
        // FirebasePushNotification
        return new FirebasePushNotification($notifiable->token_firebase, $this->data['title'], $this->data['body'], $this->data, $this->notification, $this->jenisOS);
    }
}
