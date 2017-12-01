<?php
session_start();

if (!isset($_SESSION['token'])) {
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
}
else
{
    $token = $_SESSION['token'];
}

$currencies = array(
    'USD' => 'United States Dollar ',
    'EUR' => 'Euro Member Countries ',
    'GBP' => 'United Kingdom Pound ',
    'AUD' => 'Australia Dollar ',
    'CAD' => 'Canada Dollar ',
    'CHF' => 'Switzerland Franc ',
    'JPY' => 'Japan Yen ',
    'AED' => 'United Arab Emirates Dirham ',
    'AFN' => 'Afghanistan Afghani ',
    'ALL' => 'Albania Lek ',
    'AMD' => 'Armenia Dram ',
    'ANG' => 'Netherlands Antilles Guilder ',
    'AOA' => 'Angola Kwanza ',
    'ARS' => 'Argentina Peso ',
    'AWG' => 'Aruba Guilder ',
    'AZN' => 'Azerbaijan New Manat ',
    'BAM' => 'Bosnia and Herzegovina Convertible Marka ',
    'BBD' => 'Barbados Dollar ',
    'BDT' => 'Bangladesh Taka ',
    'BGN' => 'Bulgaria Lev ',
    'BHD' => 'Bahrain Dinar ',
    'BIF' => 'Burundi Franc ',
    'BMD' => 'Bermuda Dollar ',
    'BND' => 'Brunei Darussalam Dollar ',
    'BOB' => 'Bolivia Bolíviano ',
    'BRL' => 'Brazil Real ',
    'BSD' => 'Bahamas Dollar ',
    'BTN' => 'Bhutan Ngultrum ',
    'BWP' => 'Botswana Pula ',
    'BYR' => 'Belarus Ruble ',
    'BZD' => 'Belize Dollar ',
    'CDF' => 'Congo/Kinshasa Franc ',
    'CLP' => 'Chile Peso ',
    'CNY' => 'China Yuan Renminbi ',
    'COP' => 'Colombia Peso ',
    'CRC' => 'Costa Rica Colon ',
    'CUC' => 'Cuba Convertible Peso ',
    'CUP' => 'Cuba Peso ',
    'CVE' => 'Cape Verde Escudo ',
    'CZK' => 'Czech Republic Koruna ',
    'DJF' => 'Djibouti Franc ',
    'DKK' => 'Denmark Krone ',
    'DOP' => 'Dominican Republic Peso ',
    'DZD' => 'Algeria Dinar ',
    'EGP' => 'Egypt Pound ',
    'ERN' => 'Eritrea Nakfa ',
    'ETB' => 'Ethiopia Birr ',
    'FJD' => 'Fiji Dollar ',
    'FKP' => 'Falkland Islands (Malvinas) Pound ',
    'GEL' => 'Georgia Lari ',
    'GGP' => 'Guernsey Pound ',
    'GHS' => 'Ghana Cedi ',
    'GIP' => 'Gibraltar Pound ',
    'GMD' => 'Gambia Dalasi ',
    'GNF' => 'Guinea Franc ',
    'GTQ' => 'Guatemala Quetzal ',
    'GYD' => 'Guyana Dollar ',
    'HKD' => 'Hong Kong Dollar ',
    'HNL' => 'Honduras Lempira ',
    'HRK' => 'Croatia Kuna ',
    'HTG' => 'Haiti Gourde ',
    'HUF' => 'Hungary Forint ',
    'IDR' => 'Indonesia Rupiah ',
    'ILS' => 'Israel Shekel ',
    'IMP' => 'Isle of Man Pound ',
    'INR' => 'India Rupee ',
    'IQD' => 'Iraq Dinar ',
    'IRR' => 'Iran Rial ',
    'ISK' => 'Iceland Krona ',
    'JEP' => 'Jersey Pound ',
    'JMD' => 'Jamaica Dollar ',
    'JOD' => 'Jordan Dinar ',
    'KES' => 'Kenya Shilling ',
    'KGS' => 'Kyrgyzstan Som ',
    'KHR' => 'Cambodia Riel ',
    'KMF' => 'Comoros Franc ',
    'KPW' => 'Korea (North) Won ',
    'KRW' => 'Korea (South) Won ',
    'KWD' => 'Kuwait Dinar ',
    'KYD' => 'Cayman Islands Dollar ',
    'KZT' => 'Kazakhstan Tenge ',
    'LAK' => 'Laos Kip ',
    'LBP' => 'Lebanon Pound ',
    'LKR' => 'Sri Lanka Rupee ',
    'LRD' => 'Liberia Dollar ',
    'LSL' => 'Lesotho Loti ',
    'LYD' => 'Libya Dinar ',
    'MAD' => 'Morocco Dirham ',
    'MDL' => 'Moldova Leu ',
    'MGA' => 'Madagascar Ariary ',
    'MKD' => 'Macedonia Denar ',
    'MMK' => 'Myanmar (Burma) Kyat ',
    'MNT' => 'Mongolia Tughrik ',
    'MOP' => 'Macau Pataca ',
    'MRO' => 'Mauritania Ouguiya ',
    'MUR' => 'Mauritius Rupee ',
    'MVR' => 'Maldives (Maldive Islands) Rufiyaa ',
    'MWK' => 'Malawi Kwacha ',
    'MXN' => 'Mexico Peso ',
    'MYR' => 'Malaysia Ringgit ',
    'MZN' => 'Mozambique Metical ',
    'NAD' => 'Namibia Dollar ',
    'NGN' => 'Nigeria Naira ',
    'NIO' => 'Nicaragua Cordoba ',
    'NOK' => 'Norway Krone ',
    'NPR' => 'Nepal Rupee ',
    'NZD' => 'New Zealand Dollar ',
    'OMR' => 'Oman Rial ',
    'PAB' => 'Panama Balboa ',
    'PEN' => 'Peru Sol ',
    'PGK' => 'Papua New Guinea Kina ',
    'PHP' => 'Philippines Peso ',
    'PKR' => 'Pakistan Rupee ',
    'PLN' => 'Poland Zloty ',
    'PYG' => 'Paraguay Guarani ',
    'QAR' => 'Qatar Riyal ',
    'RON' => 'Romania New Leu ',
    'RSD' => 'Serbia Dinar ',
    'RUB' => 'Russia Ruble ',
    'RWF' => 'Rwanda Franc ',
    'SAR' => 'Saudi Arabia Riyal ',
    'SBD' => 'Solomon Islands Dollar ',
    'SCR' => 'Seychelles Rupee ',
    'SDG' => 'Sudan Pound ',
    'SEK' => 'Sweden Krona ',
    'SGD' => 'Singapore Dollar ',
    'SHP' => 'Saint Helena Pound ',
    'SLL' => 'Sierra Leone Leone ',
    'SOS' => 'Somalia Shilling ',
    'SPL*' => 'Seborga Luigino ',
    'SRD' => 'Suriname Dollar ',
    'STD' => 'São Tomé and Príncipe Dobra ',
    'SVC' => 'El Salvador Colon ',
    'SYP' => 'Syria Pound ',
    'SZL' => 'Swaziland Lilangeni ',
    'THB' => 'Thailand Baht ',
    'TJS' => 'Tajikistan Somoni ',
    'TMT' => 'Turkmenistan Manat ',
    'TND' => 'Tunisia Dinar ',
    'TOP' => 'Tonga Pa\'anga ',
    'TRY' => 'Turkey Lira ',
    'TTD' => 'Trinidad and Tobago Dollar ',
    'TVD' => 'Tuvalu Dollar ',
    'TWD' => 'Taiwan New Dollar ',
    'TZS' => 'Tanzania Shilling ',
    'UAH' => 'Ukraine Hryvnia ',
    'UGX' => 'Uganda Shilling ',
    'UYU' => 'Uruguay Peso ',
    'UZS' => 'Uzbekistan Som ',
    'VEF' => 'Venezuela Bolivar ',
    'VND' => 'Viet Nam Dong ',
    'VUV' => 'Vanuatu Vatu ',
    'WST' => 'Samoa Tala ',
    'XAF' => 'Communauté Financière Africaine (BEAC) CFA Franc BEAC ',
    'XCD' => 'East Caribbean Dollar ',
    'XDR' => 'International Monetary Fund (IMF) Special Drawing Rights ',
    'XOF' => 'Communauté Financière Africaine (BCEAO) Franc ',
    'XPF' => 'Comptoirs Français du Pacifique (CFP) Franc ',
    'YER' => 'Yemen Rial ',
    'ZAR' => 'South Africa Rand ',
    'ZMW' => 'Zambia Kwacha ',
    'ZWD' => 'Zimbabwe Dollar',
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Calculator</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/calculator.png">
</head>

<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><h3>Utility / Shopping / Invoice Calculator</h3></div>
        <div class="panel-body">
            <form method="post" id="calcForm" action="export.php" target="_blank">
                <div class="form-group">
                    <p>Select</p>
                    <label for="currency">Amount Currency</label>
                    <select name="currency" id="currency" class="form-control">
                        <option value="">* Please select *</option>
                        <?php foreach($currencies as $code => $name) { ?>
                            <option value="<?php echo $code; ?>"><?php echo $name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <p>or use</p>
                    <label for="custom_currency">Custom Currency *</label>
                    <input type="text" name="custom_currency" id="custom_currency" class="form-control" placeholder="Custom currency - e.g. $ instead of USD, &euro; instead of EUR etc." /><br />
                    * If you enter custom currency it will overwrite the selected currency in dropdown menu above.   <br />
                    Click <input type="button" class="btn btn-danger" id="clear_custom_currency" value="clear custom currency" /> to clear custom currency field input.
                </div>
                <hr/>
                <div class="form-group">
                    <strong>Currency Position</strong><br />
                    <input type="radio" name="currency_place" class="currency_place" value="currency_before" checked /> Show the currency before amount (e.g. USD 100)<br />
                    <input type="radio" name="currency_place" class="currency_place" value="currency_after" /> Show the currency after amount (e.g. 100 USD)
                </div>
                <hr/>
                <strong>Items & prices</strong>
                <br /> <br />
                <input type="button" class="btn btn-primary btn-lg" id="add_item" value="Add Item" />
                <br /> <br />
                <div id="items">
                    <div class="row item">
                        <div class="col-md-8"><input type="text" class="form-control" name="item[]" placeholder="Item Description - e.g. Utility Bills" /></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon currency c_before"></span>
                                <input type="text" class="form-control price" name="price[]" placeholder="Price">
                                <span class="input-group-addon currency c_after"></span>
                            </div>
                        </div>
                        <div class="col-md-1"><img src="images/remove.png" width="32" height="32" class="delete_item" alt="Remove Item" title="Remove Item" /></div>
                    </div>
                    <div class="row item">
                        <div class="col-md-8"><input type="text" class="form-control" name="item[]" placeholder="Item Description - e.g. Groceries" /></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon currency c_before"></span>
                                <input type="text" class="form-control price" name="price[]" placeholder="Price">
                                <span class="input-group-addon currency c_after"></span>
                            </div>
                        </div>
                        <div class="col-md-1"><img src="images/remove.png" width="32" height="32" class="delete_item" alt="Remove Item" title="Remove Item" /></div>
                    </div>
                    <div class="row item">
                        <div class="col-md-8"><input type="text" class="form-control" name="item[]" placeholder="Item Description - e.g. Online Shopping" /></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon currency c_before"></span>
                                <input type="text" class="form-control price" name="price[]" placeholder="Price">
                                <span class="input-group-addon currency c_after"></span>
                            </div>
                        </div>
                        <div class="col-md-1"><img src="images/remove.png" width="32" height="32" class="delete_item" alt="Remove Item" title="Remove Item" /></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 text-right" style="margin-top: 5px;"><strong>Total</strong></div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon currency c_before"></span>
                            <input type="text" class="form-control" name="total" id="total" readonly placeholder="Total">
                            <span class="input-group-addon currency c_after"></span>
                        </div>
                    </div>
                    <div class="col-md-1"><img src="images/wallet.png" width="32" height="32" alt="Total Cost" title="Total Cost" /></div>
                </div>
                <hr/>
                <div class="row text-center">
                    <strong>Export to PDF | HTML | CSV</strong><br /><br />
                    <div>
                        <p>Whitespace before/after currency? (applies to PDF and HTML)</p>
                        <p><input type="radio" name="export_whitespace" value="yes" checked /> Yes (e.g. USD 100, 100 USD etc.) <input type="radio" name="export_whitespace" value="no" /> No (e.g. USD100, 100USD etc.)</p>
                    </div>

                    <img src="images/pdf.png" alt="Export to PDF" title="Export to PDF" class="export" id="pdf" /> <img src="images/html.png" alt="Export to HTML" title="Export to HTML" class="export" id="html" /> <img src="images/csv.png" alt="Export to CSV" title="Export to CSV" class="export" id="csv" />
                </div>
                <input type="hidden" name="export" id="export" value="" />
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
            </form>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.numeric.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
