<?php


namespace Solvari\Trengo\Api;

use GuzzleHttp\Client;
use Solvari\Trengo\Api\Traits\ContactGroup;
use Solvari\Trengo\Api\Traits\Contacts;
use Solvari\Trengo\Api\Traits\CustomFields;
use Solvari\Trengo\Api\Traits\FileUpload;
use Solvari\Trengo\Api\Traits\Labels;
use Solvari\Trengo\Api\Traits\Profiles;
use Solvari\Trengo\Api\Traits\QuickActions;
use Solvari\Trengo\Api\Traits\QuickReplies;
use Solvari\Trengo\Api\Traits\Request;
use Solvari\Trengo\Api\Traits\SmsMessages;
use Solvari\Trengo\Api\Traits\Teams;
use Solvari\Trengo\Api\Traits\Tickets;
use Solvari\Trengo\Api\Traits\Users;
use Solvari\Trengo\Api\Traits\Util;
use Solvari\Trengo\Api\Traits\Webhooks;
use Solvari\Trengo\Api\Traits\WhatsApp;


/**
 * Class Trengo
 *
 * @author Wouter Veen w.veen@solvari.com
 * @copyright Solvari B.V. 2009-2019
 * @version V1.0.0
 * @package App\Domain\Services\Trengo
 */
class Trengo
{
    /**
     * Trait list
     */
    use Request,
        Tickets,
        WhatsApp,
        FileUpload,
        Util,
        Contacts,
        Profiles,
        QuickReplies,
        QuickActions,
        Webhooks,
        CustomFields,
        Users,
        Teams,
        Labels,
        ContactGroup,
        SmsMessages;

    /*
     * Trengo channel types
     */
    CONST CHANNEL_TYPE_EMAIL    = "EMAIL";
    CONST CHANNEL_TYPE_CHAT     = "CHAT";
    CONST CHANNEL_TYPE_WA       = "WA_BUSINESS";
    CONST CHANNEL_TYPE_SMS      = "SMS";

    /*
     * Request methods
     */
    CONST GET       = "GET";
    CONST POST      = "POST";
    CONST PUT       = "PUT";
    CONST DELETE    = "DELETE";

    /*
     * Trengo api version and api url
     */
    CONST VERSION   = "v2/";

    /*
     * Trengo tickets statusses
     */
    CONST OPEN      = 'OPEN';
    CONST CLOSE     = 'CLOSE';
    CONST ASSIGNED  = 'ASSIGNED';
    CONST INVALID   = 'INVALID';

    /*
     * Array of Trengo ticket statusses
     */
    CONST TRENGO_TICKED_STATUSSES = [
        self::OPEN,
        self::CLOSE,
        self::ASSIGNED,
        self::INVALID
    ];

    /*
     * Array of Trengo Channel types
     */
    CONST CHANNELS = [
        self::CHANNEL_TYPE_CHAT,
        self::CHANNEL_TYPE_EMAIL,
        self::CHANNEL_TYPE_WA,
        self::CHANNEL_TYPE_SMS
    ];

    /**
     * @var \GuzzleHttp\Client|null
     */
    private $client = null;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('trengo.api_base_url').self::VERSION,
            'headers' =>  [
                'Authorization' => 'Bearer '.config('trengo.api_key')
            ]
        ]);
    }

    /**
     * @param string $page
     *
     * @return mixed
     */
    public function getListOfAllTeams(string $page = "0")
    {
        $response = $this->sendRequest('teams', self::GET, [
            'form_params' => [
                'page' => $page
            ]
        ]);
        return json_decode($response->getBody());
    }
}
