<?php

namespace App\Features;

use App\Contracts\HandleStoreImageProcessContract;
use App\Models\Image;
use Illuminate\Foundation\Bus\Dispatchable;

final class HandleStoreImageProcess implements HandleStoreImageProcessContract
{
    use Dispatchable;

    public function __construct(
        public array $image
    ) {}

    public function handle(): void
    {
        $file = $this->image['file'];
        $path = $this->image['path'];
        $filename = time() . '.' . $file->getClientOriginalName();
        $type = $file->getMimeType();
        $publicPath = public_path($path);
        $file->move($publicPath, $filename);

        Image::create([
            'title' => $filename,
            'url' => $path.$filename,
            'image_type' => $type,
            'imageable_id' => $this->image['id'],
            'imageable_type' => $this->image['model']
        ]);
    }
}
