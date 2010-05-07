<?php
class DFTemplater {
    private $vars;
    private $path = "app/templates";
    private $prefix = "";

    public function assign($varName, $varValue) {
        $this->vars[$varName] = $varValue;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix . "/";
    }

    public function fetch($template) {
        ob_start();
        $this->display($template);
        $response =  ob_get_contents();
        
        ob_end_clean();
        return $response;
    }

    public function display($template) {
        if (!file_exists($this->path . "/" . $prefix . $template . ".template.php")) {
            throw new Exception("Template not found");
        }
        include $this->path . "/" . $prefix . $template . ".template.php";
    }

    public function subTemplate() {
        $newTempl = new DFTemplater();
	$newTempl->path = $this->path;
	$newTempl->prefix = $this->prefix;
        return $newTempl;
    }
}

?>
