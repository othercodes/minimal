<?php defined('DACCESS') or die ('Acceso restringido!');

class Demo extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        var_dump($this);
        $data['demo'] = 'Demo';    
        $this->load->view('demo',$data);
    }

}