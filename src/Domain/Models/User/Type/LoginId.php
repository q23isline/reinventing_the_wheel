<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class LoginId
 */
final class LoginId
{
    /**
     * @var string
     */
    private string $value;

    /**
     * constructor
     *
     * @param string $value value
     */
    public function __construct(string $value)
    {
        if (iconv_strlen($value) < 3) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは3文字以上です。')]);
        }

        if (iconv_strlen($value) > 20) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは20文字以下です。')]);
        }

        $this->value = $value;
    }

    /**
     * Get the value of value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
