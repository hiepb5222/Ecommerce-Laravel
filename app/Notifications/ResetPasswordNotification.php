<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $_token;
    public function __construct($token)
    {
        $this->_token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('password.reset', ['token' => $this->_token,'email' => $notifiable->getEmailForPasswordReset()]);
        return (new MailMessage)
            ->subject('Quên mật khẩu')
            ->line('Yêu cầu quên mật khẩu của bạn đã được xác nhận.')
            ->action('Quên mật khẩu', $url)
            ->line('Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!');
        // return (new MailMessage)->view('emails.users.reset', ['url' => $url]);
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
}
