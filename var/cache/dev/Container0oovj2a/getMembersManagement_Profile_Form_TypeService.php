<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'members_management.profile.form.type' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/FormTypeInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/AbstractType.php';
include_once $this->targetDirs[3].'/src/Members/Bundle/ManagementBundle/Form/Type/ProfileFormType.php';

return $this->services['members_management.profile.form.type'] = new \Members\Bundle\ManagementBundle\Form\Type\ProfileFormType('Members\\Bundle\\ManagementBundle\\Entity\\User');
