<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Tambah HTTP header no-cache di setiap response agar browser tidak cache halaman
$hook['post_controller_constructor'] = [
    'function' => function() {
        $CI =& get_instance();
        // Jangan cache halaman HTML
        $CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $CI->output->set_header('Pragma: no-cache');
        $CI->output->set_header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    }
];

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
