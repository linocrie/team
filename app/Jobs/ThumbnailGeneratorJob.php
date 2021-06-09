<?php

namespace App\Jobs;

use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;

class ThumbnailGeneratorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $imagePath;
    protected $imageId;

    public function __construct($imagePath,$imageId)
    {
        $this->imagePath = $imagePath;
        $this->imageId = $imageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \ImagickException
     */
    public function handle()
    {
        $imagick = new Imagick(Storage::path($this->imagePath));
        $pathExtension = pathinfo($this->imagePath, PATHINFO_EXTENSION);
        $thumbnail = Str::substr($this->imagePath, 0, -4) . '_thumbnail.' . $pathExtension;
        $imagick->resizeImage(500, 500, imagick::FILTER_LANCZOS, 1);
        $cropWidth = $imagick->getImageWidth();
        $cropHeight = $imagick->getImageHeight();

        if (true) {
            $newWidth = $cropWidth / 2;
            $newHeight = $cropHeight / 2;

            $imagick->cropimage(
                $newWidth,
                $newHeight,
                ($cropWidth - $newWidth) / 2,
                ($cropHeight - $newHeight) / 2
            );

            $imagick->scaleimage(
                $imagick->getImageWidth() * 4,
                $imagick->getImageHeight() * 4
            );
        }
        $imagick->writeImage(Storage::path($thumbnail));
        GalleryImages::where("id",$this->imageId)->update(["processed"=> 1]);

    }
}

