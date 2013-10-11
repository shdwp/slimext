<?php
namespace SlimExt;

class SlimTwigView extends \Slim\View {
    protected $loader;
    protected $twig;
    protected $json = false;

    public function __construct($path) {
        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($this->loader);
        $this->twig->addExtension(new \Twig_Extensions_Extension_I18n());

        parent::__construct();
    }

    public function render($tpl) {
        if ($tpl == "json") {
            $this->json();
            return json_encode($this->all());
        } else {
            return $this->twig->render(
                strpos($tpl, ".") === false ? $tpl . ".html" : $tpl,
                $this->all()
            );
        }
    }

    public function getTwig() {
        return $this->twig;
    }

    public function isJson() {
        return $this->json;
    }

    public function json() {
        $this->json = true;

        return $this;
    }
}
