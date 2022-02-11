<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\Type\ProfileId;

/**
 * class ProfileSavedResult
 */
final class ProfileSavedResult
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $profileId profileId
     */
    public function __construct(
        private ProfileId $profileId
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
            'profileId' => $this->profileId->value,
        ];
    }
}
