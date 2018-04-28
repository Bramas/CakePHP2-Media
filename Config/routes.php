<?php

Router::connect(
	'/media',
	array('controller' => 'media', 'plugin'=>'media', 'action'=>'index', 'admin' => true)
);
Router::connect(
	'/media/:action',
	array('controller' => 'media', 'plugin'=>'media', 'admin' => true)
);
Router::connect(
	'/media/:action/*',
	array('controller' => 'media', 'plugin'=>'media', 'admin' => true)
);

Router::connect(
	'/medias/*',
	array('controller' => 'media', 'plugin'=>'media', 'action'=>'serve')
);
