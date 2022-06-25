<?php namespace Application\Missions\Admin\Api;

use Application\Entity\User;
use Atomino\Carbon\Entity;

class AuthApi extends \Atomino\Gold\AuthApi {
    //only admin role login
	public function authorize(Entity|User $user): bool { return $user->hasRole(User::ROLE_ADMIN); }
    //authenticate to login
	public function getAuthenticated(): Entity|User|null { return User::getAuthenticated(); }
    //after login, top right username
	public function getUserName(Entity|User $user): string { return $user->name; }
    //top right profile picture
	public function getUserAvatar(Entity|User $user): string|null { return $user->avatar?->first?->image->crop(64, 64)->png; }
}
