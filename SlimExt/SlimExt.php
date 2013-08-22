<?php
namespace SlimExt;

class SlimExt extends \Slim\Slim {
    protected $router_prefix = null;

    protected function applyPrefix() {
        $args = func_get_args();
        if ($this->router_prefix != null) { 
            $args[0] = $this->router_prefix . $args[0];
        }
        return $args;
    }

    public function get() {
        return call_user_func_array("Parent::get", 
            call_user_func_array([$this, "applyPrefix"], func_get_args()));
    }

    public function post() {
        return call_user_func_array("Parent::post", 
            call_user_func_array([$this, "applyPrefix"], func_get_args()));
    }

    public function map() {
        return call_user_func_array("Parent::map", 
            call_user_func_array([$this, "applyPrefix"], func_get_args()));
    }

    public function prefix($prefix, $setups) {
        $this->router_prefix = $prefix;
        call_user_func($setups);
        $this->router_prefix = null;
    }

    public function register($name, $service, $setup=null) {
        $this->services[$name] = $service;
        if ($setup !== null) {
            call_user_func_array($setup, [$service]);
        }
    }

    public function getCC($path) {
        if (strpos($path, "\\") === false) {
            $path = explode('.', $path); // @TODO
            if (count($path) == 2) {
                $path = [
                    $path[0],
                    'Model',
                    $path[1],
                    ]; 
            }

            #$path = array_merge([$this->config('namespace')], $path);
            return implode("\\", $path);
        } else {
            return $path;
        }
    }

    public function loadComponent($path) {
        global $app;
        $urls = $path . DIRECTORY_SEPARATOR . 'urls.php';
        if (is_file($urls)) {
            include_once $urls;
        }
    }

    public function loadComponents() {
        if (is_array($this->config('comps'))) 
            foreach ($this->config('comps') as $comp) {
                $this->loadComponent(realpath($comp));
            }
    }
}
