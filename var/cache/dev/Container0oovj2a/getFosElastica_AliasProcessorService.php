<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'fos_elastica.alias_processor' shared service.

include_once $this->targetDirs[3].'/vendor/friendsofsymfony/elastica-bundle/src/Index/AliasProcessor.php';

return $this->services['fos_elastica.alias_processor'] = new \FOS\ElasticaBundle\Index\AliasProcessor();
