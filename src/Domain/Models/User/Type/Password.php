<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

/**
 * class Password
 */
final class Password
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
        // パスワードのハッシュ化は CakePHP のモデルで実施しているため
        // DBから取得時はハッシュ化状態、登録時は入力値の生パスワード状態となる
        // src/Model/Entity/User.php

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
