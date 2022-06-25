<?php namespace Application\Missions\Web\Page;

use Atomino\Mercury\Responder\Smart\SmartResponder;
use Atomino\Mercury\Responder\Smart\Attributes\{Cache, Args, CSS, JS, Init};
use Symfony\Component\HttpFoundation\Response;

#[Init( 'web', 'index.twig', 'mobile.twig' )]
#[Args( title: 'Atomino' )]
#[JS('/~web/index.js')]
#[CSS('/~admin/index.css')]
#[Cache( 0 )]
class Index extends SmartResponder{
	public string $hello = "Hello Atomino!";
	protected function prepare(Response $response){	}
}

