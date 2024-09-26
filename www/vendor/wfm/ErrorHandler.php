<?php

namespace wfm;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->logErrors($errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
    }
    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR)) {
            ob_end_clean();
            $this->logErrors($error['message'], $error['file'], $error['line']);
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }
    public function exceptionHandler(\Throwable $e)
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError("Exception", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }
    protected function logErrors($message = '', $file = '', $line = '')
    {
        $str = "[%s] Message: %s\n - File: %s | Line: %s\n\n";
        $format = sprintf($str, date('Y-m-d H:i:s'), $message, $file, $line);
        if (!is_dir(LOGS))
            mkdir(LOGS, 0777, true);
        file_put_contents(LOGS . '/error.log', $format ,FILE_APPEND);
    }
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        if ($response == 0) {
            $response = 404;
        }
        http_response_code($response);
        if ($response == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die;
        }
        if (DEBUG) {
            require WWW . '/errors/development.php';
        } else {
            require WWW. '/errors/production.php';
        }
        die;
    }
}





















