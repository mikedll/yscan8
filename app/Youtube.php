<?php

namespace App;

use Alaouy\Youtube\Facades\Youtube as VendorYoutube;

class Youtube
{
    protected $vendorYoutube;
    
    public function __construct(VendorYoutube $vYt)
    {
        $this->vendorYoutube = $vYt;
    }
    
    public function parseVidFromURL($ytUrl)
    {
        return $this->vendorYoutube::parseVidFromURL($ytUrl);
    }
}
