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
final class UserAddUseCase
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
        $data = new User($this->userRepository->assignId());

        $data->setLoginId(new LoginId($command->getLoginId()));
        $data->setPassword(new Password($command->getPassword()));
        $data->setRoleName(new RoleName($command->getRoleName()));
        $data->setFirstName(new FirstName($command->getFirstName()));
        $data->setLastName(new LastName($command->getLastName()));
        $data->setFirstNameKana(new FirstNameKana($command->getFirstNameKana()));
        $data->setLastNameKana(new LastNameKana($command->getLastNameKana()));
        $data->setMailAddress(new MailAddress($command->getMailAddress()));
        $data->setSex(new Sex($command->getSex()));

        if (!empty($command->getBirthDay())) {
            $data->setBirthDay(new BirthDay($command->getBirthDay()));
        }

        if (!empty($command->getCellPhoneNumber())) {
            $data->setCellPhoneNumber(new CellPhoneNumber($command->getCellPhoneNumber()));
        }

        if ($this->userService->isExists($data)) {
            throw new ValidateException([new ExceptionItem('loginId', 'ログインIDは既に存在しています。')]);
        }

        return $this->userRepository->save($data);
    }
}
