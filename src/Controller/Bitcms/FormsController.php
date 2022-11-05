<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 * This controller will render views from Template/Pages/
 */
class FormsController extends AppController
{

    /**
     * View method
     */
    public function submit()
    {
        $check = 'Gijs123DFSk42' . date('Ymd');
        if( $this->request->getData('humnzr') !== $check ){
            die('OK');
        }
        if( filter_var($this->request->getData('email'), FILTER_VALIDATE_EMAIL)  ){
            mail('gijsjager@gmail.com', 'Nieuw bericht vanuit dotbits.nl', print_r($this->request->getData(), true));
            die('OK');
        } else {
            die('You have entered a none-email-address.');
        }
        
    }
}
