<?php namespace Application\Missions\Web;

use Application\Entity\Log;
use Application\Missions\Admin\Api\PoiApi;
use Application\Missions\Admin\Api\TileApi;
use Application\Missions\Web\Api\LogApi;
use Application\Missions\Web\Api\MapApi;
use Application\Missions\Web\Api\MapApi2;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Mercury\Responder\Smart\Cache\Middleware\Cache;


class Router extends \Atomino\Mercury\Router\Router {

	public function __construct(protected SessionAuthenticator $authenticator) { }

	public function route():void{
		/*$this(method: 'GET', path: '/')?->pipe(Cache::class)->pipe(Page\Index::class);*/
        $this(method: 'GET', path: '/map/**')?->pipe(Cache::class)->pipe(Page\MapIndex::class);
        $this(path: '/map/**')?->pipe(MapApi::class);
        $this(path: '/api/log/**')?->pipe(LogApi::class);

		$this()?->pipe(Page\Error404::class);

	}

}
/*$this(method: 'GET', path: '/')?->pipe(Cache::class)->pipe(Page\Index::class);
$this(path: '/api/auth/**')?->pipe(AuthApi::class);
$this(path: '/api/dashboard/**')?->pipe(DashboardApi::class);
$this(path: '/api/user/**')?->pipe(UserApi::class);
$this(path: '/api/tile/**')?->pipe(TileApi::class);
$this(path: '/api/tile-modal/**')?->pipe(TileModalApi::class);
$this(path: '/api/poi/**')?->pipe(PoiApi::class);
$this(path: '/api/map/**')?->pipe(MapApi::class);*/