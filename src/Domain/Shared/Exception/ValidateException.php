<?php
declare(strict_types=1);

namespace App\Domain\Shared\Exception;

use Exception;

/**
 * class ValidateException
 */
final class ValidateException extends Exception
{
    /**
     * constructor
     *
     * @param array<\App\Domain\Shared\Exception\ExceptionItem> $errors errors
     * @param \Exception|null $previous previous
     */
    public function __construct(
        protected array $errors = [],
        ?Exception $previous = null
    ) {
        $this->errors = $errors;

        // 親 Exception クラスでプロパティ定義済
        $message = 'Bad Request';
        $code = 400;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the value of errors
     *
     * @return array<\App\Domain\Shared\Exception\ExceptionItem>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * 整形する
     *
     * @return array<string,array<string,mixed>>
     */
    public function format(): array
    {
        $errors = [];
        foreach ($this->getErrors() as $error) {
            $errors[] = [
                'field' => $error->field,
                'reason' => $error->reason,
            ];
        }

        return [
            'error' => [
                'message' => $this->getMessage(),
                'errors' => $errors,
            ],
        ];
    }
}
