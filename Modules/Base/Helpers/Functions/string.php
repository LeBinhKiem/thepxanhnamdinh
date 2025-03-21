<?php
if (!function_exists('limit_text')) {
    function limit_text($text, $limit = 20)
    {
        $text = \Illuminate\Support\Str::limit($text, $limit);
        return $text;
    }
}
if (!function_exists('number_to_letters')) {
    function number_to_letters($number) {
        if ($number >= 1 && $number <= 26) {
            $letter = chr($number + 64);
            return $letter;
        } else {
            return 'Invalid number';
        }
    }
}

if (!function_exists('create_date_by_month_year')) {
    function create_date_by_month_year($year, $month)
    {
        return \Illuminate\Support\Carbon::create($year, $month);
    }
}


if (!function_exists('calculate_time')) {
    function calculate_time($time)
    {
        $carbon = \Illuminate\Support\Carbon::parse($time);
        if ($carbon->diffInSeconds() < 60) {
            return 'vừa xong';
        }
        $timeString = str_replace("tới", "trước", $carbon->diffForHumans());

        return $timeString;
    }
}
if (!function_exists('calculate_time_for_read')) {
    function calculate_time_for_read($content)
    {
        $wordCount     = str_word_count($content);
        $readingSecond = ceil($wordCount / 5);

        if ($readingSecond <= 60) {
            $time = $readingSecond . " giây";
        } else {
            $time = ceil($readingSecond / 60) . " phút";
        }

        return $time;
    }
}

