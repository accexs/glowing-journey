<?php

function parseResponses(string $wantedValue, array $arr): array
{
    $result = [];
    foreach ($arr as $name => $value) {
        if ($value === $wantedValue) {
            $result[] = $name;
        }
    }

    return $result;
}

function printList(array $yResponseList, array $nResponseList): void
{
    $maxNameLength = max(array_map('strlen',
      array_merge($yResponseList, $nResponseList)));

    // Print the names in two columns
    foreach (array_map(null, $nResponseList,
      $yResponseList) as [$noResponse, $yesResponse]) {
        printf("%-{$maxNameLength}s\t%s\n", $noResponse ?? '',
          $yesResponse ?? '');
    }
}

function getResponses(): void
{
    $jsonResponse = file_get_contents('http://echo.jsontest.com/john/yes/tomas/no/belen/yes/peter/no/julie/no/gabriela/no/messi/no');
    $data = json_decode($jsonResponse, true);
    $yResponseList = parseResponses('yes', $data);
    $nResponseList = parseResponses('no', $data);

    printList($yResponseList, $nResponseList);
}

getResponses();