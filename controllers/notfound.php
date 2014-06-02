<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Modelo principal de datos, de el heredan los demas modelos.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 2.8.20140310
 */
class Notfound extends Controller {

    public function __construct() {
        parent::__construct();
        
    }
    
    public function index(){
        $data['title'] = "Pagina no encontrada";
        $data['message'] = "La pagina solicitada no esta disponible.";
        
        $this->load->view('errors/404',$data);
    }

}