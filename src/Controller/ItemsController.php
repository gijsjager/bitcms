<?php
namespace App\Controller;

class ItemsController extends AppController
{
    public function view($slug)
    {
        $page = $this->Items->find()->where([
            $this->Items->translationField('slug') => $slug,
            'online' => true
        ])->contain([
            'Images',
        ]);


        // 404 page
        if( $page->isEmpty() ){
            return $this->redirect(['lang' => $this->request->getParam('lang'), 'controller' => 'Pages', 'action' => 'notfound', 'url' => $this->request->getRequestTarget()]);
        }

        $page = $page->first();
        $navigation = $this->getNavigation($page->id);

        $this->set('page', $page);
        $this->set('navigation', $navigation);
        $this->set('seo_title', (!empty($page->seo_title)) ? $page->seo_title : $page->title);
        $this->set('seo_description', $page->seo_description);
    }

    protected function getNavigation( $currentId = 0 ){
        $itemIds = $this->Items->find('list', ['valueField' => 'id'])->where([
            'online' => true
        ])->toArray();


        $previous = null;
        $next = null;
        $found = false;
        if( !empty($itemIds) ){
            foreach($itemIds as $id){

                if( $found === true ){
                    $next = $id;
                    break;
                }

                if( $id === $currentId ){
                    $found = true;
                } else {
                    $previous = $id;
                }
            }


            if( $previous === null ){
                $previous = end($itemIds);
            }
            if( $next === null ){
                $next = reset($itemIds);
            }

            $previous = $this->Items->findById($previous)->first();
            $next = $this->Items->findById($next)->first();

        }

        return ['previous' => $previous, 'next' => $next];
    }
}
