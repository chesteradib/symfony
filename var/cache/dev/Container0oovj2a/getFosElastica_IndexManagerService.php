<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'fos_elastica.index_manager' shared service.

include_once $this->targetDirs[3].'/vendor/friendsofsymfony/elastica-bundle/src/Index/IndexManager.php';

$a = ${($_ = isset($this->services['fos_elastica.index.search']) ? $this->services['fos_elastica.index.search'] : $this->load('getFosElastica_Index_SearchService.php')) && false ?: '_'};

return $this->services['fos_elastica.index_manager'] = new \FOS\ElasticaBundle\Index\IndexManager(array('search' => $a), $a);
