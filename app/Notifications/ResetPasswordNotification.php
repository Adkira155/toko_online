<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public string $email;

    /**
     * Create a new notification instance.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => app('auth.password.broker')->createToken($notifiable),
            'email' => $this->email,
        ], false));

        return (new MailMessage)
            ->subject('Permintaan Reset Kata Sandi')
            ->greeting('Yth. Pengguna,')
            ->line('Kami menerima permintaan untuk mereset kata sandi akun Anda. Jika Anda memang mengajukan permintaan ini, silakan klik tombol di bawah untuk mereset kata sandi Anda.')
            ->action('Reset Kata Sandi', $resetUrl)
            ->line('Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini. Akun Anda akan tetap aman.')
            ->line('Jika Anda menghadapi kesulitan saat mengklik tombol "Reset Kata Sandi", salin dan tempel tautan berikut ke browser Anda:')
            ->line($resetUrl)
            ->salutation('Salam hangat,')
            ->salutation('Tim Waqtuns');
    }
}
