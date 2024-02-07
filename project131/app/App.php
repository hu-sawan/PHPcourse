<?php

declare(strict_types = 1);

// Your Code
function getAllTransactionFiles(string $dir): array {
    $files = [];

    foreach(scandir($dir) as $file) {
        if(is_dir($file))
            continue;

        $files[] = $dir . $file;
    }

    return $files;
}

function getTransactionFromFile(string $fileName, ?callable $parsingMethod = null): array {
    if(! file_exists($fileName)) trigger_error('The File "'.$fileName.'" is not found', E_USER_ERROR);

    // opens the file (we guarantee it exists)
    $file = fopen($fileName, 'r');

    // discard first line since it contains headers (suppose it's always like this)
    fgetcsv($file);

    $transactions = [];

    while(($row = fgetcsv($file)) !== false) {
        if($parsingMethod !== null) {
            $transactions[] = $parsingMethod($row);

            continue;
        }

        $transactions[] = $row;
    }

    return $transactions;
}

function parseRow(array $fileRow): array {
    [$date, $check, $description, $amount] = $fileRow;

    $amount = (float) str_replace(['$', ','], '', $amount);

    return [
        'date' => $date,
        'check' => $check,
        'description' => $description,
        'amount' => $amount,
    ];
}

function calculateTotals(array $transactions): array {
    $totals = ['income' => 0, 'expenses' => 0, 'net' => 0];

    foreach($transactions as $transaction) {
        $totals['net'] += $transaction['amount'];
        if($transaction['amount'] < 0) {
            $totals['expenses'] += $transaction['amount'];
        } else {
            $totals['income'] += $transaction['amount'];
        }
    }

    return $totals;
}