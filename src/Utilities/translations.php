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
    if ($translation = $translations->find()->where(['locale' => $locale, 'template_key' => $string])->first()) {
        $string = (string)$translation->content;
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
        'template_key' => $string,
    ]);
    $translations->save($translation);

    // try to find a translation in the default language
    $translation = $translations->find()->where(['template_key' => $string, 'content !=' => ''])->first();
    if (!empty($translation->content)) {
        $string = (string)$translation->content;
    }

    if(!empty($vars)){
        foreach($vars as $key => $var){
            $string = str_replace('{'.$key.'}', $var, $string);
        }
    }

    return $string;
}
