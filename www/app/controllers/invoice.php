<?php
require_once 'app/vendor/autoload.php';


use Dompdf\Dompdf;
use Dompdf\Options;

$id;

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Invoice.model.php";

    $invoice = Invoice::get_by_id_with_client($id);

    $invoice = $invoice[0];

    include "app/models/Setting.model.php";

    $setting = Setting::get_setting();
}else{
    echo 'No ID passed';
    exit();
}

function formatNumber($number)
{
    return number_format($number, 2, '.', ',');
}



$type = pathinfo('./assets/Images/logo.jpg', PATHINFO_EXTENSION);
$data = file_get_contents('./assets/Images/logo.jpg');
$logo = 'data:image/' . $type . ';base64,' . base64_encode($data);

$type = pathinfo('./assets/Images/lens.jpg', PATHINFO_EXTENSION);
$data = file_get_contents('./assets/Images/lens.jpg');
$lens = 'data:image/' . $type . ';base64,' . base64_encode($data);

$font = base64_encode(file_get_contents('./assets/Reem.ttf'));

$css = file_get_contents('assets/css/invoice2.css');

$html = file_get_contents('app/views/invoice.html');

$html = str_replace('@@logo', $logo, $html);
$html = str_replace('@@lens', $lens, $html);
$html = str_replace('/*@@css*/', $css, $html);
$html = str_replace('@@address', $setting['Address'], $html);
$html = str_replace('@@email', $setting['Email'], $html);
$html = str_replace('@@tel', $setting['Tel'], $html);

$html = str_replace('@@client', $invoice['Invoice_name'], $html);
$html = str_replace('@@c_email', $invoice['Email'], $html);
$html = str_replace('@@c_tel', $invoice['Phone'], $html);
$html = str_replace('@@id', $id, $html);
$html = str_replace('@@date', date("j F Y"), $html);
$html = str_replace('@@balance', $invoice['balance'], $html);


$items = Json_decode($invoice['Items']);

$i = 1;
$subTotal = 0;
$itemTable = "";

foreach ($items as $item) {
    $itemTable .= '
        <tr>
            <td>'. $item->name .'</td>
            <td>'.$item->description .'
            </td>
            <td>
                '.formatNumber($item->unitCost) . ' LKR
            </td>
            <td>'. $item->quantity .'</td>
            <td>'. formatNumber($item->unitCost * $item->quantity) . ' LKR</td>

        </tr>';

    
        $i++;
        $subTotal += $item->unitCost * $item->quantity;
}

$html = str_replace('@@itemTable', $itemTable, $html);
$html = str_replace('@@terms', $invoice['Terms'], $html);
$html = str_replace('@@subTotal', formatNumber($subTotal), $html);

$discount = "";
if ($invoice['discount'] > 0) {
    $discount = '<tr>
    <td>Discount</td>
    <td> '.formatNumber(floatval($invoice['discount'])) . ' LKR</td>
</tr>';
}

$html = str_replace('@@Discount', $discount, $html);

$payments = Json_decode($invoice['payments']);

$paid = "";
$totalPayment = 0;

foreach ($payments as $payment) {

    $paid .= '
    <tr>
        <td>'. $payment->name .' ('. date("j F Y", strtotime($payment->date)) . '): </td>
        <td>'. formatNumber(floatval($payment->amount)) . ' LKR</td>
    </tr>

    ';

    $totalPayment += $payment->amount;
}




$html = str_replace('@@Paid', $paid, $html);





$options = new Options();

$tmp = sys_get_temp_dir();

$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('fontDir', $tmp);
$options->set('fontCache', $tmp);
$options->set('tempDir', $tmp);
$options->set('chroot', $tmp);
$options->set('fontHeightRatio', 1.0); // Adjust font height ratio if needed

// Include base64-encoded font data
$fontData = [
    'Reem Kufi' => [
        'R' => $font, // Replace with the path to your TTF font file
        'useOTL' => 0xFF,
        'useKashida' => 75,
    ],
];

$options->set('fontMetrics', $fontData);

// Create Dompdf instance with options
$dompdf = new Dompdf($options);

$dompdf->add_info('Title', 'Invoice SP ' . $id);
$dompdf->add_info('Author', 'Sparkling Pixels');
$dompdf->add_info('Creator', 'Anushka Lakshan');


$dompdf->loadHtml($html); //load an html

$dompdf->render();


// // Get PDF content
$pdf_content = $dompdf->output();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <title>Invoice <?php echo $id; ?></title>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-dark bg-dark">
            <h1 class="navbar-brand">Sparkling Pixels Invoice System</h1>
            <a href="<?= BASE_URL ?>/pdf?id=<?= $id ?>" class="btn btn-primary" target="_blank">Download</a>
            <a href="/<?= BASE_URL ?>?page=viewInvoice&id=<?= $id ?>" class="btn btn-danger">Back</a>
        </nav>
        <!-- <iframe src="<?= BASE_URL ?>/pdf?id=<?= $id ?>" width="100%" height="1000px"></iframe> -->
        <iframe src="data:application/pdf;base64,<?php echo base64_encode($pdf_content); ?>" width="100%" height="1100px"></iframe>
    </div>
    <!-- Display PDF in iframe -->


</body>

</html>