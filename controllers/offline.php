<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Controlador de sitio Offline, se activa cuando el sitio esta desactivado.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Offline extends Controller {

    function __construct() {
        parent::__construct();
   
    }

    
    public function index(){
        $data['title'] = "Sitio Desactivado";
        $data['message'] = "El sitio esta desactivo, vuelva mas tardem gracias.";
        
        $this->load->view('system/offline',$data);
    }
}