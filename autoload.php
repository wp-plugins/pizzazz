<?php

namespace Pizzazz;

class Autoload {

    static public function init() {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    static public function load($class) {
        $classSplit = explode('\\', $class);
        if ('Pizzazz' !== $classSplit[0]) return false;
        $path = self::_loadPathToClass($classSplit);
        if (file_exists($path)) require_once($path);
    }

    static private function _loadPathToClass($class) {
        unset($class[0]);
        return PIZZAZZ_PATH . implode('/', $class) . '.php';
    }
}

Autoload::init();