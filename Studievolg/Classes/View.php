<?php
namespace Studievolg\Classes;

/**
 * Description of View
 *
 * @author Dennis Schepers
 */
class View {
    /**
     * Contains magic values set through the __set method
     * @var mixed array 
     */
    protected $_vars = array();
    
    /**
     * Path to the view
     * @var string 
     */
    protected $_view;
    
    /**
     * path to the layout
     * @var string
     */
    protected $_layout;
    
    /**
     * Construct the view object
     * @param string $view
     */
    public function __construct($view = ""){
        
        $this->_layout = LAYOUT_PATH;
        $this->_view = $view;
    }
    
    /**
     * Set the layout of the page
     * @param String $path
     * @return \Studievolg\Classes\View
     */
    public function setLayout($path){
        $this->_layout = $path;
        return $this;
    }
    
    /**
     * Set the view of the layout
     * @param String $view
     */
    public function setView($view){
        $this->_view = $view;
    }

    /**
     * magic setter for defining fields in the view. 
     * 
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        if($key == 'content')
            throw new Exception('View->content is a reserved keyword.');
        
        $this->_vars[$key] = $value;
                
    }

    /**
     * Render the given view file inside of the layout
     */
    public function render() {
        //Extract defined vars in scope
        extract($this->_vars);
        
        ob_start();
        include($this->_view);
        $content = ob_get_contents();
        ob_end_clean();
        echo $this->_renderInLayout($content);
    }

    /**
     * Render given content in the layout.
     * 
     * @param type $content
     * @return string
     */
    protected function _renderInLayout($content) {
        
        //Extract defined vars in scope
        extract($this->_vars);
        
        ob_start();
        include($this->_layout);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

?>