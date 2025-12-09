<?php

namespace Bitcms\Utilities;

use Cake\Http\Client;
use Cake\Http\ServerRequest;

class Recaptcha
{
    public int $errorCode = 0;

    public function validate(ServerRequest $request): bool
    {
        // if no configuration is set, skip validation
        $secretKey = \Cake\Core\Configure::read('Recaptcha.secret', null);
        $minScore = \Cake\Core\Configure::read('Recaptcha.min_score') ?? 0.5;
        if (!$secretKey) return true;

        $recaptchaResponse = $request->getData('g-recaptcha-response', '');
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->clientIp()
        ]);
        $result = $response->getJson();

        $errorCode = 0;
        // validate response
        if (!$result || !isset($result['success'])) {
            $errorCode = 1;
        }
        // validate the score
        if ($result['success'] === false || isset($result['score']) && $result['score'] < $minScore) {
            $errorCode = 2;
        }
        // validate the hostname
        $host = explode(':', $request->host())[0];
        if (isset($result['hostname']) && $result['hostname'] !== $host) {
            $errorCode = 3;
        }

        $this->errorCode = $errorCode;

        return $errorCode === 0 ? true : false;
    }
}
