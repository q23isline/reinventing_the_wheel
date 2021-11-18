<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile\Type;

use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileUrl;

/**
 * class ProfileImage
 *
 * @property-read \App\Domain\Models\File\Type\FileId $fileId fileId
 * @property-read \App\Domain\Models\File\Type\FileUrl $fileUrl fileUrl
 */
final class ProfileImage
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileId $id id
     * @param \App\Domain\Models\File\Type\FileUrl $url url
     */
    public function __construct(
        public readonly FileId $id,
        public readonly FileUrl $url
    ) {
    }
}
