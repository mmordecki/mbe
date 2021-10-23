<?php
require 'vendor/autoload.php';
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
$id = str_replace("/","",$_GET['id']);
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://goldmanrecruitment.pl/oferta/'.$id.'/');
$htmlString = (string) $response->getBody();
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);
$title = $xpath->evaluate('/html/body/div[8]/div/div[1]/div/div[2]/div/div/div[1]/h1');
$number = $xpath->evaluate('/html/body/div[8]/div/div[1]/div/div[2]/div/div/div[2]');
$desc = $xpath->evaluate('/html/body/div[8]/div/div[1]/div/div[2]/div/div/div[3]');
$link = $xpath->evaluate('/html/body/div[8]/div/div[2]/div/div[2]/div/div/a/@href');
$desc_long = $xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[1]/ul/li');
$req = $xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[2]/ul/li');
$offer = $xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[3]/ul/li');
//print_r($desc_long);
echo '<h2 id="title" style="text-align:center">'.$title[0]->textContent.'</h2>';
echo '<div id="number" style="text-align:center">'.$number[0]->textContent.'</div>';
echo '<div id="desc" style="text-align:center">'.$desc[0]->textContent.'</div>';
echo '<h3>'.$xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[1]/h2')[0]->textContent.'</h3>';
echo "<ul>";
foreach($desc_long as $d) {
    echo "<li>".$d->textContent."</li>";
}
echo "</ul>";
echo '<h3>'.$xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[2]/h2')[0]->textContent.'</h3>';
echo "<ul>";
foreach($req as $r) {
    echo "<li>".$r->textContent."</li>";
}
echo "</ul>";
echo '<h3>'.$xpath->evaluate('//*[@id="jobsContent"]/div[1]/div/div[3]/h2')[0]->textContent.'</h3>';
echo "<ul>";
foreach($offer as $o) {
    echo "<li>".$o->textContent."</li>";
}
echo "</ul>";
echo "<div id='link'><a href=".$link[0]->value.">Aplikuj</div>";
?>
</body>
</html>
