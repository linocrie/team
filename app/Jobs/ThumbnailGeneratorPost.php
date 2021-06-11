<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickException;

class ThumbnailGeneratorPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;
    private $file;
    private $originalName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, $file, $originalName)
    {
        $this->post = $post;
        $this->file = $file;
        $this->originalName = $originalName;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ImagickException
     */
    public function handle()
    {
        $imagick = new Imagick(Storage::path($this->file));
        $imagick->resizeImage(200, 200, imagick::FILTER_UNDEFINED, 1);
        $pathExtension = pathinfo($this->file, PATHINFO_EXTENSION);
        $pathFileName = pathinfo($this->file, PATHINFO_FILENAME);
        $newImage = 'postimages/'.$pathFileName.'_thumbnail.'.$pathExtension;
        $imagick->writeImage(Storage::path($newImage));

        if(Storage::exists($this->file)) {
            PostImage::updateOrCreate(
                ['post_id' => $this->post->id],
                [
                    'original_name' => $this->originalName,
                    'path'          => $this->file,
                    'processed'     => 1
                ]
            );
        }
    }
}
