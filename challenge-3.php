<?php
function getFormattedDate(): string
{
    $jsonResponse = file_get_contents('http://date.jsontest.com/');

    $data = json_decode($jsonResponse, true);

    $epoch = $data['milliseconds_since_epoch'] / 1000;
    $date = new DateTime("@$epoch");

    // Format: Monday 14th of August, 2023 - 06:47 PM
    return $date->format('l jS \of F, Y - h:i A');
}

// Print result
echo getFormattedDate();