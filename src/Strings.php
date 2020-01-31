<?php

namespace queasy\helper;

class Strings
{
    private static $ENCODING_BOMS = array(
        "\x00\x00\xFE\xFF" => 'UTF-32BE',
        "\xFF\xFE\x00\x00" => 'UTF-32LE',
        "\xFE\xFF" => 'UTF-16BE',
        "\xFF\xFE" => 'UTF-16LE',
        "\xEF\xBB\xBF" => 'UTF-8'
    );

    public static function startsWith($string, $start)
    {
        return strpos($string, $start) === 0;
    }

    public static function endsWith($string, $end)
    {
        return strpos($string, $end) == strlen($string) - strlen($end);
    }

    public static function encoding($text)
    {
        $result = mb_detect_encoding($text);
        if (false === $result) {
            foreach (static::$ENCODING_BOMS as $bom => $encoding) {
                if (self::startsWith($text, $bom)) {
                    $result = $encoding;

                    break;
                }
            }
        }

        return $result;
    }

    public static function encode($text, $encoding = 'UTF-8')
    {
        return mb_convert_encoding($text, $encoding, self::encoding($text));
    }
}

