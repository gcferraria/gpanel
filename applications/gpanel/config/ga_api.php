<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: application_name
 * ------------------------
 *
 * Google Analytics Application Name.
 */
 $config['application_name'] = 'jf-castelo';

/**
 * ------------------------
 * Config: client_id
 * ------------------------
 *
 * Google Analytics Cliente Email.
 */
 $config['account_email'] = '725859142435-jm9krm1qdhe3d5ba47bce889b6jscl2e@developer.gserviceaccount.com';

/**
 * ------------------------
 * Config: client_secret
 * ------------------------
 *
 * Google Analytics Cliente Authentication.
 */
 $config['file_location'] = APPPATH . 'config/' . ENVIRONMENT . '/jf-castelo.p12';

/**
 * ------------------------
 * Config: debug
 * ------------------------
 *
 * Default: false
 * Enable debug.
 */
 $config['debug'] = FALSE;

/**
 * ------------------------
 * Config: ga_profiles
 * ------------------------
 *
 * Default: array()
 * Map Multiple Domains and your profile id.
 */
 $config['ga_profiles'] = array(
    'jf-castelo.pt'   => '58947967',
    'sesimbracup.com' => '81432989',
 );


/* End of file ga_api.php */
/* Location: ../applications/gpanel/config/ga_api.php */
