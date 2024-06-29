<?php
function browser($userAgent)
{
    $agent = new \Jenssegers\Agent\Agent();
    $agent->setUserAgent($userAgent);

    $parser = new \WhichBrowser\Parser($userAgent);

    $browser = new \Browser($userAgent);

    return new class($agent, $parser, $browser)
    {
        public function __construct($agent, $parser, $browser)
        {
            $this->agent = $agent;
            $this->result = $parser;
            $this->browser = $browser;
        }
        public function getDevice()
        {
            return $this->agent->device() ?: $this->result->device->toString() ?: $this->browser->getPlatform();
        }
        public function getBrowser()
        {
            return $this->agent->browser() ?: $this->result->browser->name ?: $this->browser->getBrowser();
        }
        public function getPlatform()
        {
            return $this->agent->platform() ?: $this->result->os->name ?: $this->browser->getPlatform();
        }
        public function isMobile()
        {
            return $this->agent->isPhone() ?: $this->result->isType('mobile') ?: $this->browser->isMobile();
        }
        public function isTablet()
        {
            return $this->result->isType('tablet') ?: $this->browser->isTablet();
        }
        public function isDesktop()
        {
            return $this->agent->isDesktop() ?: $this->result->isType('desktop') ?: (! $this->browser->isMobile() && ! $this->browser->isTablet());
        }
        public function isRobot()
        {
            return $this->agent->isRobot() ?: $this->browser->isRobot();
        }
    };
}
