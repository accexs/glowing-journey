<?php

class LetterCounter
{

    public static function CountLettersAsString($string): string
    {
        // Convert the string to lowercase for case insensitivity
        $string = strtolower($string);

        // Initialize an array to store letter counts
        $letterCounts = [];

        // Iterate through each character in the string
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];

            // Increment the count of the current letter
            if (isset($letterCounts[$char])) {
                $letterCounts[$char]++;
            } else {
                $letterCounts[$char] = 1;
            }
        }

        // Construct the result string
        $result = '';
        foreach ($letterCounts as $letter => $count) {
            $asterisks = self::getAsterisks($count);
            $result .= "$letter:$asterisks,";
        }

         return rtrim($result, ',');
    }

    private static function getAsterisks(int $count): string
    {
        $asterisks = '';
        for ($i = 0; $i < $count; $i++) {
            $asterisks = $asterisks.'*';
        }
        return $asterisks;
    }
}

// Example usage:
echo LetterCounter::CountLettersAsString("Interview");
echo "\n";
echo LetterCounter::CountLettersAsString("AaaEeC");
