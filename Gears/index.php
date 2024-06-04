<?php

$json = '../json/%s';
$gearData = sprintf($json, 'GearData.json');
$content = null;

//Finding first instance of number
$uri = $_SERVER['REQUEST_URI'];
preg_match('/\/(\d+)/', $uri, $matches);
$number = $matches[1];

if ($number) {
    $jsonData = file_get_contents($gearData);
    $data = json_decode($jsonData, true);

    // Check if the number exists in the JSON data
    $found = false;
    foreach ($data as $item) {
        if ($item['id'] == $number) {
            $found = true;
            $name = $item['name'];
            $scripts = $item['scripts'];
            $content = "";
            foreach ($scripts as $script) {
                $scriptName = $script['scriptName'];
                $scriptSource = $script['scriptSource'];
                $scriptType = $script['scriptType'][0];

                $scriptContent = "<h3>$scriptType - $scriptName</h3><pre style='background-color:#444; color: #fff; padding: 10px; border-radius: 10px'>$scriptSource</pre>";
            }
            break;
        }
    }

    if ($found) {
        $content = $number;
    } else {
        $content = "error";
        $error = "Unable to locate GearID: $number\nPlease try again later";
    }
} else {
    $content = "mainPage";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear - <?php echo "$name"; ?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php echo $content; ?>
</body>
</html>