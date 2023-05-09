<?php

namespace Vanier\Api\Controllers;
use Vanier\Api\Helpers\WebServiceInvoker;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class AveloAPIController extends WebServiceInvoker
{
    public function getBikes()
    {
        $show_uri = 'http://api.citybik.es/v2/networks/avelo-quebec';
        $data = $this->invokeUri($show_uri);
        $shows = json_decode($data);
    
        $refined_shows = [];
        foreach ($shows->network->stations as $key => $station){
            // add the station data to the refined_shows array
            $refined_shows[$key]['company'] = $station->extra->{'payment-terminal'};
            $refined_shows[$key]['empty_slots'] =  $station->empty_slots;
            $refined_shows[$key]['free_bikes'] =  $station->free_bikes;
            $refined_shows[$key]['id'] =  $station->id;
            $refined_shows[$key]['latitude'] =  $station->latitude;
            $refined_shows[$key]['longitude'] =  $station->longitude;
            $refined_shows[$key]['name'] =  $station->name;
            $refined_shows[$key]['timestamp'] =  $station->timestamp;
            // add the extra data to the refined_shows array
            $refined_shows[$key]['extra']['ebikes'] = $station->extra->ebikes;
            $refined_shows[$key]['extra']['has_ebikes'] = $station->extra->has_ebikes;
            $refined_shows[$key]['extra']['last_updated'] = $station->extra->last_updated;
            $refined_shows[$key]['extra']['payment'] = $station->extra->payment;
            $refined_shows[$key]['extra']['payment-terminal'] = $station->extra->{'payment-terminal'};
            $refined_shows[$key]['extra']['renting'] = $station->extra->renting;
            $refined_shows[$key]['extra']['returning'] = $station->extra->returning;
            $refined_shows[$key]['extra']['slots'] = $station->extra->slots;
            $refined_shows[$key]['extra']['uid'] = $station->extra->uid;
        }
        return $refined_shows;
    }
    
}
