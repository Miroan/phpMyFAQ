<?php
/**
 * Handle ajax requests for the interface translation tool
 * 
 * @package    phpMyFAQ
 * @subpackage Administration
 * @author     Anatoliy Belsky <ab@php.net>
 * @since      2009-05-12
 * @copyright  2003-2009 phpMyFAQ Team
 * @version    SVN: $Id$
 *
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 */
if (!defined('IS_VALID_PHPMYFAQ_ADMIN')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$ajax_action = PMF_Filter::filterInput(INPUT_GET, 'ajaxaction', FILTER_SANITIZE_STRING);

switch($ajax_action) {
    case 'save_translated_lang':
        
        $lang = $_POST['PMF_LANG']['metaLanguage'];
        $filename = PMF_ROOT_DIR . "/lang/language_$lang.php";       
        
        $newFileContents = '';
        /**
         * Read in the head of the file we're writing to
         */
        $fh = fopen($filename, 'r');
        $line = '';
        do {
            $line = fgets($fh);
            $newFileContents .= $line;
        }
        while('*/' != trim($line));
        fclose($fh);
        
        /**
         * Build language variable definitions
         */
        foreach($_POST['PMF_LANG'] as $key => $val) {
            if(is_string($val)) {
                $val = str_replace(array('\\\\', '\"', '\\\''), array('\\', '"', "'"), $val);
                $val = str_replace("'", "\\'", $val);
                $newFileContents .= "\$PMF_LANG['$key'] = '$val';\n";
            } else if(is_array($val)) {
                /**
                 * Here we deal with a two dimensional array
                 */
                foreach($val as $key2 => $val2) {
                    $newFileContents .= "\$PMF_LANG['$key']['$key2'] = '$val2';\n";
                }
            }
        }
        
        foreach($_POST['LANG_CONF'] as $key => $val) {
            $newFileContents .= "\$LANG_CONF['$key'] = $val;\n";
        }
        
        file_put_contents($filename, $newFileContents);
    break;
}

?>