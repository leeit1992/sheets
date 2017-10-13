<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Foundation\Request;
use App\Model\MessagesModel;
use App\Model\UserModel;
use App\Model\SheetModel;

class MessagesController extends baseController
{

    public function __construct()
    {
        parent::__construct();
        $this->userAccess();

        $this->mdMessages = new MessagesModel;
        $this->mdUser = new UserModel;
        $this->mdSheet = new SheetModel;
    }

    public function writeMessages(Request $request)
    {

        if ($request->Get('formData')) {
            parse_str($request->get('formData'), $formData);
            if (!empty($formData['op_sheet'])) {
                $this->mdSheet->save(
                    [
                        'sheet_status'  => 2
                    ],
                    $formData['op_sheet']
                );
            }
            $this->mdMessages->save(
                [
                    'op_sheet_id'  => $formData['op_sheet'],
                    'op_messages'  => $formData['op_messages'],
                    'op_message_title'  => $formData['op_title'],
                    'op_user_send' => Session()->get('op_user_id'),
                    'op_user_receiver' => $formData['op_receiver'],
                    'op_datetime'  => date("Y-m-d H:i:s"),
                    'op_status'    => 1,
                    'op_type'      => 'send'
                ]
            );

            $this->mdMessages->save(
                [
                    'op_sheet_id'  => $formData['op_sheet'],
                    'op_messages'  => $formData['op_messages'],
                    'op_message_title'  => $formData['op_title'],
                    'op_user_send' => Session()->get('op_user_id'),
                    'op_user_receiver' => $formData['op_receiver'],
                    'op_datetime'  => date("Y-m-d H:i:s"),
                    'op_status'    => 1,
                    'op_type'      => 'inbox'
                ]
            );
    
            $userInfo = $this->mdUser->getUserBy('id', $formData['op_receiver']);

            $log = 'User <b>' . $this->infoUser['name'] . '</b> send message to User <b>' . $userInfo[0]['user_name'] . '</b>';
            // Set notice success
            $this->mdLogs->add($this->mdLogs->logTemplate($log, 'Messages'));
        }
    }

    public function messageNotice()
    {
        $this->manageMessages('notice');
    }

    public function manageMessages($type = null)
    {
        
        if (!$type) {
            $type = 'inbox';
        }
        
        registerStyle([
            'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
        ]);

        $condition['op_user_receiver'] = Session()->get('op_user_id');
        $condition['op_type'] = $type;
        $condition['ORDER'] = [
                        'id' => 'DESC'
                    ];

        $listMessages = $this->mdMessages->getBy(
            $condition
        );

        $listSheets = $this->mdSheet->getBy(['sheet_author' => Session()->get('op_user_id')]);
        $listSheetsOther = $this->mdSheet->getBy( [
            'sheet_author' => Session()->get('op_user_id'),
            'sheet_status' => 3
        ] );
        // Load layout.
        return $this->loadTemplate(
            'messages/inbox.tpl',
            [
                'pageType' => $type,
                'listMessages' => $listMessages,
                'mdUser'  => $this->mdUser,
                'listSheets' => $listSheets,
                'userCurrent' => $this->infoUser,
                'listSheetsOther' => $listSheetsOther
            ]
        );
    }

    public function removeMessages(Request $request)
    {
        if ('notice' == $request->get('type')) {
            $check = $this->mdMessages->getBy(
                [
                    'op_user_send' => Session()->get('op_user_id'),
                ]
            );

            if (!empty($check)) {
                $this->mdMessages->delete($request->get('id'));
            }
        }
        if ('inbox' == $request->get('type')) {
            $check = $this->mdMessages->getBy(
                [
                    'op_user_receiver' => Session()->get('op_user_id'),
                ]
            );
            
            if (!empty($check)) {
                $this->mdMessages->delete($request->get('id'));
            }
        }
    }

