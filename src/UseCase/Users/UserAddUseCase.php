<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\Remarks;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserAddUseCase
 */
class UserAddUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     * @param \App\Domain\Services\UserService $userService userService
     */
    public function __construct(
        private IUserRepository $userRepository,
        private UserService $userService
    ) {
    }

    /**
     * ユーザーを新規追加する
     *
     * @param \App\UseCase\Users\UserAddCommand $command command
     * @return \App\Domain\Models\User\Type\UserId
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function handle(UserAddCommand $command): UserId
    {
        $birthDay = $command->birthDay;
        $cellPhoneNumber = $command->cellPhoneNumber;
        $remarks = $command->remarks;

        $data = User::create(
            // TODO: 採番処理を UserId ドメインの中でやりたい
            $this->userRepository->assignId(),
            new LoginId($command->loginId),
            new Password($command->password),
            new RoleName($command->roleName),
            new FirstName($command->firstName),
            new LastName($command->lastName),
            new FirstNameKana($command->firstNameKana),
            new LastNameKana($command->lastNameKana),
            new MailAddress($command->mailAddress),
            new Sex($command->sex),
            empty($birthDay) ? null : new BirthDay($birthDay),
            empty($cellPhoneNumber) ? null : new CellPhoneNumber($cellPhoneNumber),
            empty($remarks) ? null : new Remarks($remarks),
        );

        if ($this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは既に存在しています。')]);
        }

        return $this->userRepository->save($data);
    }
}
