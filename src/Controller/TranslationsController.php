<?php

namespace Bitcms\Controller;

use Cake\I18n\I18n;

class TranslationsController extends AppController
{
    /**
     * Index method
     * @return void
     */
    public function index()
    {
        if($this->request->is(['put', 'post'])){
            $this->store();
        }

        // check if we are on default language
        $default = $this->fetchTable('Bitcms.Languages')->find()->where(['is_default' => 1])->first();
        $this->set('is_default', $default->locale === I18n::getLocale());

        $translations = $this->Translations->find()
            ->where(['locale' => I18n::getLocale()])
            ->order(['original' => 'asc']);
        $this->set('translations', $translations);
    }

    /**
     * Store translations
     * @return void
     */
    public function store()
    {
        $this->request->allowMethod(['put', 'post']);
        $entity = $this->Translations->get($this->request->getData('id'));
        $this->Translations->patchEntity($entity, $this->request->getData());
        $this->Translations->save($entity);
    }

    /**
     * Scan for translations
     * @return \Cake\Http\Response|null
     */
    public function scan()
    {
        $languages = $this->fetchTable('Bitcms.Languages')->find();
        $stored = [];
        $path = ROOT . DS . 'templates' . DS;
        $files = $this->getDirContents($path);
        foreach ($files as $file) {
            $content = file_get_contents($file);
            preg_match_all("/ \(?t\('.*?,?'\)/", $content, $matches);
            if(!empty($matches)){
                foreach($matches[0] as $match){
                    $match = str_replace("(t('", '', $match);
                    $match = str_replace("t('", '', $match);
                    $match = str_replace("')", '', $match);
                    $match = explode(', [', $match);
                    if(!empty($match[0])){
                        foreach($languages as $language){
                            // check if already exists
                            $entity = $this->Translations->find()->where([
                                'locale' => $language->locale,
                                'original' => $match[0],
                            ])->first();
                            if(empty($entity)){
                                $entity = $this->Translations->newEntity([
                                    'locale' => $language->locale,
                                    'original' => $match[0]
                                ]);
                                $this->Translations->save($entity);
                            }
                            $stored[] = $entity->id;
                        }

                    }

                }
            }
        }
        // delete all existing that are not found anymore
        if(!empty($stored)){
            $this->Translations->deleteAll([
                'id NOT IN' => $stored
            ]);
        }

        $this->Flash->success(__('Scan completed. {0} translation(s) found!', [ count($stored)]));
        return $this->redirect(['action' => 'index']);
    }

    protected function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
            }
        }

        return $results;
    }
}
