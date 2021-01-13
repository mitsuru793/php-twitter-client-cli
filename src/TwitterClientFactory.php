<?php
declare(strict_types=1);

namespace TwitterClientCli;

use Abraham\TwitterOAuth\TwitterOAuth;

final class TwitterClientFactory
{
    public function makeFromEnv(): TwitterOAuth
    {
        return new TwitterOAuth(
            $_ENV['TWITTER_CONSUMER_KEY'],
            $_ENV['TWITTER_CONSUMER_SECRET'],
            $_ENV['TWITTER_ACCESS_TOKEN'],
            $_ENV['TWITTER_ACCESS_TOKEN_SECRET'],
        );
    }
}