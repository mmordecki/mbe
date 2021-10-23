<?php
require 'vendor/autoload.php';
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://goldmanrecruitment.pl/oferty-pracy/');
$htmlString = (string) $response->getBody();
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);
$offers_list = $xpath->evaluate('//*[@id="offers-list"]/li');
$scraped_data = [];
foreach($offers_list as $key=>$offer_row) {
    $el = $key+1;
    $title_element = $xpath->evaluate('//*[@id="offers-list"]/li['.$el.']/div/div[1]/a');
    $short_desc = $xpath->evaluate('//*[@id="offers-list"]/li['.$el.']/div/div[2]/div[1]/div');
    $link_element = $xpath->evaluate('//*[@id="offers-list"]/li['.$el.']/div/div[3]/a//@href');
    $scraped_data[] = [
        'title' => $title_element[0]->textContent,
        'short_desc' => $short_desc[0]->textContent,
        'link' => $link_element[0]->value,
    ];
}
echo "<h1>Oferty pracy</h1>";
foreach ($scraped_data as $row) {
    echo "<h4 id='title'>Tytuł: ".str_replace("Nowa","",$row['title'])."</h4>";
    echo "<div id='short_desc'>Opis: ".$row['short_desc']."</div>";
    echo "<div id='link'><a href=".$row['link'].">Zobacz ofertę</a></div>";
}
?>
</body>
</html>
