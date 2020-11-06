<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

// Pastikan Sms Channel dan SmsNotification tersedia 
// SmsNotification adalah kelas yang bisa digunakan untuk menyimpan notifikasi dengan format SMS
// Kelas ini menyediakan beberapa metode yang siap pakai untuk mendukung operasi notifikasi via SMS
use App\Notifications\Channels\Sms;
use App\ThirdParties\Sms\SmsNotification;

class ContohSmsNotif extends Notification
{
    use Queueable;

    // Siapkan variable untuk menyimpan object dari SmsNotification
    protected $smsNotification; 
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($phoneNumber = '', $messageToUser = '')
    {
        // Buat object SmsNotification yang telah memiliki nomor tujuan dan isi pesan
        $message = 'Contoh pesan: '.$messageToUser;
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
        // Pastikan bahwa channel yang digunakan adalah SMS
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
        // Pastikan bahwa kembalian dari fungsi toSms adalah object dari SmsNotification
        // Dengan begini maka channel Sms akan secara otomatis memanfaatkan fungsi-fungsi pada
        // kelas SmsNotification untuk memroses notifikasi.
        return $this->smsNotification;
    }
}
