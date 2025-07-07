<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ContentSecurityPolicy extends BaseConfig
{
    public bool $reportOnly = false;

    public string $reportURI = '';

    public array $defaultSrc = ['self'];
    public array $scriptSrc = [];
    public array $styleSrc = [];
    public array $imageSrc = [];
    public array $baseURI = [];
    public array $childSrc = [];
    public array $connectSrc = [];
    public array $fontSrc = [];
    public array $formAction = [];
    public array $frameAncestors = [];
    public array $frameSrc = [];
    public array $manifestSrc = [];
    public array $mediaSrc = [];
    public array $objectSrc = [];
    public array $sandbox = [];
    public bool $upgradeInsecureRequests = false;
    public bool $blockAllMixedContent = false;
    public array $pluginTypes = [];
    public array $requireSriFor = [];
    public array $workerSrc = [];
}
