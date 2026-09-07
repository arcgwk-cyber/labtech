<?php
// whatsapp_redirect.php
$phone = isset($_GET['phone']) ? preg_replace('/\D/', '', $_GET['phone']) : '';
$name = isset($_GET['name']) ? urldecode($_GET['name']) : 'Patient';
$bill_id = isset($_GET['bill_id']) ? (int)$_GET['bill_id'] : 0;

if (!$phone || !$bill_id) {
    die("Invalid input.");
}

$message = "Hello $name, your report is ready ✅. You can download it from our portal.";
$encodedMessage = urlencode($message);
$whatsappLink = "https://wa.me/91$phone?text=$encodedMessage";
$redirectUrl = "pdf_options.php?bill_id={$bill_id}&saved=1";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sending WhatsApp Message...</title>
    <script>
        window.onload = function () {
            // Open WhatsApp link in a new tab
            window.open("<?= $whatsappLink ?>", "_blank");

            // Then redirect to PDF options
            setTimeout(function () {
                window.location.href = "<?= $redirectUrl ?>";
            }, 1000);
        }
    </script>
</head>
<body>
    <p>Sending WhatsApp message... Please wait.</p>
</body>
</html>
