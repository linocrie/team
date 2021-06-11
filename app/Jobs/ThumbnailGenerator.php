<?php

namespace App\Jobs;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;
use ImagickException;

class ThumbnailGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $file;
    private $originalName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $file, $originalName)
    {
        $this->user = $user;
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
        $newImage = 'avatars/'.$pathFileName.'_thumbnail.'.$pathExtension;

        $imagick->writeImage(Storage::path($newImage));

        if(Storage::exists($newImage)) {
            Avatar::updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'original_name' => $this->originalName,
                    'path'          => $this->file,
                    'processed'     => 1
                ]
            );
        }
    }
}
