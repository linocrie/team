<?php

namespace App\Mail;

use App\Models\Gallery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GalleryCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($gallery)
    {
         $this->gallery = $gallery;

    }


    public function build()
    {
        return $this->view('emails.gallery')
            ->with('gallery', $this->gallery->load(['images']));

    }
}
