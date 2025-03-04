<?php

namespace src\tests\unit;

class MockPhpInputStream
{
    private static $data='';

    public function stream_open($path, $mode, $options, &$opened_path): bool
    {
        return true;
    }

    public function stream_read($count): string
    {
        return substr(self::$data, 0, $count);
    }

    public function stream_write($data)
    {
        self::$data .= $data;
        return strlen($data);
    }

    public function stream_eof(): bool
    {
        return true;
    }

    public function stream_stat() {
        return [];
    }
}