<?php
session_start();

require 'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;

function htmltable()
{
    global $currency;
    global $currency_place;
    global $export_whitespace;
    global $total;
    global $data_array_final;

    $html_data = '
                <table id="table">
                <tr>
                <th>#</th>
                <th>Item</th>
                <th>Price</th>
                </tr>';
    $i = 1;

    foreach($data_array_final as $key => $item_price) {
        $item_price_array = explode(":-:ITEM:-:", $item_price);
        if(isset($item_price_array[0])) {
            $item = $item_price_array[0];
        } else $item = '';

        if(isset($item_price_array[1])) {
            $price = $item_price_array[1];
        } else $price = '';

        if($item == '' && $price == '') continue;

        $html_data .= '<tr>
<td>' . $i . '</td>
<td>' . $item . '</td>';

        if($currency_place == "currency_before") {
            $html_data .= '<td>' . $currency . $export_whitespace . $price . '</td>';
        } else if($currency_place == "currency_after") {
            $html_data .= '<td>' . $price . $export_whitespace . $currency . '</td>';
        }

        $html_data .= '</tr>';
        $i++;
    }

    $html_data .= '<tr><td colspan="3"><hr style="height: 1px; color: #000;" size="1" /></td></tr>';
    $html_data .= '<tr>
<td></td>
<td><strong>Total</strong></td>';
    if($currency_place == "currency_before") {
        $html_data .= '<td><strong>' . $currency . $export_whitespace . $total . '</strong></td>';
    } else if($currency_place == "currency_after") {
        $html_data .= '<td><strong>' . $total . $export_whitespace . $currency . '</strong></td>';
    }
    $html_data .= '
</tr>';
    $html_data .= '</table>
                ';
    return $html_data;
}

if(isset($_POST['token'], $_SESSION['token'], $_SESSION['token_time'])) {
    if($_POST['token'] == $_SESSION['token'])
    {
        if(isset($_POST["currency"], $_POST["currency_place"], $_POST["item"], $_POST["price"], $_POST["total"], $_POST["export"], $_POST["export_whitespace"])) {
            $items_count = count($_POST["item"]);
            $price_count = count($_POST["price"]);
            $currency_place = htmlentities($_POST["currency_place"]);

            if(str_replace(" ", "", $_POST["custom_currency"]) != "") {
                $currency = htmlentities($_POST["custom_currency"]);
            }
            else $currency = htmlentities($_POST["currency"]);

            if($_POST["export_whitespace"] == "yes") {
                $export_whitespace = ' ';
            } else if($_POST["export_whitespace"] == "no") {
                $export_whitespace = '';
            } else $export_whitespace = ' ';

            $total = htmlentities($_POST["total"]);

            if($items_count == $price_count) {
                $data_array = array();

                foreach($_POST["item"] as $key => $item) {
                    $data_array[] = $item . ":-:ITEM:-:" . $_POST["price"][$key];
                }
                $data_array_final = $data_array;
                switch ($_POST["export"]) {
                    case "pdf":
                        $html_data = '';
                        $html_data .= '<style type="text/css">
                            #table {
                                border-collapse: collapse;
                            }
                            #table td, #table th {
                                padding: 5px 20px;
                                text-align: left;
                            }
        </style>';
                        $html_data .= htmltable();

                        try
                        {
                            $html2pdf = new Html2Pdf('P', 'A4', 'en');

                            $html2pdf->setDefaultFont('Arial');
                            $html2pdf->writeHTML($html_data, isset($_GET['vuehtml']));
                            $html2pdf->Output('ShoppingCalculations_'.date('Y-m-d').'_'.time().'.pdf', 'D');
                        }
                        catch(Html2PdfException $e) {
                            echo $e;
                            exit;
                        }
                        break;

                    case "html":
                        header('Content-Type: text/html; charset=utf-8');
                        header('Content-Disposition: attachment; filename=ShoppingCalculations_'.date('Y-m-d').'_'.time().'.html');
                        $output = fopen('php://output', 'w');

                        $html_data = '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <title>Shopping Calculations</title>
                            <meta charset="utf-8">
                            <style type="text/css">
                            #table {
                                border-collapse: collapse;
                            }
                            #table td, #table th {
                                padding: 5px 20px;
                                text-align: left;
                            }
        </style>
                        </head>
                        <body>';

                        $html_data .= htmltable();

                        $html_data .= '</body>
                        </html>';
                        echo $html_data;
                        break;

                    case "csv":
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename=ShoppingCalculations_'.date('Y-m-d').'_'.time().'.csv');
                        $output = fopen('php://output', 'w');

                        if($currency_place == "currency_before") {
                            fputcsv($output, array('#', 'Item', 'Currency', 'Price'));
                        } else if($currency_place == "currency_after") {
                            fputcsv($output, array('#', 'Item', 'Price', 'Currency'));
                        }

                        $i = 1;
                        foreach($data_array_final as $key => $item_price) {
                            $item_price_array = explode(":-:ITEM:-:", $item_price);
                            if(isset($item_price_array[0])) {
                                $item = $item_price_array[0];
                            } else $item = '';

                            if(isset($item_price_array[1])) {
                                $price = $item_price_array[1];
                            } else $price = '';

                            if($item == '' && $price == '') continue;

                            if($currency_place == "currency_before") {
                                fputcsv($output, array($i, $item, $currency, $price));
                            } else if($currency_place == "currency_after") {
                                fputcsv($output, array($i, $item, $price, $currency));
                            }
                            $i++;
                        }

                        fputcsv($output, array('', '', '', ''));
                        if($currency_place == "currency_before") {
                            fputcsv($output, array('', 'Total', $currency, $total));
                        } else if($currency_place == "currency_after") {
                            fputcsv($output, array('', 'Total', $total, $currency));
                        }
                        break;

                    default:
                        break;
                }
            }
        }
    }
}
