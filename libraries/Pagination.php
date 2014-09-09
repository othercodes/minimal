<?php defined('DACCESS') or die ('Acceso restringido!');

class Pagination {
    
    private $total;
    private $perpage;
    private $pages;
    private $url;
    private $current;
    private $params;
    
    /**
     * Set the current url.
     */
    public function __construct() {
        $this->current = $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Configura la clase para construir los 
     * enlaces de paginacion.
     * @param int $total total de registros a paginar   
     * @param int $perpage registros por pagina
     * @param string $url url base donde se paginaran
     * @param string $params prametros de paginacion.
     */
    public function configure($total, $perpage, $url,$params){
        $this->total    = $total;
        $this->perpage  = $perpage;
        $this->url      = $url;
        $this->pages    = ceil($total / $perpage);
        $this->params   = $params;
    }
    
    /**
     * Crear un array de objetos con los datos de paginacion.
     * @return array
     */
    public function buildPagination(){
        $pagination = array();
        for($i=0;$i<$this->pages;$i++){
            $url = $this->url.$this->params.$this->perpage * ($i);
            $base = Url::basePath().$this->url;
            if($this->current == Url::basePath().$url || $this->current == $base && $i == 0){ 
                $active = TRUE;
            } else {
                $active = FALSE;
            }
            $pagination[$i] = (object) array(
                'num'       => $i+1,
                'link'      => $url,
                'active'    => $active
            );
        }
        return $pagination;
    }
    
    
}
