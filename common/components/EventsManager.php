<?php

namespace common\components;

use common\helpers\Balance;
use common\models\CashBack;
use common\models\WheelOfFortuneRoll;
use Yii;
use yii\base\Component;
use common\models\User;
use common\models\LoyaltyStatus;
use common\models\Bonus;
use common\models\MessageCenter;
use common\models\Sale;
use common\models\Tournament;
use common\models\TournamentStanding;
use common\models\Popup;
use common\models\Game;
use common\models\Lottery;
use common\models\LotteryResult;
use common\models\Payment;
use common\models\Insurance;
use common\models\InsurancePayment;

class EventsManager extends Component
{
    public static $events = [
        'onUserRegistered' => 'Пользователь зарегистрирован',
        'onEmailConfirmed' => 'Email подтвержден',
        'onLoyaltySatusAchieved' => 'Новый статус лояльности',
        'onDepositAdded' => 'Добавлен депозит',
        'onPluginInstalled' => 'Установлен Plugin',
        'onTournamentWon' => 'Выигран турнир',
        'onLotteryWon' => 'Выигрыш в лотерее',
        'onPrizePointsReceived' => 'Получил бонусные баллы',
        'onPrizeX2Received' => 'Получил удвоение баллов',
        'onPrizeMoneyReceived' => 'Получил бонусные деньги на счет',
        'onFreeSpinReceived' => 'Получил фри спины',
        'onCashbackPayout' => 'Начисление cashback',
        'onWithdrawal' => 'Вывод денег',
        'onWelcomeBonusLeft' => 'N часов до окончания welcome бонуса',
        'onActiveSaleLeft' => 'N часов до окончания активной продажи',
        'onLogin' => 'При авторизации',
        'onMoneyEnd' => 'При окончании денег',
        'onWinRatingTopOne' => 'При попадании в ТОП 1',
        'onAddFreeRollWoF' => 'Получил бесплатное вращение "Колесо удачи"',
        'onBirthdayGift' => 'Получил подарок на день рождения',
        'onDemoStartLoggedIn' => 'Вход в демо игру для логина',
        'onDemoStartNotLoggedIn' => 'Вход в демо игру для нелогина',
        'onWebAppInstalled' => 'Первый заход с WebApp',
        'onInsurancePurchase' => 'Куплена страховка депозита'
    ];

    public function onUserRegistered(User $user)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    public function onEmailConfirmed(User $user)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    public function onLoyaltySatusAchieved(User $user, LoyaltyStatus $status)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    public function onDepositAdded(Payment $payment)
    {
        Insurance::checkAndBuy($payment);
        Bonus::processEvent(__FUNCTION__, $payment->user, $payment->sum, $payment->platform);
        MessageCenter::message(__FUNCTION__, $payment->user);
        Sale::onDepositAdded($payment->user, $payment->sum);
        Popup::processEvent(__FUNCTION__, $payment->user);
        CashBack::onDeposit($payment->user->id, abs($payment->sum));
        Lottery::addTickets($payment->user, $payment->sum);
    }

    public function onWithdrawal(User $user, $sum, $transactionId)
    {
        $data = ['amount' => number_format($sum, 2, '.', ''), 'transaction_id' => $transactionId];
        CashBack::onWithdrawal($user->id, abs($sum));
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);

