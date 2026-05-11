<?php

$this->applications['tessera']['name'] = 'Second Factor';
$this->applications['tessera']['menu_parent'] = 'others';
$this->applications['tessera']['provides'] = 'secondfactor';

$this->applications['tessera-menu']['app'] = 'tessera';
$this->applications['tessera-menu']['menu_parent'] = 'tessera';
$this->applications['tessera-menu']['status'] = 'topbar';
