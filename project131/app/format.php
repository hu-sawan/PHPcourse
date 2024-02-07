<?php
    declare(strict_types=1);
    
    function formatAmount(int|float $amount): string {
        return (($amount < 0) ? '-' : '').'$'.number_format(abs($amount), 1);
    }

    function formatDate(string $date): string {
        $dateCreated = date_create($date);
        return date_format($dateCreated, 'M d, y');
    }
?>