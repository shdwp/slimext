<?php
namespace SlimExt;

class SlimService {
    public function defaultConfig($app, $config) {
        foreach ($config as $k=>$v) {
            if (!$app->config($k))
                $app->config($k, $v);
        }

        return $app;
    }
}
