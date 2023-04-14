<?php
/**
 * Translate string
 * @param string $string
 * @param array $vars
 * @return string
 */
function t(string $string = '', array $vars = []): string
{
    $locale = \Cake\I18n\I18n::getLocale();
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
