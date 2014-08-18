<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Default "offline" controller here you can custom the 
 * offline page.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Offline extends Controller {

    function __construct() {
        parent::__construct();
   
    }

    
    public function index(){
        // set message
        $data['title'] = "The site is offline";
        $data['message'] = "The site is under maintenance, come back later, thanks";
        // load data in the template
        $this->load->view('system/offline',$data);
    }
}