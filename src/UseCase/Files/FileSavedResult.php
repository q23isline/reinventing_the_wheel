<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Models\File\Type\FileId;

final class FileSavedResult
{
    /**
     * @var \App\Domain\Models\File\Type\FileId
     */
    private FileId $fileId;

    /**
     * constructor
     *
     * @param \App\Domain\Models\File\Type\FileId $fileId fileId
     */
    public function __construct(FileId $fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * 整形する
     *
     * @return array<string,string>
     */
    public function format(): array
    {
        return [
            'fileId' => $this->fileId->getValue(),
        ];
    }
}