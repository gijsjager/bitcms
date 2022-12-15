<?php
/**
 * Translate string
 * @param $string
 * @param $vars
 * @return mixed|string
 */
function t($string = '', $vars = [])
{

    // check for default language
    $languages = \Cake\ORM\TableRegistry::getTableLocator()->get('Bitcms.Languages');
    $default = $languages->find()->where(['is_default' => 1])->first();
    $locale = \Cake\I18n\I18n::getLocale();
    if ($locale === $default->locale) {
        if(!empty($vars)){
            foreach($vars as $key => $var){
                $string = str_replace('{'.$key.'}', $var, $string);
            }
        }
        return $string;
    }

    $translations = \Cake\ORM\TableRegistry::getTableLocator()->get('Bitcms.Translations');


    // return translated content
    if ($translation = $translations->find()->where(['locale' => $locale, 'original' => $string])->first()) {
        $string = $translation->content;
        if(!empty($vars)){
            foreach($vars as $key => $var){
                $string = str_replace('{'.$key.'}', $var, $string);
            }
        }
        return $string;
    }

    // otherwise, add it to the table to be translated
    $translation = $translations->newEntity([
        'locale' => $locale,
        'original' => $string,
        'content' => $string
    ]);
    $translations->save($translation);

    if(!empty($vars)){
        foreach($vars as $key => $var){
            $string = str_replace('{'.$key.'}', $var, $string);
        }
    }

    return $string;
}
