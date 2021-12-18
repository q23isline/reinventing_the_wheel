<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class LoginId
 *
 * @property-read string $value value
 */
final class LoginId
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 20;

    public readonly string $value;

    /**
     * constructor
     *
     * @param string $value value
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(string $value)
    {
        if (iconv_strlen($value) < self::MIN_LENGTH) {
            throw new ValidateException([new ExceptionItem('loginId', sprintf('ログインIDは%d文字以上です。', self::MIN_LENGTH))]);
        }

        if (iconv_strlen($value) > self::MAX_LENGTH) {
            throw new ValidateException([new ExceptionItem('loginId', sprintf('ログインIDは%d文字以下です。', self::MAX_LENGTH))]);
        }

        $this->value = $value;
    }
}
