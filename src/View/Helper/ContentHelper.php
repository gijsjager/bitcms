<?php

namespace Bitcms\View\Helper;

use App\Model;
use Cake\View\Helper\HtmlHelper as RootHelper;


class ContentHelper extends RootHelper {

    public $helpers = ['Html','Url','Element'];

    public function parse( $content )
    {

        // check for dynamic loader
        if( preg_match('/\[load (.*)\]/', $content, $extractLoader) ){
            $options = [];
            $parts = explode(' ', $extractLoader[1]);
            foreach($parts as $part){
                $data = explode('=', $part);
                preg_match('/"([^"]+)"/', $part, $match);
                if( !empty($data[0]) && !empty($match[1]) ){
                    $options[$data[0]] = $match[1];
                }
            }

            if( empty($options['template']) ){
                $options['template'] = 'display';
            }

            $cell = $this->_View->cell('List', [$options] )->render($options['template']);
            $content = preg_replace( '/\[load (.*)\]/', $cell, $content );

        }

        if( preg_match('/\[items (.+?)\]/', $content, $extractLoader) ){
            $extractLoader = array_pop($extractLoader);
            $extractLoader = explode(" ", $extractLoader);
            $params = array();
            foreach ($extractLoader as $d){
                list($opt, $val) = explode("=", $d);
                $params[$opt] = trim($val, '"');
            }
            $cell = $this->_View->cell('Bitcms.Items', [$params])->render();
            $content = preg_replace( '/\[items (.*)\]/', $cell, $content );
        }

        if( preg_match('/\[cell (.*)\]/', $content, $extractLoader) ){
            $cell = $this->_View->cell(ucfirst($extractLoader[1]), [] )->render();
            $content = preg_replace( '/\[cell (.*)\]/', $cell, $content );
        }

        echo $content;



    }
}
