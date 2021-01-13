<?php
declare(strict_types=1);

namespace TwitterClientCli\ConsoleCommand;

use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ShowCommand extends Command
{
    protected static $defaultName = 'show';

    private const TWEET_RE = '~([0-9a-zA-Z_]+)/status(?:es)?/(\d+)~';

    protected function configure()
    {
        $this
            ->setDescription('show a tweet object by url')
            ->addArgument('url', InputArgument::REQUIRED, 'twitter url');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tweetUrl = $input->getArgument('url');
        $tweetId = $this->takeTweetId($tweetUrl);
        if (is_null($tweetId)) {
            throw new \InvalidArgumentException('Not found tweet id in argument.');
        }

        $connection = new TwitterOAuth(
            $_ENV['TWITTER_CONSUMER_KEY'],
            $_ENV['TWITTER_CONSUMER_SECRET'],
            $_ENV['TWITTER_ACCESS_TOKEN'],
            $_ENV['TWITTER_ACCESS_TOKEN_SECRET']
        );
        $endpoint = sprintf('statuses/show/%d', $tweetId);
        $content = $connection->get($endpoint);
        $json = json_encode($content, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        $output->writeln($json);
        return Command::SUCCESS;
    }

    private function takeTweetId(string $url): ?int
    {
        if (preg_match(self::TWEET_RE, $url, $matches)) {
            return (int)$matches[2];
        }
        return null;
    }
}

