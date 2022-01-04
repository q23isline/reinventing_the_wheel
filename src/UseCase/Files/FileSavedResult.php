<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Models\File\Type\FileUrl;

/**
 * class FileSavedResult
 */
final class FileSavedResult
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileUrl $fileUrl fileUrl
     */
    public function __construct(
        private FileUrl $fileUrl
    ) {
    }

    /**
     * 整形する
     *
     * @return array<string,string>
     */
    public function format(): array
    {
        return [
            'url' => $this->fileUrl->value,
        ];
    }
}
