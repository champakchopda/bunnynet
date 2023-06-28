<?php

namespace Sevenspan\Bunny;

use Sevenspan\Bunny\Exception\CustomException;

class Bunny
{

    public function generateToken($media_path = null)
    {
        $apikey = config('bunny.api_key');

        $signed_URL = config('bunny.signed_url');
        $expireTime = config('bunny.expiration_time');
        $expireTime = time() + $expireTime;
        $media_path = "builditindialogo.jpg";
        if (empty($signed_URL)) {
            throw new CustomException("signed url is required", 400);
        }

        if (empty($media_path)) {
            throw new CustomException("media path is required.", 400);
        }

        if (empty($apikey)) {
            throw new CustomException("api key is required", 400);
        }


        // Generate the token


        $hashableBase = $apikey . '/'.$media_path . $expireTime;

        $token = md5($hashableBase, true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token);
        return $token;
    }


    public static function generatePrivateImageUrl($media_path, $token, $expires = null)
    {
        if (empty($media_path)) {
            throw new CustomException("media path is required.", 400);
        }

        if (empty($token)) {
            throw new CustomException("token is required.", 400);
        }

        $signed_URL = config('bunny.signed_url');

        if (empty($signed_URL)) {
            throw new CustomException("signed url is required", 400);
        }

        $expires = config('bunny.expiration_time');
        $expires = time() + $expires;


        // Generate the URL
        $url = "$signed_URL{$media_path}?token={$token}&expires={$expires}";
        return $url;
    }
}