    public function filterMessages(Request $request)
    {

        $output = '';
        switch ($request->get('type')) {
            case 'search':
                $condition['op_message_title[~]'] = $request->get('value');
                $condition['op_type'] = $request->get('typeMes');
                $condition['ORDER'] = [
                            'id' => 'DESC'
                    ];
                $listMessages = $this->mdMessages->getBy(
                    $condition
                );
                
                ob_start();
                View(
                    'messages/layout/listMesJs.tpl',
                    [
                        'listMessages' => $listMessages,
                        'mdUser'  => $this->mdUser,
                        'typeMes' => $request->get('typeMes')
                    ]
                );
                $output .= ob_get_clean();
                break;

            case 'filter-user':
                if ('inbox' == $request->get('typeMes')) {
                    $condition['op_user_send'] = $request->get('value');
                } else {
                    $condition['op_user_send'] = $request->get('value');
                    $condition['op_user_receiver'] = Session()->get('op_user_id');
                }

                $condition['op_type'] = $request->get('typeMes');
                $condition['ORDER'] = [
                            'id' => 'DESC'
                    ];

                $listMessages = $this->mdMessages->getBy(
                    $condition
                );
                
                ob_start();
                View(
                    'messages/layout/listMesJs.tpl',
                    [
                        'listMessages' => $listMessages,
                        'mdUser'  => $this->mdUser,
                        'typeMes' => $request->get('typeMes')
                    ]
                );
                $output .= ob_get_clean();
                break;

            case 'filter-date':
                $condition['op_datetime[~]'] = date('Y-m-d', strtotime($request->get('value')));
                $condition['op_type'] = $request->get('typeMes');
                $condition['ORDER'] = [
                            'id' => 'DESC'
                    ];
                $listMessages = $this->mdMessages->getBy(
                    $condition
                );
                
                ob_start();
                View(
                    'messages/layout/listMesJs.tpl',
                    [
                        'listMessages' => $listMessages,
                        'mdUser'  => $this->mdUser,
                        'typeMes' => $request->get('typeMes')
                    ]
                );
                $output .= ob_get_clean();
                break;
        }

        echo json_encode([
            'data' => $output
        ]);
    }

    public function updateInbox(Request $request)
    {
        if (1 == $request->get('mStatus')) {
            $this->mdMessages->save(
                [
                    'op_status'    => 2,
                ],
                $request->get('id')
            );
        }
    }

