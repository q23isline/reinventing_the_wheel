<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Models\File\Type\FileId;

/**
 * class FileSavedResult
 */
final class FileSavedResult
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileId $fileId fileId
     */
    public function __construct(
        private FileId $fileId
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
            'fileId' => $this->fileId->value,
        ];
    }
}
