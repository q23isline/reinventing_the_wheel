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
     * @var \App\Domain\Models\User\IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @var \App\Domain\Services\UserService
     */
    private UserService $userService;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     * @param \App\Domain\Services\UserService $userService userService
     */
    public function __construct(IUserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * ユーザーを新規追加する
     *
     * @param \App\UseCase\Users\UserAddCommand $command command
     * @return \App\Domain\Models\User\Type\UserId
     */
    public function handle(UserAddCommand $command): UserId
    {
        $birthDay = null;
        if (!empty($command->getBirthDay())) {
            $birthDay = new BirthDay($command->getBirthDay());
        }

        $cellPhoneNumber = null;
        if (!empty($command->getCellPhoneNumber())) {
            $cellPhoneNumber = new CellPhoneNumber($command->getCellPhoneNumber());
        }

        $remarks = null;
        if (!empty($command->getRemarks())) {
            $remarks = new Remarks($command->getRemarks());
        }

        $data = User::create(
            // TODO: 採番処理を UserId ドメインの中でやりたい
            $this->userRepository->assignId(),
            new LoginId($command->getLoginId()),
            new Password($command->getPassword()),
            new RoleName($command->getRoleName()),
            new FirstName($command->getFirstName()),
            new LastName($command->getLastName()),
            new FirstNameKana($command->getFirstNameKana()),
            new LastNameKana($command->getLastNameKana()),
            new MailAddress($command->getMailAddress()),
            new Sex($command->getSex()),
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );

        if ($this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは既に存在しています。')]);
        }

        return $this->userRepository->save($data);
    }
}
