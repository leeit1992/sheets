<?php

namespace App\Http\Components\Backend;

/**
 * adminDataMenu
 * Config data menu nav admin.
 *
 * @version  1.0
 * @author  HaLe 
 * @package  ATL
 */
class AdminDataMenu
{   
    /**
     * $getInstance - Support singleton module.
     * @var null
     */
    private static $getInstance = null;

    protected static $route = null;

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public static function getInstance( $route = null )
    {
        if (!(self::$getInstance instanceof self)) {
            self::$getInstance = new self();
        }

        self::$route = $route;

        return self::$getInstance;
    }

    /**
     * dataMenu
     * Data menu action admin.
     */
    public function dataMenu()
    {   
        $userMeta = Session()->get('op_user_meta');
        return [
            'Dashboard' => [
                'label' => 'Dashboard',
                'icon'  => '<i class="material-icons md-24">&#xE8F0;</i>',
                'conditionOpen' => ['Backend\MainController'],
                'display' => '',
                'link'  => url('/'),
                'display' => '',
            ],

            'sheet' => [
                'label'   => 'Sheets',
                'icon'    => '<i class="material-icons md-36">&#xE8F0;</i>',
                'conditionOpen' => ['SheetsController'],
                'display' => '',
                'submenu' => [
                    [
                        'label' => 'Data sheet',
                        'link'  => url('/sheet'),
                        'display' => '',
                        'conditionOpen' => ['handleSheet'],
                    ],
                    // [
                    //     'label' => 'Sheets management',
                    //     'link'  => url('/sheets-manage'),
                    //     'display' => '',
                    //     'conditionOpen' => ['manageSheets'],
                    // ]
                ]
            ],

            'messages' => [
                'label'   => 'Messages',
                'icon'    => '<i class="material-icons md-36">&#xE8F0;</i>',
                'conditionOpen' => ['MessagesController'],
                'display' => '',
                'submenu' => [
                    [   
                        'label' => 'Notice',
                        'link'  => url('/message-notice'),
                        'display' => '',
                        'conditionOpen' => ['messageNotice'],
                    ],
                    [
                        'label' => 'Inbox',
                        'link'  => url('/massages-manage'),
                        'display' => '',
                        'conditionOpen' => ['manageMessages'],
                    ]
                ]
            ],

            'user' => [
                'label'   => 'User',
                'icon'    => '<i class="material-icons md-36">&#xE8F0;</i>',
                'conditionOpen' => ['UserController'],
                'display' => ( 1 == $userMeta['user_role'] ) ? '' : 'none',
                'submenu' => [
                    [
                        'label' => 'Add User',
                        'link'  => url('/add-user'),
                        'display' => '',
                        'conditionOpen' => ['handleUser'],
                    ],
                    [
                        'label' => 'Management User',
                        'link'  => url('/manage-user'),
                        'display' => '',
                        'conditionOpen' => ['manageUsers'],
                    ]
                ]
            ],

            'configs' => [
                'label'   => 'Configs',
                'icon'    => '<i class="material-icons md-36">&#xE8F0;</i>',
                'conditionOpen' => ['LogsController'],
                'display' => ( 1 == $userMeta['user_role'] ) ? '' : 'none',
                'submenu' => [
                    [
                        'label' => 'Logs',
                        'link'  => url('/logs'),
                        'display' => ( 1 == $userMeta['user_role'] ) ? '' : 'none',
                        'conditionOpen' => ['manageLogs'],
                    ]
                ]
            ],

        ];
    }

    /**
     * Render menu html.
     * 
     * @return string
     */
    public function menuNav(){   
        $control = self::$route['_controller'];
        $action  = self::$route['_action'];
    ?>
    <div class="menu_section">
        <ul>
            <?php foreach ( $this->dataMenu() as $key => $value ): ?>

            <?php if( !isset( $value['submenu'] ) && 'none' !== $value['display'] ): ?>
            <li <?php echo ( in_array( $control, $value['conditionOpen'] ) ) ? 'class="current_section"' : '' ?> title="Dashboard">
                <a href="<?php echo $value['link'] ?>">
                    <span class="menu_icon"><?php echo $value['icon'] ?></span>
                    <span class="menu_title"><?php echo $value['label'] ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if( isset( $value['submenu'] ) && 'none' !== $value['display'] ): ?>
            <li <?php echo ( in_array( $control, $value['conditionOpen'] ) ) ? 'class="current_section submenu_trigger act_section"' : '' ?>>
                <a href="#">
                    <span class="menu_icon"><?php echo $value['icon'] ?></span>
                    <span class="menu_title"> <?php echo $value['label'] ?></span>
                </a>
                <ul <?php echo ( in_array( $control, $value['conditionOpen'] ) ) ? 'style="display: block;"' : '' ?>>
                    <?php foreach ($value['submenu'] as $submenu): ?>
                    <?php if( 'none' !== $submenu['display'] ): ?>
                    <li <?php echo ( in_array( $action, $submenu['conditionOpen'] ) ) ? 'class="act_item submenu_trigger act_section"' : '' ?>>
                        <a href="<?php echo $submenu['link'] ?>"> 
                            <?php echo $submenu['label'] ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php endforeach; ?>  
        </ul>
    </div>
    <?php
    }
}
