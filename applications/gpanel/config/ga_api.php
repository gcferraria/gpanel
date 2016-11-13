<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: application_name
 * ------------------------
 *
 * Google Analytics Application Name.
 */
 $config['application_name'] = 'ga-project';

/**
 * ------------------------
 * Config: client_id
 * ------------------------
 *
 * Google Analytics Cliente Email.
 */
 $config['account_email'] = 'account-5@api-project-725859142435.iam.gserviceaccount.com';

/**
 * ------------------------
 * Config: client_secret
 * ------------------------
 *
 * Google Analytics Cliente Authentication.
 */
 $config['file_location'] = APPPATH . 'config/ga-config.p12';

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
    'jf-castelo.pt'    => '58947967',
    'sesimbracup.com'  => '81432989',
    'casagraciano.pt'  => '111723763',
    'fascinioclub.com' => '56065546',
    'nautibras.pt'     => '128365160',
 );


/* End of file ga_api.php */
/* Location: ../applications/gpanel/config/ga_api.php */
