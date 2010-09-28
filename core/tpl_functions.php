<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
class tpl_Magic {

    private $directory;
    private $config;
    private $templates = array();
    private $variables = array();

    public function __construct($directory) {
        $this->directory = $directory;
        $this->templates['variables'] = array();
        $this->templates['tplfiles'] = array();
        $this->variables['names'] = array();
        $this->variables['values'] = array();
    }

    //__construct gives the vars already a value, otherwise we'll retrieve errors!



    protected function extension($string) {
        return strtolower(end(explode(".", $string)));
    }

    //Function which checks the extension of a file



    protected function getTplByVariable($variable) {
        return $this->templates['tplfiles'][array_search($variable, $this->templates['variables'])];
    }

    //Function which takes care of retrieving the tpl of a TPL-variable.



    protected function getValueByVarName($variable) {
        return $this->variables['values'][array_search($variable, $this->variables['names'])];
    }

    //function which takes care of retrieving the value from a replace variable.



    protected function parsingException($variable) {
        if (!in_array($variable, $this->templates['variables'])) {
            throw new Exception("ERROR: Undefined template with variable name '" . $variable . "'.");
        } elseif (!file_exists($this->directory . "/" . $this->getTplByVariable($variable)) || $this->extension($this->getTplByVariable($variable)) != "tpl") {
            throw new Exception("ERROR: Trying to parse a not existing or invalid TPL file: '" . $this->getTplByVariable($variable) . "'.");
        } elseif (substr($this->getTplByVariable($variable), 0, 2) == "..") {
            throw new Exception("ERROR: Trying to load TPL file '" . $this->getTplByVariable($variable) . "' in an directory on higher level than the assigned default map.");
        }
    }

    //Function checks whether the given tpl is correctly defined and has an associated file with it.



    public function cfg_get($variable) {
        $var = next(explode("[" . $variable . "] = \"", $this->config));
        $value = current(explode("\";", $var));
        $this->assign("{" . strtoupper($variable) . "}", $value);
        return $value;
    }

    public function define($variable, $tplfile = "") {
        if (!is_array($variable)) {
            $return = $variable;
            $variable = array($variable => $tplfile);
        }

        foreach ($variable as $key => $value) {
            $this->templates['variables'][$key] = $key;
            $this->templates['tplfiles'][$key] = $value;

            if (!preg_match("/[A-Z]([A-Z0-9]*)/", $key)) {
                die("ERROR: TPL variable '" . $key . "' contain lower-case or special characters or starts with a digit.");
            }
        }
        if (isset($return)) {
            return $return;
        }
    }

    //define a template.

    private function checkvars() {
        global $footertext, $currenttheme, $mailsetting, $registrationsetting;
        if ($footertext == "") {
            die("CMS footer loading failure");
            //$footertext = 'asaasasas';
        } elseif ($currenttheme == "") {
            die("No theme defined");
        } elseif ($mailsetting == "") {
            die("Mail settings could not be loaded");
        } elseif ($registrationsetting == "") {
            die("Registration settings could not be loaded");
        }
        return;
    }

//check the important vars which may NOT be empty

    public function assign($variable, $value = "") {
        if (!is_array($variable)) {
            $variable = array($variable => $value);
        }
        foreach ($variable as $key => $value) {
            $this->variables['names'][$key] = $key;
            $this->variables['values'][$key] = $value;
            if (!preg_match("/{[A-Z]([A-Z0-9]*)}/", $key)) {
                die("ERROR: The syntax of a replace-variable '" . $key . "' is invalid.");
            }
        }
    }

    //Create a replace variable



    public function emptyVar($variable) {
        if (!is_array($variable)) {
            $variable = array(0 => $variable);
        }
        foreach ($variable as $value) {
            if (!preg_match("/{[A-Z]([A-Z0-9]*)}/", $value)) {
                die("ERROR: The syntax of a replace-variable '" . $value . "' is invalid.");
            }

            $this->variables['names'][$value] = $value;
            $this->variables['values'][$value] = "";
        }
    }

    //With this function you can create a empty variable.



    public function parse($variable) {
        $this->checkvars();

        try {
            $this->parsingException($variable);
            $template = file_get_contents($this->directory . "/" . $this->getTplByVariable($variable));
            $template = str_replace($this->variables['names'], $this->variables['values'], $template);
            return $template;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //send the parsed template to the system.
}

?>
