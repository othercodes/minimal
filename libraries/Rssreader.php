<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * RSS class reader.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Rssreader {

    private $xml;
    public $channel = array();
    private $limit = 5;
    
    /**
     * Class constructor
     * @param string $xml url of the rss
     */
    function __construct($xml = null) {
        $this->loadXml($xml);
    }
     
    /**
     * Load the xml intro the class to work with it.
     * @param string $xml url of the rss
     * @return boolean
     */
    public function loadXml($xml){
        if($xml){
            $this->xml = new DOMDocument();
            $this->xml->load($xml);
        } else  {
            return FALSE;
        }
    }    
    
    /**
     * Explode the xml to find the items and return them like an array.
     * @param int $limit number of items displayed
     * @return array
     */
    public function parseXml($limit = null){
        if($limit){
            $this->limit = $limit;
        }
        
        $channel = $this->xml->getElementsByTagName('channel')->item(0);
        $this->channel['title'] = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $this->channel['url'] = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
        $this->channel['description'] = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

        $item = $this->xml->getElementsByTagName('item');

        for ($i=0; $i<=$this->limit; $i++) {
            $this->channel['notices'][$i]['title'] = $item->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $this->channel['notices'][$i]['url'] = $item->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
            $this->channel['notices'][$i]['description'] = $item->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
        }
        return $this->channel;
    }

}
?>
