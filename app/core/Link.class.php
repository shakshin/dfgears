<?php
    class DFLink {
        private $core;
        private $base;
        private $ext = False;
        private $parameters = array();
        private $options = array();
        private $flags = array();
        private $hr = True;

        public function __construct() {
            $this->core = $GLOBALS["dfcore"];
            $this->base = $this->core->config->publicURL;
            if (preg_match("/.+\/$/", $this->base) == 0) {
                $this->base .= "/";
            }
        }

        public function external($newBase) {
            $this->base = $newBase;
            if (preg_match("/.+\/$/", $this->base) == 0) {
                $this->base .= "/";
            }
            $this->ext = True;
            $this->classic();
        }

        public function param($name, $value) {
            $this->parameters[$name] = $value;
        }

        public function option($name) {
            $this->options[] = $name;
        }

        public function flag($name) {
            $this->flags[] = $name;
        }

        public function classic() {
            $this->hr = False;
        }

        public function render() {
            $url = $this->base;
            if (isset($this->core->request->parameters["alias"])) {
                $alias = $this->core->request->parameters["alias"];
            } else {
                $alias = $this->core->config->defaultObject;
            }
            if (isset($this->core->request->parameters["action"])) {
                $action = $this->core->request->parameters["action"];
            } else {
                $action = "main";
            }

            if ($this->hr) {
                foreach ($this->flags as $flag) {
                    $flag = urlencode($flag);
                    $url .= "{$flag}/";
                }
                $url .= "{$alias}/{$action}";
                foreach ($this->parameters as $name => $value) {
                    $name = urlencode($name);
                    $value = urlencode($value);
                    $url .= "/{$name}/{$value}";
                }
                foreach ($this->options as $option) {
                    $option = urlencode($option);
                    $url .= "/{$option}";
                }
            } else {
                $url .= "?";
                if (!$this->ext) {
                    $url .= "alias={$alias}&action={$action}";
                }
                foreach ($this->parameters as $name => $value) {
                    $name = urlencode($name);
                    $value = urlencode($value);
                    if (substr($url, -1) == "?") {
                        $url .= "{$name}={$value}";
                    } else {
                        $url .= "&{$name}={$value}";
                    }
                }
                foreach ($this->options as $option) {
                    
                    if (substr($url, -1) == "?") {
                        $url .= "{$option}";
                    } else {
                        $url .= "&{$option}";
                    }
                }
            }
            return $url;
        }

    }

?>
