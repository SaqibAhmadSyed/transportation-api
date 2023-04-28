<?php

namespace Vanier\Api\Controllers;
use Vanier\Api\Helpers\WebServiceInvoker;

class BikeAPIController extends WebServiceInvoker
{
    public function getBikes()
    {
        $show_uri = 'https://api.tvmaze.com/shows';
        $data = $this->invokeUri($show_uri);
        $shows = json_decode($data);

        $refined_shows = [];

        foreach ($shows as $key => $show){
            //add the same line based on the info we want to have 
            $refined_shows[$key]['name'] = $show->name;
            //array in an array
            $refined_shows[$key]['genres'] = implode(', ', $show->genres);
            //to add uri
            $refined_shows[$key]['uri'] = $show_uri.'/'.$show->id;
        }
        return $refined_shows;
    }
}
