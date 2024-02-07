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

            table tr td.profit {
                color: green;
            }

            table tr td.loss {
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
                <?php
                    $filename = '../transaction_files/sample_1.csv';
                    $profit = [];
                    $loss = [];

                    function removeDollarSign(string $str): float {
                        $res = "";
                        $len = strlen($str);

                        for($i = 0; $i < $len; $i++) {
                            if($str[$i] !== '$' && $str[$i] !== ',')
                                $res .= $str[$i];
                        }

                        return (float) $res;
                    }
                    if(file_exists($filename)) {
                        $file = fopen($filename, 'r');

                        while(($arr = fgetcsv($file)) !== false) {
                            if($arr[0] === "Date")
                                continue;
                            $class;

                            $numberRepresentation = removeDollarSign($arr[3]);

                            if($numberRepresentation >= 0) {
                                $class = 'profit';
                                array_push($profit, $numberRepresentation);
                            } else {
                                $class = 'loss';
                                array_push($loss, $numberRepresentation * -1);
                            }

                            $tag = <<< TEXT
                            <tr>
                                <td>{$arr[0]}</td>
                                <td>{$arr[1]}</td>
                                <td>{$arr[2]}</td>
                                <td class="$class">{$arr[3]}</td>
                            </tr>
                            TEXT;

                            echo $tag;

                            $total = array_sum($profit);
                            $expenses = array_sum($loss);
                        }
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <?= '$'.$total ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?= "-$".$expenses ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?php
                            $net = $total - $expenses;

                            echo (($net < 0) ? '-$' : '$').$net;
                            
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>


