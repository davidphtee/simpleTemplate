<?php
namespace davidphtee;

/**
 * Adapted from https://github.com/thinkphp/php-template-engine
 * 
 * With addition of double moustach for inserting variable values
 * Within in the HTML, use {{ $variable }}

 * With addition of triple moustach for executing PHP code
 *
 * For example, to loop through an array to use the values
 * {{{ forach($variable as $key=>$value): }}}
 *    {{ $key }} : {{ $value }}
 * {{{ endforeach; }}} 
 * 
 */

class Template {
    private $vars; // Holds all the template variables

    /**
     * Set a template variable, including arrays that can be traversed within the template
     * @param  string $name
     * @param  mixed $value string, array, integer, decimal, boolean
     */
    function set($name, $value) {
        $this->vars[$name] = $value;
    }


    /**
     * create individual variables from an array of key:value pairs
     *
     * @param  array $list
     */
    function setArray($list) {
        if(!is_array($list)) {
            throw new \RuntimeException("Template::setArray() expects an array: " . gettype($list) . " given.");
        }

        foreach($list as $key=>$value) {
            $this->set($key, $value);
        }
    }


    /**
     * Open, update with variable contents, and return the template file.
     *
     * @param string $file - the template file name for which the code and variables will be replaced
     */
    function fetch($file) {

        if (!file_exists($file) || !is_readable($file)) {
            throw new \RuntimeException("Template file '$file' not found or not readable.");
        }

        // Extract the vars to local namespace
        extract($this->vars);                                                   

        // Start output buffering
        ob_start();                                                             
        
        // load the file
        $templateContents = file_get_contents($file); 

        if ($templateContents === false) {
            throw new \RuntimeException("Failed to read template file '$file'.");
        }                                  

        // replace text between triple moustashe with PHP code output
        $templateContents = preg_replace('/{{{(.*?)}}}/', '<?php $1 ?>', $templateContents);    
        
        // replace text between double moustashe with PHP variable value
        $templateContents = preg_replace('/{{(.*?)}}/', '<?php echo($1);?>', $templateContents);         
        
        // eval the resultant output into the output buffer
        eval(' ?>' . $templateContents . '<?php ');                                     
        
        // Get the contents of the buffer after the PHP has been executed
        $htmlOutput = ob_get_contents();                                          
        
        // End buffering and discard
        ob_end_clean();                                                         
        
        // Return the contents with all PHP parsed and converted into HTML
        return $htmlOutput;                                                       
    }
}
