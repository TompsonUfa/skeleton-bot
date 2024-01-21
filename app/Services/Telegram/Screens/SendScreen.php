<?php

namespace App\Services\Telegram\Screens;

use App\Helpers\BotActionHelper;
use App\Helpers\SendButtonHelper;
use App\Models\NotificationSendHistory;
use App\Models\SendHistory;
use App\Models\Task;
use App\Models\TgUser;
use App\Services\IntegrationService;
use App\Services\Season;
use App\Services\Telegram\Traits\KeyboardsTrait;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class SendScreen extends AbstractScreen
{
    use KeyboardsTrait;

    public static array $macro = [
        'referral.new_referral',
        'send.sync_user_with_site',
    ];

    public function sendSyncUserWithSite()
    {
        $txt = $this->macro('send.sync_user_with_site');
        $this->api->sendMessage($txt);
    }

    public function sendNotifNewReferral(TgUser $ref)
    {
        $txt = $this->macro('referral.new_referral', [
            '__referral_username__' => !empty($ref->username) ? '@' . $ref->username : '',
            '__referral_first_name__' => $ref->first_name
        ]);

        $this->api->sendMessage($txt);
    }

    public function sendUnits($units, $send_id)
    {
        foreach ($units as $unit) {
            $data = json_decode($unit->data, true);
            if ($unit->type == 'text') {
                $keyboard = [];

                if (array_key_exists('buttons',$data)) {
                    foreach ($data['buttons'] as $button_key => $button) {
//                        Log::info(json_encode($button));
                        //Если есть тип и это не стандартная ссылка, а также есть по нему данные
                        if(array_key_exists('screen', $button)
                            && $button['type'] == 'screen'
                            && !empty($typeData = SendButtonHelper::getScreenData($button['screen'])))
                        {
                            $screen = $typeData['class'];
                            $method = $typeData['method'] ?? 'index';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method
                                    ),
                                ]
                            ];
                        }
                        elseif(array_key_exists('text', $button)
                            && $button['type'] == 'text')
                        {
                            $screen = SendScreen::class;
                            $method = 'sendButtonText';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method,
                                        [
                                            'unit_id' => $unit->id,
                                            'button' => $button_key
                                        ]
                                    ),
                                ]
                            ];
                        }
                        else
                        {

                            $keyboardData = [];
                            $keyboardData['text'] = $button['caption'];

                            $url = $button['link'] ?? null;

                            switch ($button['type']) {
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP:
                                    $keyboardData['web_app'] = [
                                        'url' => $url,
                                    ];
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_URL:
                                    $keyboardData['url'] = $url;
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP_CAPTCHA:
                                    $captchaLink = env('APP_URL') . '/webapp/captcha';
                                    $keyboardData['web_app'] = [
                                        'url' => $captchaLink,
                                    ];
                                    break;
                            }

                            $keyboard[] = [
                                $keyboardData
                            ];
                        }
                    }
                }

                if(empty($keyboard))
                {
                    $res = $this->api->sendMessage($this->macro($data['text']));
                }
                else
                {
                    $keyboard = new InlineKeyboardMarkup($keyboard);
                    try{
                        $res = $this->api->sendMessage($this->macro($data['text']), $keyboard);
                    } catch (\Throwable $e) {
                        Log::error($e);
                        $res = null;
                    }

                }
            }
            if ($unit->type == 'photo') {
                $keyboard = [];
                if (array_key_exists('buttons',$data)) {
                    foreach ($data['buttons'] as $button_key => $button) {
                        if(array_key_exists('screen', $button)
                            && $button['type'] == 'screen'
                            && !empty($typeData = SendButtonHelper::getScreenData($button['screen'])))
                        {
                            $screen = $typeData['class'];
                            $method = $typeData['method'] ?? 'index';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method
                                    ),
                                ]
                            ];
                        }
                        elseif(array_key_exists('text', $button)
                            && $button['type'] == 'text')
                        {
                            $screen = SendScreen::class;
                            $method = 'sendButtonText';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method,
                                        [
                                            'unit_id' => $unit->id,
                                            'button' => $button_key
                                        ]
                                    ),
                                ]
                            ];
                        }
                        else
                        {
                            $keyboardData = [];
                            $keyboardData['text'] = $button['caption'];

                            $url = $button['link'] ?? null;

                            switch ($button['type']) {
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP:
                                    $keyboardData['web_app'] = [
                                        'url' => $url,
                                    ];
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_URL:
                                    $keyboardData['url'] = $url;
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP_CAPTCHA:
                                    $captchaLink = env('APP_URL') . '/webapp/captcha';
                                    $keyboardData['web_app'] = [
                                        'url' => $captchaLink,
                                    ];
                                    break;
                            }

                            $keyboard[] = [
                                $keyboardData
                            ];
                        }
                    }
                }

                if(empty($keyboard))
                {
                    $res = $this->api->api->sendPhoto($this->user->tid, env('APP_URL') . '/' . $data['image']);
                }
                else
                {
                    $keyboard = new InlineKeyboardMarkup($keyboard);
                    $res = $this->api->api->sendPhoto(chatId: $this->user->tid,
                        photo: env('APP_URL') . '/' . $data['image'],
                        replyMarkup: $keyboard);
                }
            }
            if ($unit->type == 'photo_text') {
                $keyboard = [];
                if (array_key_exists('buttons',$data)) {
                    foreach ($data['buttons'] as $button_key => $button) {
                        if(array_key_exists('screen', $button)
                            && $button['type'] == 'screen'
                            && !empty($typeData = SendButtonHelper::getScreenData($button['screen'])))
                        {
                            $screen = $typeData['class'];
                            $method = $typeData['method'] ?? 'index';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method
                                    ),
                                ]
                            ];
                        }
                        elseif(array_key_exists('text', $button)
                            && $button['type'] == 'text')
                        {
                            $screen = SendScreen::class;
                            $method = 'sendButtonText';

                            $keyboard[] = [
                                [
                                    'text' => $button['caption'],
                                    'callback_data' => $this->MakeCallbackData(
                                        $screen,
                                        $method,
                                        [
                                            'unit_id' => $unit->id,
                                            'button' => $button_key
                                        ]
                                    ),
                                ]
                            ];
                        }
                        else
                        {
                            $keyboardData = [];
                            $keyboardData['text'] = $button['caption'];

                            $url = $button['link'] ?? null;

                            switch ($button['type']) {
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP:
                                    $keyboardData['web_app'] = [
                                        'url' => $url,
                                    ];
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_URL:
                                    $keyboardData['url'] = $url;
                                    break;
                                case SendButtonHelper::BUTTON_TYPE_WEB_APP_CAPTCHA:
                                    $captchaLink = env('APP_URL') . '/webapp/captcha';
                                    $keyboardData['web_app'] = [
                                        'url' => $captchaLink,
                                    ];
                                    break;
                            }

                            $keyboard[] = [
                                $keyboardData
                            ];
                        }
                    }
                }

                if(empty($keyboard))
                {
                    $res = $this->api->api->sendPhoto($this->user->tid, env('APP_URL') . '/' . $data['image'], $this->macro($data['text']), parseMode: 'html');
                }
                else
                {
                    $keyboard = new InlineKeyboardMarkup($keyboard);
                    $res = $this->api->api->sendPhoto(chatId: $this->user->tid,
                        photo: env('APP_URL') . '/' . $data['image'],
                        caption: $this->macro($data['text']),
                        replyMarkup: $keyboard,
                        parseMode: 'html');
                }

            }


            if (!is_null($res) && $id = ($res->getMessageId() ?? 0)) {
                $m = new SendHistory();
                $m->send_id = $send_id;
                $m->unit_id = $unit->id;
                $m->tg_user_id = $this->user->id;
                $m->message_id = $id;
                $m->save();
            }
        }
    }

    public function completedTaskNotification($task): void
    {
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('tasks.back_to_list_of_tasks'),
                    'callback_data' => $this->MakeCallbackData(
                        TaskScreen::class
                    )
                ]
            ]
        ]);

        $text = $this->macro('tasks.task_been_completed');

        $this->api->sendMessage($this->macro($text, [
            '__task_name__' => $task->name
        ]), $keyboard);

        $history = new NotificationSendHistory();
        $history->user_id = $this->user->id;
        $history->task_id = $task->id;
        $history->save();
    }

    public function uncompletedTaskNotification($userTask, $task): void
    {
        $link = $task->link;
        if ($task->type == Task::TYPE_LINK_REDIRECT) {
            $link = route('redirect.link', $userTask->link_hash);
        }

        $keyboard = [];

        if (!empty($link)) {
            $keyboard[] = [
                [
                    'text' => $task->go_it,
                    'url' => $link
                ]
            ];
        }

        $keyboard[] = [
            [
                'text' => $this->macro('tasks.task_completed'),
                'callback_data' => $this->MakeCallbackData(
                    self::class,
                    'completeTask',
                    $task->id
                )
            ]
        ];

        $keyboard = new InlineKeyboardMarkup($keyboard);

        $text = $this->macro('tasks.task_not_been_completed');

        $this->api->sendMessage($this->macro($text, [
            '__task_name__' => $task->name
        ]), $keyboard);
    }

    public function completedAllTasksNotification(): void
    {
        $text = $this->macro('tasks.all_tasks_been_completed');

        $this->api->sendMessage($text);
    }

    public function sendActionNotification($action, $step): void
    {
        $macro = BotActionHelper::getMacro($action, $step);
        $text = $this->macro($macro);
        if (empty($text)) {
            return;
        }

        $keyboard = null;
        if ($action == BotActionHelper::MENU) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('notification.menu_button'),
                        'callback_data' => $this->MakeCallbackData(
                            StartScreen::class
                        ),
                    ],
                ],
            ];
        }
        elseif ($action == BotActionHelper::INTRO_STEP_1) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('captcha_subscribe.step_1_button'),
                        'callback_data' => $this->MakeCallbackData(
                            CaptchaSubscribeScreen::class,
                            'step_2'
                        ),
                    ],
                ],
            ];
        }
        elseif ($action == BotActionHelper::INTRO_STEP_2) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('captcha_subscribe.step_2_button'),
                        'callback_data' => $this->MakeCallbackData(
                            CaptchaSubscribeScreen::class,
                            'step_3'
                        ),
                    ],
                ],
            ];
        }
        elseif ($action == BotActionHelper::INTRO_STEP_3) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('captcha_subscribe.step_3_button'),
                        'callback_data' => $this->MakeCallbackData(
                            CaptchaSubscribeScreen::class,
                            'subscribe'
                        ),
                    ],
                ],
            ];
        }
        elseif ($action == BotActionHelper::TOKEN) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('token.i_have_promocode_button'),
                        'callback_data' => $this->MakeCallbackData(
                            TokenScreen::class,
                            'site'
                        ),
                    ]
                ],
                [
                    [
                        'text' => $this->macro('token.i_not_have_promocode_button'),
                        'callback_data' => $this->MakeCallbackData(
                            TokenScreen::class,
                            'channel'
                        ),
                    ],
                ],
            ];
        }
        elseif (in_array($action, [BotActionHelper::TOKEN_SITE, BotActionHelper::TOKEN_PROMOCODE])) {
            $api = new IntegrationService();
            $url = 'https://proofofhype.com?' . $api->getParamsUrl($this->user);
//            $url = 'https://hype.customapp.tech?' . $api->getParamsUrl($this->user);
            $keyboard = [
                [
                    [
                        'text' => $this->macro('token.go_to_site_button'),
                        'url' => $url
                    ]
                ]
            ];
        }
        elseif ($action == BotActionHelper::TOKEN_PROMOCODE_SUBSCRIBE) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('token.channel_name'),
                        'url' => $this->macro('token.channel_url'),
                    ],
                ],
                [
                    [
                        'text' => $this->macro('token.i_subscribed_button'),
                        'callback_data' => $this->MakeCallbackData(
                            TokenScreen::class,
                            'check'
                        ),
                    ]
                ]
            ];
        }
        elseif ($action == BotActionHelper::REFERRAL) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('referral.button_leaderboard'),
                        'callback_data' => $this->MakeCallbackData(
                            ReferralScreen::class,
                            'leaderboard'
                        ),
                    ],
                ],
                [
                    [
                        'text' => $this->macro('system.back_to_menu'),
                        'callback_data' => $this->MakeCallbackData(
                            StartScreen::class,
                        ),
                    ],
                ],
            ];
        }
        elseif ($action == BotActionHelper::TASKS_MENU) {
            $keyboard = [];
            $tasks = Task::query()
                ->where('season_id', Season::getIdActiveSeason())
                ->get();
            foreach ($tasks as $task) {
                $keyboard[] = [
                    [
                        'text' => $task->name,
                        'callback_data' => $this->MakeCallbackData(
                            TaskScreen::class,
                            'showTask',
                            $task->id
                        )
                    ]
                ];
            }
        }
        elseif ($action == BotActionHelper::TASKS_TOKEN) {
            $keyboard = [
                [
                    [
                        'text' => $this->macro('start.button_token'),
                        'callback_data' => $this->MakeCallbackData(
                            TokenScreen::class
                        ),
                    ],
                ],
            ];
        }
        elseif (in_array($action, [BotActionHelper::GAME, BotActionHelper::GAME_TOKEN])) {
            $url = env('GAME_URL') . '?hash=' . $this->user->game_hash;
            $url .= '&r=' . rand(1000, 99999);

            $keyboard = new InlineKeyboardMarkup([
                [
                    [
                        'text' => $this->macro('game.play_button'),
                        'web_app' => [
                            'url' => $url,
                        ]
                    ],
                ],
                [
                    [
                        'text' => $this->macro('start.button_token'),
                        'callback_data' => $this->MakeCallbackData(
                            TokenScreen::class
                        ),
                    ]
                ],
                [
                    [
                        'text' => $this->macro('game.leaderboard_button'),
                        'callback_data' => $this->MakeCallbackData(
                            GameScreen::class,
                            'leaderboard'
                        ),
                    ],
                ],
                [
                    [
                        'text' => $this->macro('system.back_to_menu'),
                        'callback_data' => $this->MakeCallbackData(
                            StartScreen::class,
                        ),
                    ],
                ],
            ]);
            $this->api->sendMessage($text, $keyboard);
            return;
        }

        if ($keyboard) {
            $keyboard = new InlineKeyboardMarkup($keyboard);
        }

        $this->api->sendMessage($text, $keyboard);
    }
}
