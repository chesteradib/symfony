<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'my_shop_controller' shared service.

include_once $this->targetDirs[3].'/src/Shop/Bundle/ManagementBundle/Entity/ServiceName.php';

return $this->services['my_shop_controller'] = new \Shop\Bundle\ManagementBundle\Entity\ServiceName(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->load('getDoctrine_Orm_DefaultEntityManagerService.php')) && false ?: '_'}, ${($_ = isset($this->services['members_management.follow.services']) ? $this->services['members_management.follow.services'] : $this->load('getMembersManagement_Follow_ServicesService.php')) && false ?: '_'});
