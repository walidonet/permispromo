<?php

namespace OM\AuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OMAuthBundle extends Bundle
{
    public function getParent()
    {
        return "FOSOAuthServerBundle";  //Or return "FOSUserBundle"; but you can't put both
    }
}
