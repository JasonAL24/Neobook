<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    protected $fillable = [
        "name", "author", "editor", "language", "publisher", "paper_type",
        "ISBN", "description", "image", "type", "rating", "last_rating_date",
        "last_rating_desc"
    ];
    protected $guarded = ['id'];

    public static function searchByName($query)
    {
        $books = self::all();
        $results = [];

        foreach ($books as $book) {
            if (self::kmpSearch($query, $book->name)) {
                $results[] = $book;
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
