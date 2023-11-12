<?php

namespace App\Services;

use App\Features\HandleStoreImageProcess;

class GlobalService
{
    public function processUploadedImage(array $image): void
    {
        $process = new HandleStoreImageProcess(
            image: $image
        );
        dispatch($process);
    }
}
