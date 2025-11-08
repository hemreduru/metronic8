<?php

if (!function_exists('tr2en')) {
    /**
     * Convert Turkish characters to English equivalents
     *
     * @param string $text
     * @return string
     */
    function tr2en($text)
    {
        $turkishChars = [
            'ç' => 'c',
            'Ç' => 'C',
            'ğ' => 'g',
            'Ğ' => 'G',
            'ı' => 'i',
            'İ' => 'i', // İ -> i olarak değiştir
            'ö' => 'o',
            'Ö' => 'O',
            'ş' => 's',
            'Ş' => 'S',
            'ü' => 'u',
            'Ü' => 'U',
        ];

        // Replace Turkish characters
        $text = str_replace(array_keys($turkishChars), array_values($turkishChars), $text);

        // Remove special characters except letters, numbers and space
        $text = preg_replace('/[^\w\s]/u', '', $text);

        // Convert to lowercase
        $text = strtolower($text);

        // Replace spaces with empty string or underscore if needed
        $text = str_replace(' ', '', $text);

        return $text;
    }
}

if (!function_exists('generateUsername')) {
    /**
     * Generate username from first name and last name
     *
     * @param string $name Full name
     * @return string
     */
    function generateUsername($name)
    {
        if (empty($name) || !is_string($name)) {
            return 'user' . time();
        }

        $nameParts = explode(' ', trim($name));

        if (count($nameParts) >= 2) {
            // First convert Turkish chars, then get first letter
            $firstName = tr2en($nameParts[0]);
            $lastName = tr2en($nameParts[count($nameParts) - 1]);
            $username = substr($firstName, 0, 1) . $lastName;
        } else {
            // If only one name part, use the whole name
            $username = tr2en($nameParts[0]);
        }

        // Ensure it's not empty
        if (empty($username)) {
            $username = 'user' . time();
        }

        return $username;
    }
}
