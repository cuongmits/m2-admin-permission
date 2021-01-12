<?php

namespace Cuongmits\AdminPermissions\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;
use Cuongmits\AdminPermissions\AdminRoles\OperationsAdminRole;
use Cuongmits\AdminPermissions\AdminRoles\MarketingAdminRole;
use Cuongmits\AdminPermissions\AdminRoles\C4CAdminRole;
use Psr\Log\LoggerInterface;
use Cuongmits\AdminPermissions\AdminRoles\AdminUsers\AdminUser;

class CreateAdminRoleAndUserCommand extends Command
{
    /** @var State */
    private $appState;

    /** @var OperationsAdminRole */
    private $operationsAdminRole;

    /** @var C4CAdminRole */
    private $c4CAdminRole;

    /** @var MarketingAdminRole */
    private $marketingAdminRole;

    /** @var LoggerInterface */
    protected $logger;

    /** @var AdminUser */
    private $adminUser;

    public function __construct(
        State $appState,
        OperationsAdminRole $operationsAdminRole,
        C4CAdminRole $c4CAdminRole,
        MarketingAdminRole $marketingAdminRole,
        AdminUser $adminUser,
        LoggerInterface $logger
    ) {
        parent::__construct();

        $this->appState = $appState;
        $this->operationsAdminRole = $operationsAdminRole;
        $this->c4CAdminRole = $c4CAdminRole;
        $this->marketingAdminRole = $marketingAdminRole;
        $this->logger = $logger;
        $this->adminUser = $adminUser;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('toom:create-admin-role')
            ->setDescription('Create an admin role and its user if need.')
            ->addArgument('role-name', InputArgument::REQUIRED, 'name of new creating role (operations, marketing, c4c)')
            ->addOption('create-user', null, InputOption::VALUE_OPTIONAL, 'create an user (yes/no), default - no', 'no')
            ->addOption('username', null, InputOption::VALUE_OPTIONAL, 'username of new creating user')
            ->addOption('firstname', null, InputOption::VALUE_OPTIONAL, 'firstname of new user, default - `Firstname`', 'Firstname')
            ->addOption('lastname', null, InputOption::VALUE_OPTIONAL, 'lastname of new user, default - `Lastname`', 'Lastname')
            ->addOption('email', null, InputOption::VALUE_OPTIONAL, 'email of new user')
            ->addOption('password', null, InputOption::VALUE_OPTIONAL, 'password of new user')
            ->addOption('interface_locale', null, InputOption::VALUE_OPTIONAL, 'interface_locale of new user, default is `de_DE`', 'de_DE')
            ->addOption('is_active', null, InputOption::VALUE_OPTIONAL, 'if new user is active, default is 1', 1)
            ->setHelp('role-name = [marketing|c4c|operations], create-user = [yes|no]')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->appState->setAreaCode(Area::AREA_GLOBAL);
        } catch (Exception $e) {
            $output->writeln('<info>Area Code is already set.</info>');
        }

        $output->writeln('<info>Starting admin role & user creating process...</info>');

        $roleName = (string) $input->getArgument('role-name');
        $createUser = (string) $input->getOption('create-user');
        $adminInfo = [
            'username' => $input->getOption('username'),
            'firstname' => $input->getOption('firstname'),
            'lastname' => $input->getOption('lastname'),
            'email' => $input->getOption('email'),
            'password' => $input->getOption('password'),
            'interface_locale' => $input->getOption('interface_locale'),
            'is_active' => $input->getOption('is_active'),
        ];

        $roleId = $this->createAdminRole($roleName, $createUser, $adminInfo);

        if (is_null($roleId)) {
            $output->writeln('<warning>Not correct role name parameter.</warning>');
            $this->logger->info('Create admin role: Not correct role name parameter.');

            return 1;
        }

        $msg = 'New admin role has been created' . ($createUser === 'yes' ? ' with admin user.' : '.');
        $output->writeln("<info>$msg</info>");
        if ($createUser === 'yes') {
            $output->writeln("<info>username: " . $adminInfo['username'] . "</info>");
            $output->writeln("<info>firstname: " . $adminInfo['firstname'] . "</info>");
            $output->writeln("<info>lastname: " . $adminInfo['lastname'] . "</info>");
            $output->writeln("<info>email: " . $adminInfo['email'] . "</info>");
            $output->writeln("<info>password: ***** </info>");
            $output->writeln("<info>interface_locale: " . $adminInfo['interface_locale'] . "</info>");
            $output->writeln("<info>is_active: " . $adminInfo['is_active'] . "</info>");
        }
        $this->logger->info("Create admin role: $msg");

        return 0;
    }

    private function createAdminRole(string $roleName, string $createUser, array $adminInfo): int
    {
        $roleId = null;
        if ($roleName === OperationsAdminRole::ROLE_KEY) {
            $roleId = $this->operationsAdminRole->create();
        } elseif ($roleName === MarketingAdminRole::ROLE_KEY) {
            $roleId = $this->marketingAdminRole->create();
        } elseif ($roleName === C4CAdminRole::ROLE_KEY) {
            $roleId = $this->c4CAdminRole->create();
        }

        if (!is_null($roleId) && $createUser === 'yes') {
            $this->adminUser->create($roleId, $adminInfo);
        }

        return $roleId;
    }
}
