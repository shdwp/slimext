<?php
/**
 * SlimExt
 *
 * @author Vasiliy Horbachenko <shadow.prince@ya.ru>
 * @copyright 2013 Vasiliy Horbachenko
 * @version 1.0
 * @package shadowprince/slimext
 *
 */
namespace SlimExt;

class SlimService {
    /**
     * Provide default config
     */
    public function defaultConfig($app, $config) {
        foreach ($config as $k=>$v) {
            if (!$app->config($k))
                $app->config($k, $v);
        }

        return $app;
    }
}