    public function acceptSheet(Request $request)
    {
        $listRowEmpty = [];

        $infoMes = $this->mdMessages->getBy(
            [
                            'id' => $request->get('mesId')
                        ]
        );
        // Data sheet from inbox
        $dataSheetInbox = json_decode($infoMes[0]['op_data_sheet']);

        // remove emptry
        foreach ($dataSheetInbox as $key => $value) {
            if (empty($value[0])) {
                unset($dataSheetInbox[$key]);
            }
        }
        $totalRow = count($dataSheetInbox);

        // Send notice inbox to user.
        $this->mdMessages->save(
            [
                'op_messages'   => 'Your data has been moderated and accepted.',
                'op_message_title'  => 'System notice.',
                'op_user_send'  => Session()->get('op_user_id'),
                'op_user_receiver' => $infoMes[0]['op_user_send'],
                'op_sheet_id'   => $infoMes[0]['op_sheet_id'],
                'op_datetime'   => date("Y-m-d H:i:s"),
                'op_status'     => 1,
                'op_type'       => 'notice',
                'op_data_sheet' => $infoMes[0]['op_data_sheet'],
                'op_data_sheet_meta' => $infoMes[0]['op_data_sheet_meta'],
            ]
        );

        // Change status messages
        $this->mdMessages->save(['op_status' => 3], $request->get('mesId'));

        $infoSheet = $this->mdSheet->getBy(
            [
                            'id' => $request->get('sheetId')
                        ]
        );

        if (!empty($infoMes) && !empty($infoSheet)) {
            $listRowEmpty = [];
            // Get current sheet data
            if (is_array(json_decode($infoSheet[0]['sheet_content']))) {
                $currentDataSheet = json_decode($infoSheet[0]['sheet_content']);
                
                // remove emptry
                // foreach ($currentDataSheet as $key => $value) {
                // 	if( empty( $value[0] ) ) {
                // 		unset($currentDataSheet[$key]);
                // 	}
                // }
                // Get row empty
                $listRowEmpty = $this->getRowEmpty($currentDataSheet, $totalRow);
            } else {
                $currentDataSheet = array();
            }

            // Get current sheet meta data
            if (is_array(json_decode($infoSheet[0]['sheet_meta'], true))) {
                $currentMetaSheet = json_decode($infoSheet[0]['sheet_meta'], true);
            } else {
                $currentMetaSheet = array();
            }

            $newMetaSheet = array();
            $dataSheetMetaInbox = json_decode($infoMes[0]['op_data_sheet_meta']);
    
            $ccol = 0;
            $crow = 0;
            foreach ($dataSheetMetaInbox as $key => $value) {
                $_crow = 0;
                $_ccol = $ccol;
            
                if ($_crow < $totalRow) {
                    $_crow = $crow += 1;
                }

                if ($crow == $totalRow) {
                    $crow = 0;
                    $_ccol = $ccol++;
                }

                if (16 == $ccol) {
                    $ccol = 0;
                }

                $newMetaSheet[($_crow-1).'-'.$_ccol] = $value;
            }

            // Merge sheet to meta sheet
            $nextKey = 0;
            $nextRow = count($dataSheetInbox);
            $sheetDataMegeArgs = [];
            foreach ($dataSheetInbox as $key => $value) {
                $_nextRow = $nextRow++;
                $newDataSheetUpdate = [];
                foreach ($value as $_key => $_value) {
                    $metaOrder = $nextKey++;
                    if (15 == $metaOrder) {
                        $nextKey = 0;
                    }
                    
                    $newDataSheetUpdate[$metaOrder] = $newMetaSheet[$key . '-' . $metaOrder];
                }

                // $currentDataSheet[] = [
                // 	'data' => $value,
                // 	'meta' => $newDataSheetUpdate
                // ];
        
                $sheetDataMegeArgs[] = [
                    'data' => $value,
                    'meta' => $newDataSheetUpdate
                ];
            }

            if (empty($currentDataSheet)) {
                $currentDataSheet = $sheetDataMegeArgs;
            }

            if (!empty($currentMetaSheet)) {
                if (count($listRowEmpty) != $totalRow) {
                    $firstValue = array_keys($listRowEmpty);
                    unset($listRowEmpty[$firstValue[0]]);
                }
            }

            if (!empty($currentDataSheet)) {
                $iDinbox = 0;
                foreach ($listRowEmpty as $key => $value) {
                    $_iDinbox = $iDinbox++;
                    $key = $key - 1;
                    
                    if ($key < 0) {
                        $key = 0;
                    }
                    
                    $currentDataSheet[$key] = $sheetDataMegeArgs[$_iDinbox];
                }
            }

            $newSaveSheetData = [];
            foreach ($currentDataSheet as $row => $value) {
                $data = $value;

                if (isset($value['data'])) {
                    $data  = $value['data'];

                    foreach ($value['meta'] as $col => $valueM) {
                        $keyMeta = $row . '-' . $col;

                        $valueM->rCtm = $valueM->row; // Sheet row of customer
                        $valueM->cCtm = $valueM->col; // Sheet col of customer
                        $valueM->row = $row;
                        $valueM->col = $col;
                        $valueM->background = '';
                        $valueM->color = '';

                        if (1 == $this->infoUser['meta']['user_role']) {
                            $valueM->sIdCtm = $valueM->sheetId; // Sheet id of customer
                            $valueM->readOnly = 'false';
                        }

                        if (3 == $this->infoUser['meta']['user_role']) {
                            $valueM->mesId = $request->get('mesId');
                        }
                        
                        $currentMetaSheet[$keyMeta] = $valueM;
                    }
                }

                $newSaveSheetData[$row] = $data;
            }

            $this->mdSheet->save(
                [
                    'sheet_content' => json_encode($newSaveSheetData),
                ],
                $request->get('sheetId')
            );

            /**
             * Add meta data for user.
             */
            $sheetMeta = [
                'sheet_meta' => json_encode($currentMetaSheet),
            ];

            // Loop add add | update meta data.
            foreach ($sheetMeta as $mtaKey => $metaValue) {
                $this->mdSheet->setMetaData($request->get('sheetId'), $mtaKey, $metaValue);
            }

            $this->mdMessages->save(
                [
                    'op_accept_status'  => 1,
                ],
                $request->get('mesId')
            );
        }
    }