        if ($user->isNeedSentEmail()) {
            Yii::$app->mail->sendMail($user, \common\components\Mail::TEMPLATE_SUCCESSFUL_PAYOUT, $data);
        }
    }


    public function onPrize(User $user, $sum)
    {
        $data = ['amount' => $sum];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
        CashBack::onPrize($user->id, abs($sum));
    }

    public function onCashbackPayout(User $user, $sum)
    {
        $data = ['cash_back' => $sum];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);

        if ($user->isNeedSentEmail()) {
            Yii::$app->mail->sendMail($user, Mail::TEMPLATE_CASHBACK_PAYOUT, $data);
        }
    }


    public function onPluginInstalled(User $user)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    /**
     * Событие выигрыша турнира
     * @param Tournament $tournament
     * @param TournamentStanding $standing
     */
    public function onTournamentWon(Tournament $tournament, TournamentStanding $standing)
    {
        $data = [
            'position' => $standing->position,
            'tournament' => $tournament->name,
            'prize' => $standing->prize . ' ' . ($tournament->prize_type == Tournament::PRIZE_MONEY ? Yii::$app->params['currency'] : 'баллов'),
        ];
        MessageCenter::message(__FUNCTION__, $standing->user, $data);
        Popup::processEvent(__FUNCTION__, $standing->user, $data);
        Bonus::processEvent(__FUNCTION__, $standing->user);
    }

    public function onLotteryWon(User $user, Lottery $lottery, LotteryResult $result)
    {
        $data = [
            'lottery' => $lottery->title,
            'place' => $result->place,
            'prize' => $result->prize . ' ' . Yii::$app->params['currency'],
            'ticket' => $result->ticket->public_id
        ];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    public function onPrizePointsReceived(User $user, $points_amount, $isWelcome = false)
    {
        $data = ['points_amount' => $points_amount];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    public function onPrizeX2Received(User $user, $hours, $isWelcome = false)
    {
        $data = ['hours' => $hours];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    public function onPrizeMoneyReceived(User $user, $money_sum, $money_wager, $isActiveSale = false)
    {
        $data = ['money_sum' => Balance::getMoneyPresentation($money_sum), 'money_wager' => $money_wager];
        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    public function onFreeSpinReceived(User $user, $games, $count, $isWelcome = false)
    {
        $data = [
            'games' => implode(', ', Game::getNamesArrayById($games)),
            'count' => $count,
        ];

        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    /**
     * @param User $user
     * @param integer $bonus_type_id
     * @throws \Exception
     */
    public function onWelcomeBonusLeft(User $user, $bonus_type_id)
    {
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);

        if ($user->isNeedSentEmail()) {

            $template = null;
            switch ($bonus_type_id) {
                case Bonus::WELCOME_BONUS_X2:
                    $template = Mail::TEMPLATE_WB_X2;
                    break;
                case Bonus::WELCOME_BONUS_POINTS:
                    $template = Mail::TEMPLATE_WB_POINTS;
                    break;
                case Bonus::WELCOME_BONUS_SPINS:
                    $template = Mail::TEMPLATE_WB_SPINS;
                    break;
                case Bonus::WELCOME_BONUS_PER_FD:
                    break;
                default:
                    throw new \Exception('Undefined welcome bonus!');
                    break;
            }

            if ($template) {
                Yii::$app->mail->sendMail($user, $template, []);
            }
        }
    }

    /**
     * @param User $user
     */
    public function onActiveSaleLeft(User $user)
    {
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);

        if ($user->isNeedSentEmail()) {
            Yii::$app->mail->sendMail($user, Mail::TEMPLATE_AS_10_PERCENT_OF_DEP, []);
        }
    }

    /**
     * @param User $user
     */
    public function onLogin(User $user)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    /**
     * При окончании денег на балансе
     * @param User $user
     */
    public function onMoneyEnd(User $user, $balance)
    {
        $data = ['balance' => $balance];

        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    /**
     * При попадании в ТОП 1
     * @param User $user
     * @param $sum
     */
    public function onWinRatingTopOne(User $user, $sum)
    {
        $data = ['sum' => $sum];

        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);

        if ($user->isNeedSentEmail()) {
            Yii::$app->mail->sendMail($user, Mail::TEMPLATE_WIN_RATING_TOP_ONE, $data);
        }

    }

    /**
     * При добавлении бесплатного вращения колеса удачи
     * @param User $user
     * @param integer $freeRollCnt
     */
    public function onAddFreeRollWoF(User $user, $freeRollCnt)
    {
        $data = [
            'freeRollCnt' => $freeRollCnt,
        ];

        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);
    }

    /**
     * При получении подарка на День Рождения
     * @param User $user
     * @param $template
     * @param $message
     */
    public function onBirthdayGift(User $user,$template, $message)
    {
        $data = [
            'birthdaygift' => $message,
        ];

        if ($user->isNeedSentEmail()) {
            \Yii::$app->mail->sendMail($user, $template, $data);
        }

        MessageCenter::message(__FUNCTION__, $user, $data);
        Popup::processEvent(__FUNCTION__, $user, $data);

    }

    public static function getEventsAsString($events_ids)
    {
        $titles = [];
        foreach ($events_ids as $event_id) {
            if (array_key_exists($event_id, static::$events)) {
               $titles[] = static::$events[$event_id];
            }
        }
        return implode(', ', $titles);
    }

    /**
     * @param User $user
     */
    public function onDemoStartLoggedIn(User $user)
    {
        Popup::processEvent(__FUNCTION__, $user);
    }

    public function onDemoStartNotLoggedIn()
    {
        Popup::processEvent(__FUNCTION__, null);
    }

    /**
     * Первый заход пользователя на сайт с платформой WebApp
     * @param User $user
     */
    public function onWebAppInstalled(User $user)
    {
        Bonus::processEvent(__FUNCTION__, $user);
        MessageCenter::message(__FUNCTION__, $user);
        Popup::processEvent(__FUNCTION__, $user);
    }

    public function onInsurancePurchase(InsurancePayment $insurance_payment)
    {
        $template_vars = [
            'occurrence_sum' => Balance::getMoneyPresentation($insurance_payment->occurrence_sum),
            'payout_sum' => Balance::getMoneyPresentation($insurance_payment->payout_sum),
            'duration' => $insurance_payment->insurance->duration
        ];

        MessageCenter::message(__FUNCTION__, $insurance_payment->user, $template_vars);
        Popup::processEvent(__FUNCTION__, $insurance_payment->user, $template_vars);
    }
}