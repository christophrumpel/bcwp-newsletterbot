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
     * @param \BotMan\Drivers\Facebook\Extensions\User $user
     */
    public static function createFromIncomingMessage(\BotMan\Drivers\Facebook\Extensions\User $user)
    {
        $givenUser = User::where('fb_id', $user->getId())
            ->first();

        if (! $givenUser) {
            User::updateOrCreate([
                'fb_id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'profile_pic' => $user->getProfilePic(),
                'locale' => $user->getLocale(),
                'gender' => $user->getGender(),
            ]);
        }
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
}
