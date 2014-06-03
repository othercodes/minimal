<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Manages variables text replacements.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.3
 */
class Language {
    
    private $default;
    
    /**
     * Set the default language
     */
    public function __construct() {
        $this->default = Application::loadConfig('language');
    }

    /**
     * Traduce una palabra concreta a un idioma dado.
     * @param string $ref referencia de la traduccion.
     */
    public function translate($ref){
        if(isset($_SESSION['language'])) {
            if(!@require $this->loadLanguage($_SESSION['language'])){
                echo "Error loading ".$_SESSION['language']." translation";
            }
        } else {
            if(!@require $this->loadLanguage($this->default)){
                echo "Error loading ".$this->default." translation";
            }
        }
        if(array_key_exists($ref, $dictionary)){
            echo $dictionary[$ref];
        } else {
            echo "Translation not found";
        }
    }
    
    /**
     * Carga el archivo de lenguaje apropiado.
     * @param string $lang codigo de lenguaje
     * @return array
     */
    private function loadLanguage($lang){
        return LANG_PATH.DS.$lang.'.php';
    }
}