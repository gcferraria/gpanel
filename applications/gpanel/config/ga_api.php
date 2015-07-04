<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: profile_id
 * ------------------------
 *
 * Google Analytics Profile ID.
 */
 $config['profile_id'] = '';

/**
 * ------------------------
 * Config: email
 * ------------------------
 *
 * Google Analytics Account Email.
 */
 $config['email'] = 'freguesia.castelo@gmail.com';

/**
 * ------------------------
 * Config: password
 * ------------------------
 *
 * Google Analytics Account Password.
 */
 $config['password'] = 'e23ppb3t';

/**
 * ------------------------
 * Config: cache_data
 * ------------------------
 *
 * Default: false
 * Indicate if request will be cached.
 */
 $config['cache_data'] = false; // request will be cached

/**
 * ------------------------
 * Config: cache_folder
 * ------------------------
 *
 * Default: '/cache'
 * Cache destination folder with permissons read/write.
 */
 $config['cache_folder'] = '';

/**
 * ------------------------
 * Config: clear_cache
 * ------------------------
 *
 * Default: array('date', '1 day ago')
 * Cache expiration time.
 */
 $config['clear_cache'] = array('date', '1 day ago');

/**
 * ------------------------
 * Config: debug
 * ------------------------
 *
 * Default: false
 * Enable debug.
 */
 $config['debug'] = false;

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
