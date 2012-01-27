<?php
    require __DIR__ . '/lib/Conductor/Conductor.php';

    $conductor = new Conductor\Conductor($_SERVER['REQUEST_METHOD']);

    $conductor->addRoutes(array(
        '/example.php' => function () {echo 'hello world!';}
    ));
    
    $conductor->addRoutes(array(
            '/example.php' => function () {echo 'hello world! get request.';}
        ),
        'get'
    );
    
    $conductor->addRoutes(array(
            '/example.php' => function () {echo 'hello world! post request';}
        ),
        'post'
    );
    
    $conductor->run($_SERVER['REQUEST_URI']);
