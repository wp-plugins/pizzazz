<?php

namespace pizzazz;

class Autoload {

    static public function init() {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    static public function load($class) {
        $classSplit = explode('\\', strtolower($class));
        if('pizzazz' !== array_shift($classSplit)) return false;
        $path = self::_loadPathToClass($classSplit);
        if(! file_exists($path)) {
            $message = sprintf(__('Error! File does not exist: %s', 'pizzazz'), $path);
            throw new \Exception($message);
        }
        require($path);
    }

    static private function _loadPathToClass($class) {
        return PIZZAZZ_PATH . implode('/', $class) . '.php';
    }
}

Autoload::init();