<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            span.profit {
                color: green;
            }

            span.loss {
                color: red;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if(! empty($transactions)): ?>
                    <?php foreach($transactions as $transaction): ?>
                        <tr>
                            <td><?= formatDate($transaction['date']) ?></td>
                            <td><?= $transaction['check'] ?></td>
                            <td><?= $transaction['description'] ?></td>
                            <td>
                                <?php 
                                    $amount = $transaction['amount'];
                                    $class = ($amount < 0) ? 'loss' : 'profit';
                                    
                                    echo "<span class='$class'>".formatAmount($amount).'</span>'; 
                                ?>
                                </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <?= formatAmount($total['income']) ?? 0 ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?= formatAmount($total['expenses']) ?? 0 ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?= formatAmount($total['net']) ?? 0 ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>


