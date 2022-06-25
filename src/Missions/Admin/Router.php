<?php namespace Application\Missions\Admin;

use Application\Missions\Admin\Api\AuthApi;
use Application\Missions\Admin\Api\DashboardApi;
use Application\Missions\Admin\Api\PoiApi;

use Application\Missions\Admin\Api\TileApi;
use Application\Missions\Admin\Api\TileModalApi;
use Application\Missions\Admin\Api\UserApi;
use Application\Missions\Admin\Api\MapApi;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Mercury\Responder\Smart\Cache\Middleware\Cache;

class Router extends \Atomino\Mercury\Router\Router {

	public function __construct(protected SessionAuthenticator $authenticator) { }

	public function route():void{
        $this(method: 'GET', path: '/')?->pipe(Cache::class)->pipe(Page\Index::class);
        $this(path: '/api/auth/**')?->pipe(AuthApi::class);
        $this(path: '/api/dashboard/**')?->pipe(DashboardApi::class);
        $this(path: '/api/user/**')?->pipe(UserApi::class);
        $this(path: '/api/tile/**')?->pipe(TileApi::class);
        $this(path: '/api/tile-modal/**')?->pipe(TileModalApi::class);
        $this(path: '/api/poi/**')?->pipe(PoiApi::class);
        $this(path: '/api/map/**')?->pipe(MapApi::class);

	}

}
