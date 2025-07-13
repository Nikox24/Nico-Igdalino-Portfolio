<?php
// 🔢 Visit counter file
$counterFile = 'visits.txt';

// Create visits.txt if not exists
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, '0');
}

// Read + increment counter
$count = (int)file_get_contents($counterFile);
$count++;
file_put_contents($counterFile, $count);

// 📌 Visitor details
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');

// 🌍 IP Geolocation via ipapi
$locationData = @json_decode(file_get_contents("https://ipapi.co/{$ip}/json/"), true);

$city = $locationData['city'] ?? 'Unknown';
$region = $locationData['region'] ?? 'Unknown';
$country = $locationData['country_name'] ?? 'Unknown';
$org = $locationData['org'] ?? 'Unknown';
$asn = $locationData['asn'] ?? 'N/A';
$timezone = $locationData['timezone'] ?? 'N/A';

// 🛡️ Telegram config
$botToken = '7708928004:AAESpODTC67fouiwFpneucU1QR2qRa_dmYk';
$chatId   = '7843509294';

// ✉️ Compose message
$message = urlencode(
"👀 *New Visitor Detected!*

🕒 Time: `$date`
🌐 IP: `$ip`
🏙️ Location: $city, $region, $country
🏢 ISP: $org
🔢 ASN: $asn
🕰️ Timezone: $timezone
📊 Total Visits: *$count*"
);

// 🚀 Send to Telegram
file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message&parse_mode=Markdown");

// 🖥️ Output count for frontend
echo $count;
?>
