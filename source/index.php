<?php
require_once "boot.php";

$url                = @$_POST["url"];
$resolutionX        = @$_POST["resolutionX"];
$resolutionY        = @$_POST["resolutionY"];
$deviceScaleFactor  = @$_POST["deviceScaleFactor"];

$resolutionX        = max(320, min(2560, ((int)$resolutionX)??1920));
$resolutionY        = max(240, min(1440, ((int)$resolutionY)??1080));
$deviceScaleFactor  = max(0.5, min(4, ((float)$deviceScaleFactor)??1.25));

echo <<<HTML
<form method="post">
    <input name="url" type="url" placeholder="Insira o link da página aqui." value="$url"><br>

    <input name="resolutionX" type="number" step="1" placeholder="Insira a largura" value="$resolutionX" step="1">
    <input name="resolutionY" type="number" placeholder="Insira a altura" value="$resolutionY" step="1">
    <input name="deviceScaleFactor" type="number" placeholder="Insira a escala" value="$deviceScaleFactor" step="0.01"><br>

    <input type="submit">
</form>
HTML;


if(!$url||!$resolutionX||!$resolutionY||!$deviceScaleFactor) {
    return;
}


$screenshotPath = "screenshots/".uniqid("sv1_", true).".png";

$websiteScreenshotController = new \Controller\WebSiteScreenshotController($resolutionX, $resolutionY, $deviceScaleFactor);
$websiteScreenshotController->goTo($url);
$websiteScreenshotController->captureScreenshot($screenshotPath);
$websiteScreenshotController->close();

echo <<<HTML
<a href="$screenshotPath">Ver imagem</a>
<script>
window.open("$screenshotPath");
</script>
HTML;