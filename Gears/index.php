<?php

static $json = '../json/FilePath';
static $images = '../images/FilePath';
$gearDataPointer = str_replace('FilePath', 'GearData.json', $json);
$gearScriptsPointer = str_replace('FilePath', 'GearScripts.json', $json);
$thumbnails = str_replace('FilePath', 'thumbnails/FilePath', $images);
$content = [];
$gearName = null;
$gearThumbnail = null;

function unpack_content() {
    global $content;
    foreach ($content as $tag) {
        echo $tag;
    }
}

function find_number(string $inputStr, int $count = 1) {
    preg_match('/\/(\d+)/', $inputStr, $matches);
    if (count($matches) <= 0) {return 0;}
    $result = ($count > 1) ? (array_slice($matches, 0, $count)) : $matches[1];
    return $result;
}

function unpack_json(string $filePath) {
    if (count_chars($filePath) <= 0) { echo "Please provide a valid filePath argument"; }
    $result = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : "File does not exist";
    return $result;
}

function get_image_path(int $gearId) {
    global $thumbnails;
    $return = str_replace('FilePath', str_replace('GearId', $gearId, 'GearId.jpg'), $thumbnails);
    return $return;
}

function load_script($script = null) {
    global $content;
    $scriptType = $script['scriptType'];
    $scriptName = $script['scriptName'];
    $scriptSource = $script['scriptSource'];

    $tag = "<pre><h3>$scriptType - $scriptName</h3><code class='language-lua'>$scriptSource</code></pre>";
    array_push($content, $tag);
}

$uri = $_SERVER['REQUEST_URI'];
$number = find_number($uri);

if ($number) {
    $gearData = unpack_json($gearDataPointer);
    $scriptsData = unpack_json($gearScriptsPointer);

    if(!array_key_exists($number, $gearData)) { exit('Error!'); }

    $gearId = $number;
    $item = $gearData[$gearId];
    $scripts = $scriptsData[$gearId];
    $gearName = $item['name'];
    $gearThumbnail = get_image_path($gearId);

    $headerTag = "<header><img class='gear-thumbnail' src=$gearThumbnail><h1>$gearName</h1></header>";
    array_push($content, $headerTag);

    foreach ($scripts as $script) {
        load_script($script);
    }
} else {
    exit('Error!');
}

?>

<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$gearName"; ?></title>
    <link rel="stylesheet" href="../styles/itempage.css">
    <link rel="shortcut icon" href=<?php echo "$gearThumbnail"; ?> />
    <link rel="stylesheet" href="../styles/highlighter.css"/>
    <script src="../js/highlight.js"></script>
    <script src="../js/lua.js"></script>
    <script> hljs.highlightAll(); </script>
</head>
<body>
    <div class='body'>
        <?php unpack_content(); ?>
    </div>
</body>
</html>