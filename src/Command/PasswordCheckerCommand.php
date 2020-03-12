<?php

namespace App\Command;

use App\Exception\PasswordGenerationException;
use App\Persistence\PasswordPersistenceHandlerInterface;
use App\Checker\PasswordCheckerInterface;
use App\Generator\PasswordGeneratorInterface;
use App\Validation\PasswordValidationError;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PasswordCheckerCommand
 */
class PasswordCheckerCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'password:checker';

    /** @var string */
    const PASSWORD_OPTION_NAME = 'password';

    /** @var string */
    const PASSWORD_GENERATE_OPTION_NAME = 'generate';

    /** @var PasswordCheckerInterface */
    protected $passwordChecker;

    /** @var PasswordGeneratorInterface */
    private $passwordGenerator;

    /** @var PasswordPersistenceHandlerInterface */
    private $persistenceHandler;

    /**
     * PasswordCheckerCommand constructor.
     *
     * @param PasswordCheckerInterface            $passwordChecker
     * @param PasswordGeneratorInterface          $passwordGenerator
     * @param PasswordPersistenceHandlerInterface $persistenceHandler
     */
    public function __construct(
        PasswordCheckerInterface $passwordChecker,
        PasswordGeneratorInterface $passwordGenerator,
        PasswordPersistenceHandlerInterface $persistenceHandler
    ) {
        $this->passwordChecker = $passwordChecker;
        $this->passwordGenerator = $passwordGenerator;
        $this->persistenceHandler = $persistenceHandler;

        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setDescription('Check passwords')
            ->setHelp('This command allows you to check passwords')
            ->addOption(
                self::PASSWORD_OPTION_NAME,
                'p',
                InputOption::VALUE_OPTIONAL,
                'Check particular password'
            )
            ->addOption(
                self::PASSWORD_GENERATE_OPTION_NAME,
                'g',
                InputOption::VALUE_NONE,
                'Generate password'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // particular password
        if ($input->hasOption(self::PASSWORD_OPTION_NAME) && null !== $input->getOption(self::PASSWORD_OPTION_NAME)) {
            $output->writeln($this->validatePassword($input->getOption(self::PASSWORD_OPTION_NAME)));

            return 0;
        }

        // generated password
        if ($input->getOption(self::PASSWORD_GENERATE_OPTION_NAME)) {
            try {
                $password = $this->passwordGenerator->generate();
                $output->writeln($this->validatePassword($password));
            } catch (PasswordGenerationException $exception) {
                $output->writeln('Password generation error');
            }

            return 0;
        }

        // password storage
        $outputMessage = '';

        /** @var PasswordValidationError[] $errorsCollection */
        $errorsCollection = $this->persistenceHandler->handle();
        /** @var PasswordValidationError $error */
        foreach ($errorsCollection as $error) {
            $outputMessage .= sprintf("%s\r\n\r\n",
                $this->generatePasswordInvalidMessage($error->getPassword(), $error->getErrorMessage()));
        }

        $output->write($outputMessage, false, OutputInterface::VERBOSITY_VERBOSE);

        return 0;

    }

    /**
     * @param string $password
     * @param string $errorMessage
     *
     * @return string
     */
    protected function generatePasswordInvalidMessage(string $password, string $errorMessage): string
    {
        return sprintf("Password '%s' is INVALID\r\n%s", $password, $errorMessage);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    protected function generatePasswordValidMessage(string $password): string
    {
        return sprintf('Password "%s" is VALID', $password);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    protected function validatePassword(string $password): string
    {
        if ($this->passwordChecker->checkPassword($password)) {
            $outputMessage = $this->generatePasswordValidMessage($password);
        } else {
            $outputMessage = $this->generatePasswordInvalidMessage(
                $password,
                $this->passwordChecker->getErrorMessage());
        }

        return $outputMessage;
    }
}
