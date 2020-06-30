<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Post;

class NewPost extends Mailable
{
    use Queueable, SerializesModels;

    //Post new istance
    private $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->from('mytest@test.com') //da parte di chi
            ->subject('post updated' . $this->post->title)
            ->markdown('mail.new-post')//cosa tornare
            ->with([
                'title' => $this->post->title,
                'slug' => $this->post->slug
            ]);
    }
}
