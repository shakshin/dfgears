<?php
class DFTemplater {
    private $core;
    private $vars;
    private $path = "app/templates";
    private $prefix = "";
  
    function DFTemplater($core) {
        if (isset($core)) {
            $this->core = $core;
        } else {
            $this->core = $GLOBALS["dfcore"];
        }
    }

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
        if (empty($template)) {
            $this->core->doError("template undefined: {$this->prefix}{$template}");
        }
        if (!file_exists($this->path . "/" . $this->prefix . $template . ".template.php")) {
            $this->core->doError("template not found: {$this->prefix}{$template}");
        }
        extract($this->vars);
        include $this->path . "/" . $this->prefix . $template . ".template.php";
    }

    public function subTemplate() {
        $newTempl = new DFTemplater();
	$newTempl->path = $this->path;
	$newTempl->prefix = $this->prefix;
        return $newTempl;
    }
}

?>
