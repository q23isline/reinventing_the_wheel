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
    private UploadedFile $file;

    /**
     * constructor
     *
     * @param \Laminas\Diactoros\UploadedFile|null $file file
     */
    public function __construct(
        ?UploadedFile $file
    ) {
        $errors = [];

        $this->setProperty('file', $file, $errors);

        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }
    }

    /**
     * Get the value of file
     *
     * @return \Laminas\Diactoros\UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * プロパティに値をセットする
     *
     * @param string $propertyName propertyName
     * @param mixed $value value
     * @param \App\Domain\Shared\Exception\ExceptionItem[] $errors errors
     * @return void
     */
    private function setProperty(string $propertyName, $value, array &$errors): void
    {
        if (empty($value)) {
            $errors[] = new ExceptionItem($propertyName, '必須項目が不足しています。');
        } else {
            $this->{$propertyName} = $value;
        }
    }
}
