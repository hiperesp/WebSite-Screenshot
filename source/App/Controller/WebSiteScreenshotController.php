<?php

namespace Controller;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;

class WebSiteScreenshotController {

    private RemoteWebDriver $webDriver;

    public function __construct(int $resolutionX = 1920, int $resolutionY = 1080, float $deviceScaleFactor = 1) {
        $resolutionX = round($resolutionX/$deviceScaleFactor);
        $resolutionY = round($resolutionY/$deviceScaleFactor);

        $options = new ChromeOptions();
        $options->addArguments([
            '--no-sandbox',
            '--disable-gpu',
            '--headless',
            'disable-infobars',
            '--force-device-scale-factor='.$deviceScaleFactor,
            '--window-size='.$resolutionX.','.$resolutionY
        ]);
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
    
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub/', $capabilities, 20000);
    }

    public function goTo(string $url): void {
        $this->webDriver->get($url);
    }

    public function captureScreenshot(?string $savePath = null): string {
        return $this->webDriver->takeScreenshot($savePath);
    }

    public function wait(int $milisseconds): void {
        usleep($milisseconds/1000);
    }

    public function close(): void {
        $this->webDriver->close();
    }
}