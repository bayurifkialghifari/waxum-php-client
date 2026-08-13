<?php

namespace Bayurifkialghifari\WaxumApi\Facades;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Facade;

/**
 * @see WaxumApiClient
 *
 * @method static \Bayurifkialghifari\WaxumApi\Modules\BlastModule blast()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\BlockingModule blocking()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\BotsModule bots()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\BusinessModule business()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\CallsModule calls()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\ChatStateModule chatstate()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\ContactsModule contacts()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\FleetModule fleet()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\GroupModule group()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\LabelsModule labels()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\MediaModule media()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\MessageModule message()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\MexModule mex()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\NatsModule nats()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\NewsletterModule newsletter()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\OperationModule operation()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\PresenceModule presence()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\PrivacyModule privacy()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\SchedulerModule scheduler()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\SessionModule session()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\StatusModule status()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\TagsModule tags()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\TokensModule tokens()
 * @method static \Bayurifkialghifari\WaxumApi\Modules\WebhookModule webhook()
 */
class WaxumApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WaxumApiClient::class;
    }
}
