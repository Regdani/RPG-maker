<?php namespace Application\Missions\Web\Page;

use Atomino\Mercury\Responder\Smart\SmartResponder;
use Atomino\Mercury\Responder\Smart\Attributes\{Cache, Args, CSS, JS, Init};
use Symfony\Component\HttpFoundation\Response;

#[Init( 'web', 'mapIndex.twig', 'mobile.twig' )]
#[Args( title: 'Atomino' )]
#[JS('/~web/index.js')]
#[CSS('/~web/index.css')]
#[Cache( 0 )]
class MapIndex extends SmartResponder{
	protected function prepare(Response $response){

    }
}

