<?php
/**
 * Simple PHP template engine with moustache syntax.
 *
 * - {{ $variable }} : outputs variable value within the HTML template
 * - {{{ PHP code }}} : executes raw PHP code within the HTML template
 */
class Template {

    /**
     * @var array $vars - an array of key:value pairs that will be used to replace the variables in the template using extract()
     */
    private $vars = [];

    /**
     * @var bool $isDevelopment - if true, the template will be rendered using a temporary file for detailed error tracing
     */
    private $isDevelopment;

    /**
     * @param bool $isDevelopment - if true, the template will be rendered using a temporary file for detailed error tracing
     */
    function __construct($isDevelopment = true) {
        $this->isDevelopment = $isDevelopment; // used to decide rendering strategy
    }


    /**
     * Set a single variable.
     * 
     * @param string $name - the name of the variable
     * @param mixed $value - the value of the variable; can be a string, integer, decimal, boolean, array, object
     * 
     * @return void
     */
    public function set(string $name, $value): void {
        $this->vars[$name] = $value;
    }


    /**
     * @param array $list - an array of key:value pairs
     * 
     * @return void
     */
    public function setArray(array $list): void {
        foreach ($list as $key => $value) {
            $this->set($key, $value);
        }
    }


    /**
     * @param string $file - the template file name for which the code and variables will be replaced
     * 
     * @return string
     */
    public function fetch(string $file): string {
        if (!is_file($file) || !is_readable($file)) {
            throw new \RuntimeException("Template file '$file' not found or not readable.");
        }

        $content = file_get_contents($file);
        if ($content === false) {
            throw new \RuntimeException("Failed to read template file '$file'.");
        }

        // Convert moustache syntax to PHP
        $content = preg_replace('/{{{(.*?)}}}/s', '<?php $1 ?>', $content);
        $content = preg_replace('/{{(.*?)}}/s', '<?php echo($1); ?>', $content);

        // Decide rendering strategy
        return $this->isDevelopment
            ? $this->renderWithTempFile($content, $file)
            : $this->renderWithEval($content);
    }

    

    /**
     * Render using eval() for deployment
     * 
     * @param string $phpCode - the PHP code to be executed
     * 
     * @return string
     */
    private function renderWithEval(string $phpCode): string {
        extract($this->vars);

        ob_start();
        try {
            eval(' ?>' . $phpCode . '<?php ');
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \RuntimeException("Error in template: " . $e->getMessage());
        }

        return ob_get_clean();
    }


    /**
     * Render using a temporary file for detailed error tracing.
     * 
     * @param string $phpCode - the PHP code to be executed
     * @param string $sourceFile - the template file name for which the code and variables will be replaced; used for error messages
     * 
     * @return string
     */
    private function renderWithTempFile(string $phpCode, string $sourceFile): string {
        extract($this->vars);

        $tempFile = tempnam(sys_get_temp_dir(), 'tpl_') . '.php';
        file_put_contents($tempFile, $phpCode);

        ob_start();
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            // include the temporary file and execute the PHP code
            include $tempFile;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \RuntimeException(
                "Error in template '$sourceFile': {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}"
            );
        } finally {
            restore_error_handler();
            unlink($tempFile);
        }

        return ob_get_clean();
    }
}