    public function autoLoadInbox(Request $request)
    {

        $condition['op_user_receiver'] = $request->get('userId');
        $condition['op_status'] = 1;
        $condition['ORDER'] = [
                    'id' => 'DESC'
            ];
        $listMessages = $this->mdMessages->getBy(
            $condition
        );

        $newMes = [];
        foreach ($listMessages as $key => $value) {
            $user = $this->mdUser->getUserBy('id', $value['op_user_send']);
            $avatar = assets('img/user.png');
            if (isset($user[0]['user_avatar'])) {
                $avatar = url($user[0]['user_avatar']);
            }

            $newMes[] = [
                'id' => $value['id'],
                'op_message_title' => $value['op_message_title'],
                'op_messages' => $value['op_messages'],
                'user_name' => isset($user[0]) ? $user[0]['user_name'] : '',
                'user_avatar' => $avatar,
                'linkSheet' => url('/view-sheet/' . $value['op_sheet_id']),
                'linkInbox' => url('/massages-manage?inbox=' . $value['id']),
                'op_type' => $value['op_type']
            ];
        }

        echo json_encode($newMes);
    }

    public function sendBackInbox(Request $request)
    {

        $getMesId = json_decode($request->get('sheetMeta'));
        $socketId = [];

        // $infoMes = $this->mdMessages->getBy(
        // 				[
        // 					'id' => $request->get('mesId')
        // 				]
        // 			);

        
        $dataSheetInbox = json_decode($request->get('sheetData'));

        // remove emptry
        foreach ($dataSheetInbox as $key => $value) {
            if (empty($value[0])) {
                unset($dataSheetInbox[$key]);
            }
        }

        // $this->mdMessages->save(
        // 	[
        // 		'op_data_sheet' => json_encode($dataSheetInbox),
        // 	],
        // 	$request->get('mesId')
        // );

        // Send notice inbox to user.
        // $this->mdMessages->save(
        // 	[
        // 		'op_messages'   => 'Confim items.',
        // 		'op_message_title'  => 'System notice.',
        // 		'op_user_send'  => Session()->get('op_user_id'),
        // 		'op_user_receiver' => $infoMes[0]['op_user_send'],
        // 		'op_sheet_id'   => $infoMes[0]['op_sheet_id'],
        // 		'op_datetime'   => date("Y-m-d H:i:s"),
        // 		'op_status'     => 1,
        // 		'op_type'       => 'notice',
        // 		'op_data_sheet' => $request->get('sheetData'),
        // 		'op_data_sheet_meta' => $infoMes[0]['op_data_sheet_meta'],
        // 	]
        // );
        //$socketId[] = $infoMes[0]['op_user_send'];

        $totalRow = count($dataSheetInbox);

        $newMetaSheet = [];
        $dataSheetMetaInbox = json_decode($request->get('sheetMeta'), true);
        
        $ccol = 0;
        $crow = 0;
        foreach ($dataSheetMetaInbox as $key => $value) {
            $_crow = 0;
            $_ccol = $ccol;
            
            if ($_crow < $totalRow) {
                $_crow = $crow += 1;
            }

            if ($crow == $totalRow) {
                $crow = 0;
                $_ccol = $ccol++;
            }

            if (16 == $ccol) {
                $ccol = 0;
            }

            $newMetaSheet[($_crow-1).'-'.$_ccol] = $value;
        }
                
        $nextKey = 0;
        $nextRow = count($dataSheetInbox);
        $newDataSheetUpdate = [];
        $newDataSheetUpdateDIS = [];
        $newDataSheetUpdateWeight = [];
        $sIdsCtm = [];
        foreach ($dataSheetInbox as $key => $value) {
            $_nextRow = $nextRow++;
            foreach ($value as $_key => $_value) {
                $metaOrder = $nextKey++;
                if (15 == $metaOrder) {
                    $nextKey = 0;
                }

                if (isset($newMetaSheet[$key . '-' . $metaOrder])) {
                    if ('Out' == $_value || 'Oke' == $_value) {
                        $sIdsCtm[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']] = $newMetaSheet[$key . '-' . $metaOrder]['sIdCtm'];


                        if (1 == $this->infoUser['meta']['user_role']) {
                                $newDataSheetUpdate[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']][] = [
                                    'data' => $_value,
                                    'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                                ];
                        }

                        if (3 == $this->infoUser['meta']['user_role']) {

                            $newDataSheetUpdate[$newMetaSheet[$key . '-' . $metaOrder]['sheetId']][] = [
                                'data' => $_value,
                                'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                            ];
                        }
                    }

                    if (14 == $_key) {
                        if (isset($newMetaSheet[$key . '-' . $metaOrder]['sIdCtm'])) {
                            $sIdsCtm[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']] = $newMetaSheet[$key . '-' . $metaOrder]['sIdCtm'];
        
                            if (1 == $this->infoUser['meta']['user_role']) {
                                $newDataSheetUpdateDIS[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']][] = [
                                    'data' => $_value,
                                    'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                                ];
                            }

                            if (3 == $this->infoUser['meta']['user_role']) {
                                $newDataSheetUpdateDIS[$newMetaSheet[$key . '-' . $metaOrder]['sheetId']][] = [
                                    'data' => $_value,
                                    'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                                ];
                            }
                        }
                    }

                    if (15 == $_key) {
                        if (isset($newMetaSheet[$key . '-' . $metaOrder]['sIdCtm'])) {
                            $sIdsCtm[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']] = $newMetaSheet[$key . '-' . $metaOrder]['sIdCtm'];
                                
                            if (1 == $this->infoUser['meta']['user_role']) {
                                $newDataSheetUpdateWeight[$newMetaSheet[$key . '-' . $metaOrder]['sIdCtm']][] = [
                                    'data' => $_value,
                                    'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                                ];
                            }

                            if (3 == $this->infoUser['meta']['user_role']) {
                                $newDataSheetUpdateWeight[$newMetaSheet[$key . '-' . $metaOrder]['sheetId']][] = [
                                    'data' => $_value,
                                    'meta' => $newMetaSheet[$key . '-' . $metaOrder]
                                ];
                            }
                        }
                    }
                }
            }
        }


 
        if (1 == $this->infoUser['meta']['user_role']) {
            // Send notice inbox to user.
            $this->mdMessages->save(
                [
                'op_messages'   => $request->get('message'),
                'op_message_title'  => $request->get('title'),
                'op_user_send'  => Session()->get('op_user_id'),
                'op_user_receiver' => $request->get('receiver'),
                'op_sheet_id'   => '',
                'op_datetime'   => date("Y-m-d H:i:s"),
                'op_status'     => 1,
                'op_type'       => 'notice',
                'op_data_sheet' => $request->get('sheetData'),
                'op_data_sheet_meta' => '',
                ]
            );
        }

        $dataSendMessage = [];

        foreach ($newDataSheetUpdate as $sIdCtm => $listDataById) {
            $sheetId = $sIdCtm;
            foreach ($listDataById as $value) {
                $infoSheetUpdate = $this->mdSheet->getBy(
                    [
                                'id' => $sheetId
                            ]
                );
                $infoSheetMetaUpdate = $this->mdSheet->getMetaData(
                    $sheetId,
                    'sheet_meta'
                );
                $infoSheetMetaUpdate = json_decode($infoSheetMetaUpdate, true);


                if (!empty($infoSheetUpdate)) {
                    $getSheetInfo = json_decode($infoSheetUpdate[0]['sheet_content'], true);
                    $rowOke = [];
                    foreach ($getSheetInfo as $row => $cols) {
                        if (isset($value['meta'])) {
                            if ($value['meta']['rCtm'] == $row) {
                                if (isset($value['meta']['comment'])) {
                                    $infoSheetMetaUpdate[$row.'-13']['comment'] = $value['meta']['comment'];
                                }

                                $getSheetInfo[$row][13] = $value['data'];

                                if( 'Oke' == $getSheetInfo[$row][13] ) {
                                    $rowOke[] = $row;
                                }
                            }
                        }
                    }

                    foreach ($rowOke as $row) {
                        for ($i = 0; $i <= 15; $i++) { 
                            
                            if( 13 == $i ) {
                                $infoSheetMetaUpdate[$row.'-'.$i]['background'] = $this->infoUser['color'];
                                $infoSheetMetaUpdate[$row.'-'.$i]['color'] = '#fff';
                            }else{
                                $infoSheetMetaUpdate[$row.'-'.$i]['background'] = '#fff';
                                $infoSheetMetaUpdate[$row.'-'.$i]['color'] = '#0c0c0c';
                            }
                        }
                    };
                        
                    $this->mdSheet->save(
                        [
                        'sheet_content' => json_encode($getSheetInfo),
                        ],
                        $sheetId
                    );

                    $this->mdSheet->setMetaData(
                        $sheetId,
                        'sheet_meta',
                        json_encode($infoSheetMetaUpdate)
                    );

                    $dataSendMessage = json_encode($getSheetInfo);
                }
            }
        }


        foreach ($newDataSheetUpdateDIS as $sIdCtm => $listDataById) {
            $sheetId = $sIdCtm;
            foreach ($listDataById as $value) {
                $infoSheetUpdate = $this->mdSheet->getBy(
                    [
                                    'id' => $sheetId
                                ]
                );

                if (!empty($infoSheetUpdate)) {
                    $getSheetInfo = json_decode($infoSheetUpdate[0]['sheet_content'], true);

                    foreach ($getSheetInfo as $row => $cols) {
                        if ($value['meta']['rCtm'] == $row) {
                            $getSheetInfo[$row][14] = $value['data'];
                        }
                    }
        
                    $this->mdSheet->save(
                        [
                        'sheet_content' => json_encode($getSheetInfo),
                        ],
                        $sheetId
                    );
                    $dataSendMessage = json_encode($getSheetInfo);
                }
            }
        }

        foreach ($newDataSheetUpdateWeight as $sIdCtm => $listDataById) {
            foreach ($listDataById as $value) {
                $sheetId = $sIdCtm;

                $infoSheetUpdate = $this->mdSheet->getBy(
                    [
                                    'id' => $sheetId
                                ]
                );

    
                if (!empty($infoSheetUpdate)) {
                    $getSheetInfo = json_decode($infoSheetUpdate[0]['sheet_content'], true);

                    foreach ($getSheetInfo as $row => $cols) {
                        if ($value['meta']['rCtm'] == $row) {
                            $getSheetInfo[$row][15] = $value['data'];
                        }
                    }
                        
                    $this->mdSheet->save(
                        [
                        'sheet_content' => json_encode($getSheetInfo),
                        ],
                        $sheetId
                    );
                    $dataSendMessage = json_encode($getSheetInfo);
                }
            }
        }

        if (1 == $this->infoUser['meta']['user_role']) {
            foreach ($sIdsCtm as $sIdCtm) {
                $getAuthor = $this->mdSheet->getBy(['id' => $sIdCtm]);

                if (!empty($getAuthor)) {
                    // Send notice inbox to user.
                    $this->mdMessages->save(
                        [
                            'op_messages'   => 'Confim items.',
                            'op_message_title'  => 'System notice.',
                            'op_user_send'  => Session()->get('op_user_id'),
                            'op_user_receiver' => $getAuthor[0]['sheet_author'],
                            'op_sheet_id'   => '',
                            'op_datetime'   => date("Y-m-d H:i:s"),
                            'op_status'     => 1,
                            'op_type'       => 'notice',
                            'op_data_sheet' => $dataSendMessage,
                        ]
                    );

                    $socketId[] = $getAuthor[0]['sheet_author'];
                }
            }
        }
            
        echo json_encode([
            'status' => true,
            'socketId' => $socketId
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $infoMes = $this->mdMessages->getBy(
            [
                            'id' => $request->get('mesId')
                        ]
        );
        $this->mdMessages->save(['op_status' => 4], $request->get('mesId'));

        if (!empty($infoMes)) {
            $sheetMetaInbox = json_decode($infoMes[0]['op_data_sheet_meta'], true);
            $firstMeta = [];
            foreach ($sheetMetaInbox as $first) {
                $firstMeta = $first;
                break;
            }
    
            $infoMetaSheet = $this->mdSheet->getMetaData($firstMeta['sheetId'], 'sheet_meta');
            $infoMetaSheet = json_decode($infoMetaSheet, true);
            foreach ($sheetMetaInbox as $key => $value) {
                if (isset($infoMetaSheet[$key])) {
                    $infoMetaSheet[$key]['background'] = '';
                    $infoMetaSheet[$key]['color'] = '';
                    $infoMetaSheet[$key]['readOnly'] = 'false';
                }
            }

            $this->mdSheet->setMetaData($firstMeta['sheetId'], 'sheet_meta', json_encode($infoMetaSheet));

            $this->mdMessages->save(
                [
                    'op_messages'   => 'Your outgoing data is rejected.',
                    'op_message_title'  => 'System notice.',
                    'op_user_send'  => Session()->get('op_user_id'),
                    'op_user_receiver' => $infoMes[0]['op_user_send'],
                    'op_sheet_id'   => $firstMeta['sheetId'],
                    'op_datetime'   => date("Y-m-d H:i:s"),
                    'op_status'     => 1,
                    'op_type'       => 'inbox',
                    'op_data_sheet' => $infoMes[0]['op_data_sheet'],
                    'op_data_sheet_meta' => $infoMes[0]['op_data_sheet_meta'],
                ]
            );
        }
    }

    public function getRowEmpty($currentDataSheet, $totalRow)
    {
        $listRowEmpty = [];
        foreach ($currentDataSheet as $key => $value) {
            if (empty($value[0]) &&
                empty($value[1]) &&
                empty($value[2]) &&
                empty($value[3]) ) {
                if (count($listRowEmpty) < $totalRow) {
                    if (empty($listRowEmpty[$key])) {
                        for ($i = 0; $i < $totalRow; $i++) {
                            if (null != $currentDataSheet[$key+$i][1]) {
                                $listRowEmpty = [];
                            }

                            $listRowEmpty[$key + 1 + $i] = $key + 1 + $i;
                        }

                        if (null != $currentDataSheet[$totalRow + $key][1]) {
                            $listRowEmpty = [];
                        }
                    }
                }
            }
        }

        return $listRowEmpty;
    }
}
