<?php
return array(

    'service_manager' => array(
        'invokables' => array(
            'switch-board' => 'ZDTSwitchBoard\Collector\SwitchBoardCollector',
        ),
        'factories' => array(
            'ZDTSwitchBoard\SwitchBoardOptions' => 'ZDTSwitchBoard\SwitchBoardOptionsFactory',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'zend-developer-tools/toolbar/switch-board-data' => __DIR__ . '/../view/zdt-switch-board/switch-board-toolbar.phtml',
        ),
    ),

    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'switch-board' => 'switch-board',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'switch-board' => 'zend-developer-tools/toolbar/switch-board-data',
            ),
        ),
    ),

    'zdt_switch_board_options' => array(
        'cookie_key' => 'zdt_switch_board_options',
        'switches' => array(
            // put your switches here
            // 'switchName' => value,
        ),
    ),
);
