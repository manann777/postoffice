<?php
use Yii;

$path = Yii::getAlias(__DIR__ ."../simplesaml/lib/_autoload.php");
$as = new \SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
 $attributes = $as->getAttributes();



?>