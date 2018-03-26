<?php

namespace OM\EspaceUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OMEspaceUserBundle extends Bundle
{
    public function getParent()
    {

        return 'FOSUserBundle';
    }
}
