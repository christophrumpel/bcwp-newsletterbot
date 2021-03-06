<?php

namespace App;

use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fb_id',
        'first_name',
        'last_name',
        'profile_pic',
        'gender',
        'locale',
    ];

    /**
     * Create or update user
     *
     * @param $user
     */
    public static function createFromIncomingMessage($user)
    {
        User::updateOrCreate(['fb_id' => $user->getId()], [
            'fb_id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
        ]);
    }

    /**
     * Subscribe user to newsletter
     *
     * @param string $facebookId
     */
    public static function subscribe(string $facebookId)
    {
        $user = User::where('fb_id', $facebookId)
            ->first();

        if ($user) {
            $user->subscribed = true;
            $user->save();
        }
    }

    /**
     * Unsubscribe user from newsletter
     *
     * @param string $facebookId
     */
    public static function unsubscribe(string $facebookId)
    {
        $user = User::where('fb_id', $facebookId)
            ->first();

        if ($user) {
            $user->subscribed = false;
            $user->save();
        }
    }

    /**
     * Get subscribers or admin if it is for debugging
     *
     * @param null $debug
     * @return mixed
     */
    public static function getSubscribers($debug = null)
    {
        if ($debug) {
            return User::where('admin', true)
                ->get();
        }

        return User::where('subscribed', true)
            ->get();
    }

}
