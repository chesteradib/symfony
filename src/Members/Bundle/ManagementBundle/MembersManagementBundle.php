<?php

namespace Members\Bundle\ManagementBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MembersManagementBundle extends Bundle
{
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
