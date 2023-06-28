<?php

namespace Sevenspan\Bunny;

use Sevenspan\Bunny\Exception\CustomException;

class Bunny
{

    public static function generateToken($media_path = null, $expireTime, $apikey)
    {
        // Generate the token
        $hashableBase = $apikey . '/' . $media_path . $expireTime;

        $token = md5($hashableBase, true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token);
        return $token;
    }


    public static function generatePrivateImageUrl($media_path, $expires = null)
    {

        $apikey = config('bunny.api_key');
        $signed_URL = config('bunny.signed_url');

        if (empty($apikey)) {
            throw new CustomException("api key is required", 400);
        }

        if (empty($signed_URL)) {
            throw new CustomException("signed url is required", 400);
        }

        if (empty($expires)) {

            $expires = time() + config('bunny.expiration_time');
        } else {
            $expires = time() + $expires;
        }


        if (empty($media_path)) {
            throw new CustomException("media path is required.", 400);
        }

        $token = self::generateToken($media_path, $expires, $apikey, $signed_URL);

        if (empty($token)) {
            throw new CustomException("token is required.", 400);
        }

        $signed_URL = config('bunny.signed_url');

        if (empty($signed_URL)) {
            throw new CustomException("signed url is required", 400);
        }


        // Generate the URL
        $url = "$signed_URL/{$media_path}?token={$token}&expires={$expires}";
        return $url;
    }
}
