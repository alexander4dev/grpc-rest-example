<?php declare(strict_types=1);

namespace Autorus\CarService\Console\Command;

/**
 * Import classes
 */
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Import functions
 */
use function file_put_contents;
use function posix_getcwd;
use function posix_getgid;
use function posix_getgrgid;
use function posix_getpwuid;
use function posix_getuid;
use function sprintf;
use function strtr;
use function trim;

/**
 * GenerateSystemdUnitFileCommand
 */
class GenerateSystemdUnitFileCommand extends Command
{

    /**
     * Systemd unit file template
     *
     * @var string
     *
     * @link https://wiki.debian.org/systemd
     * @link https://wiki.debian.org/systemd/Services
     */
    protected const SYSTEMD_UNIT_TEMPLATE = <<<'EOT'
[Unit]
After=network.target

[Service]
Type=simple
User={user}
Group={group}
WorkingDirectory={cwd}
ExecStart={rr} serve -d
ExecReload={rr} http:reset
ExecStop=/bin/kill -s TERM $MAINPID
Restart=always

[Install]
WantedBy=multi-user.target

EOT;

    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'app:generate-systemd-unit-file';

    /**
     * @Inject
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates an unit file for the systemd service manager');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questioner = $this->getHelper('question');

        $rr = trim(`which rr`);
        $format = 'The RoadRunner file [<fg=yellow>%s</>]: ';
        $question = new Question(sprintf($format, $rr), $rr);
        $context['{rr}'] = $questioner->ask($input, $output, $question);

        $cwd = posix_getcwd();
        $format = 'The application directory [<fg=yellow>%s</>]: ';
        $question = new Question(sprintf($format, $cwd), $cwd);
        $context['{cwd}'] = $questioner->ask($input, $output, $question);

        $user = posix_getpwuid(posix_getuid());
        $format = 'Which user should run the application [<fg=yellow>%s</>]: ';
        $question = new Question(sprintf($format, $user['name']), $user['name']);
        $context['{user}'] = $questioner->ask($input, $output, $question);

        $group = posix_getgrgid(posix_getgid());
        $format = 'Which group should run the application [<fg=yellow>%s</>]: ';
        $question = new Question(sprintf($format, $group['name']), $group['name']);
        $context['{group}'] = $questioner->ask($input, $output, $question);

        $content = strtr(self::SYSTEMD_UNIT_TEMPLATE, $context);
        $filename = $cwd . '/app.' . $this->container->get('name') . '.service';

        if (false === file_put_contents($filename, $content)) {
            $output->writeln('<fg=red>Failure!</>');
            return 1;
        }

        $output->writeln('');
        $output->writeln(sprintf('<fg=green>%s</>', $filename));
        return 0;
    }
}
