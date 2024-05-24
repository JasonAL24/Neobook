<?php

namespace App\Traits;

trait SearchableByName
{
    public static function searchByName($query)
    {
        $items = self::all();
        $results = [];

        foreach ($items as $item) {
            if (self::kmpSearch($query, $item->name)) {
                $results[] = $item;
            }
        }

        return $results;
    }

    private static function kmpSearch($needle, $haystack)
    {
        $needle = strtolower($needle);
        $haystack = strtolower($haystack);

        $needleLength = strlen($needle);
        $haystackLength = strlen($haystack);
        $lps = self::computeLPSArray($needle);

        $i = 0; // Index for haystack
        $j = 0; // Index for needle

        while ($i < $haystackLength) {
            if ($needle[$j] == $haystack[$i]) {
                $i++;
                $j++;
            }

            if ($j == $needleLength) {
                return true; // Needle found in haystack
            } elseif ($i < $haystackLength && $needle[$j] != $haystack[$i]) {
                if ($j != 0) {
                    $j = $lps[$j - 1];
                } else {
                    $i++;
                }
            }
        }

        return false; // Needle not found in haystack
    }

    private static function computeLPSArray($needle)
    {
        $length = strlen($needle);
        $lps = [];
        $lps[0] = 0; // First element is always 0
        $len = 0; // Length of the previous longest prefix suffix

        $i = 1;
        while ($i < $length) {
            if ($needle[$i] == $needle[$len]) {
                $len++;
                $lps[$i] = $len;
                $i++;
            } else {
                if ($len != 0) {
                    $len = $lps[$len - 1];
                } else {
                    $lps[$i] = 0;
                    $i++;
                }
            }
        }

        return $lps;
    }
}