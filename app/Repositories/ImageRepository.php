<?php

namespace App\Repositories;

use App\Image;

class ImageRepository
{
    public function getSelected()
    {
        return Image::query()
            ->where('is_selected', true)
            ->limit(1)
            ->first();
    }
}
