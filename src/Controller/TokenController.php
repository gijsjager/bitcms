<?php

namespace Bitcms\Controller;

use Cake\Controller\Controller;
use Cake\Http\Response;

class TokenController extends Controller
{
    public function get(): Response
    {
        $csrfToken = $this->getCsrfToken();
        $humanizerCode = $this->getHumanizerCode();
        return $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'csrfToken' => $csrfToken,
                'humanizerCode' => $humanizerCode
            ]));
    }

    private function getCsrfToken(): Response
    {
        // Generate a CSRF token
        $csrfToken = $this->getRequest()->getAttribute('csrfToken');
        if ($csrfToken === null) {
            $csrfToken = $this->getRequest()->getParam('_csrfToken');
        }

        return $csrfToken;
    }

    private function getHumanizerCode(): string
    {
        return md5(date($this->getRequest()->getServerParams()['REMOTE_ADDR'] . 'YYYYMMDD'));
    }
}
