<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class MentionedInComment extends BaseNotification
{
    use Queueable;
    protected $comment;
    protected $raw_content;

    public function __construct(Comment $comment, $raw_content)
    {
        $this->comment = $comment;
        $this->raw_content = $raw_content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->enableMail()) {
            return ['database', 'mail'];
        }
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = $this->comment->getCommentableData();
        return (new MailMessage)
            ->success()
            ->greeting('亲爱的' . $notifiable->name)
            ->to($notifiable->email)
            ->subject('有一条评论提到了您')
            ->line($this->comment->username . '在' . $data['type'] . ':' . $data['title'] . ' 的评论中提到了您:')
            ->line($this->raw_content)
            ->action('查看', $data['url']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->comment->toArray();
    }
}
