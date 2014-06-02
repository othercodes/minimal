<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Gestiona los reemplazos de variables de texto.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 2.8.20140310
 */
class Language {
    
    private $default = 'es_ES';
    /**
     * Carga el archivo de lenguaje apropiado.
     * @param string $lang codigo de lenguaje
     * @return array
     */
    private function loadLanguage($lang){
        return LANG_PATH.DS.$lang.'.php';
    }
    
    /**
     * Traduce una palabra concreta a un idioma dado.
     * @param string $ref referencia de la traduccion.
     */
    public function translate($ref){
        if(isset($_SESSION['language'])) {
            require $this->loadLanguage($_SESSION['language']);
        } else {
            require $this->loadLanguage($this->default);
        }
        if(array_key_exists($ref, $dictionary)){
            echo $dictionary[$ref];
        } else {
            echo "Translation not found";
        }
    }
}