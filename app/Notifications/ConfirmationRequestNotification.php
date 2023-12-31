<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmationRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage);
        // ->subject('Invite to ' . $this->data->invite->engagement->name . ' Engagement')
        // ->from('support@ea-audit.com', 'Techmozzo')
        // ->greeting('Hello ' . $this->data->invite->user->first_name . '!')
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!')
        //             ->salutation('Thanks')
        // ->markdown('notifications.mail', compact('notifiable'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // $link = env('APP_URL')."/app/engagements/".encrypt_helper($this->data->invite->engagement->id)."/invites/".encrypt_helper($this->data->invite->id);
        // return [
        // 	'link' => $link,
        // 	'title' => 'Invite to' . $this->data->invite->engagement->name . ' Engagement',
        // 	'type' => 'invitation',
        // ];
    }
}
