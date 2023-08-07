<?php
namespace App\Http\Controllers\traid;

use App\Models\discount;
use App\Models\Forfirebase;
use App\Models\Item;
use App\Models\Shopowner;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait ykcheckbot
{
    public function isbotdetectbyyk($useragent)
    {
        $res = '';

        try {
            $checkfromapi = \Illuminate\Support\Facades\Http::get("https://whatmyuseragent.com/api?ua=".$useragent."&key=NOTREQUIED");
            $res = $checkfromapi;

        } catch (Exception $e) {
            $res = 'cant detect';
        }
        if ($res != 'cant detect') {
            if (empty($res['os']['name']) or $res['device']['isBot'] == true or $res['os']['name'] == 'Ubuntu' or $res['os']['name'] == 'GNU/Linux') {
                return 'yes';
            } else {
                return $this->recheckbystring($useragent);
            }
        } else {
            return $this->recheckbystring($useragent);
        }

    }
    public function recheckbystring($useragent){
        if(Str::contains($useragent, ['Python/3.10 aiohttp/3.8.1',
            'ZaldamoSearchBot(www.zaldamo.com/search.html)',
            'Python/3.6 aiohttp/3.8.3',
            'Python/3.8 aiohttp/3.4.4',
            'Python/3.8 aiohttp/3.4.4',
            'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)',
            'Mozilla/5.0 MalShare Crawler',
            'panscient.com',
            'Python-urllib/2.6',
            '"Mozilla/5.0 (Windows NT 6.1',
            'Python-urllib/2.7',
            'Python-httplib2/0.15.0 (gzip)',
            'TelegramBot (like TwitterBot)',
            'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)',
            'WebZIP/3.5 (http://www.spidersoft.com)',
            'Wget/1.12 (linux-gnu)',
            'Wget/1.20.3 (linux-gnu)',
            'Wget/1.21.2','Spider_Bot/3.0',
            'test',
            'YandexBot',
            'bitlybot/3.0 (+http://bit.ly/)',
            'l9tcpid',
            'l9explore',
            'CensysInspect',
            'curl',
            'InternetMeasurement',
            'Viber',
            'WhatsApp',
            'Go-http-client',
            'CensysInspect',
            'ViberUrlDownloader',
            'a Palo Alto Networks company',
            'http://dev.hubspot.com/','Googlebot',
            'PetalBot',
            'AhrefsBot',
            'zgrab',
            'facebookexternalhit',
            'bingbot',
            'python-requests',
            'Python/3.10 aiohttp/3.8.1',
            'Netwalk research scanner - netwalk.ankweb.exposed -',
            'Barracuda Sentinel (EE)',
            'MUDV4',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.7 Safari/537.36',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:88.0) Gecko/20100101 Firefox/88.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:101.0) Gecko/20100101 Firefox/101.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:100.0) Gecko/20100101 Firefox/100.0'


        ])){
            return 'yes';
        }else{
            return 'no';
        }
    }
}

?>
