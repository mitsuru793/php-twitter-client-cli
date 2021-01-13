<?php
declare(strict_types=1);

namespace TwitterClientCli;

final class ConsoleDumper
{
    /**
     * @param mixed $content
     * @throws \JsonException
     */
    public function jsonPretty($content): string
    {
        $option = JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR;
        return json_encode($content, $option);
    }
}