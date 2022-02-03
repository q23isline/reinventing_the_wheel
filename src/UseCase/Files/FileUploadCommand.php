<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;
use Laminas\Diactoros\UploadedFile;

/**
 * class FileUploadCommand
 *
 * @property-read \Laminas\Diactoros\UploadedFile $file file
 */
final class FileUploadCommand
{
    public readonly UploadedFile $file;

    /**
     * constructor
     *
     * @param \Laminas\Diactoros\UploadedFile|null $file file
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(
        ?UploadedFile $file
    ) {
        $errors = [];

        if (empty($file)) {
            $errors[] = new ExceptionItem('file', '必須項目が不足しています。');
        } else {
            $this->file = $file;
        }

        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }
    }
}
