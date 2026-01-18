<?php

namespace Bitcms\Controller;

use Cake\Controller\Controller;
use Cake\Http\Response;

class CsrfTokenController extends Controller
{
    public function getToken(): Response
    {
        // Generate a CSRF token
        $csrfToken = $this->getRequest()->getAttribute('csrfToken');
        if ($csrfToken === null) {
            $csrfToken = $this->getRequest()->getParam('_csrfToken');
        }

        // Return the token as a JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'csrfToken' => $csrfToken
        ]));
    }
}
