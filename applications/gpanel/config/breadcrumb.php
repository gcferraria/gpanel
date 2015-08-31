<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: home_icon
 * ------------------------
 * Default value:
 * $config['home_icon'] = "";
 *
 * Change initial home icon.
 * If set to empty e.g: $config['home_icon'] = "";
 * then initial/home icon breadcrumb will disappear
 *
 */
 $config['home_icon'] = '<i class="fa fa-home"></i> ';

/**
 * ------------------------
 * Config: home_text
 * ------------------------
 * Default value:
 * $config['home_text'] = "";
 *
 * Change initial breadcrumb Text.
 * If set to empty e.g: $config['home_text'] = "";
 * then initial/home breadcrumb will disappear
 *
 */
 $config['home_text'] = 'In&iacute;cio';

/**
 * ------------------------
 * Config: home_link
 * ------------------------
 * Default value:
 * $config['home_link'] = "";
 *
 * Change initial breadcrumb link.
 * If set to empty e.g: $config['home_link'] = "";
 * then initial/home breadcrumb link will disappear
 *
 */
 $config['home_link'] = 'dashboard';

/**
 * ------------------------
 * Config: unlink home
 * ------------------------
 * Default value:
 * $config['unlink_home'] = FALSE;
 *
 * If set to TRUE then your home will have no link
 */
 $config['unlink_home'] = FALSE;

/**
 * -----------------------
 * Config: Delimiter
 * ------------------------
 * Default value:
 * $config['delimiter'] = ' >> ';
 */
 $config['divider'] = '<i class="fa fa-angle-right"></i>';

/**
 * --------------------------
 * Config: Wrapper
 * --------------------------
 * Default value:
 * $config['use_wrapper'] = FALSE;
 * $config['wrapper'] = '<ul>|</ul>';
 * $config['wrapper_inline'] = '<li>|</li>';
 *
 * We set this if we want to make breadcrumb have it's own style.
 * it possible to return the breadcrumb in a list (<ul><li></li></ul>) or something else as configure below.
 * Set use_wrapper to TRUE to use this feature.
 */
 $config['use_wrapper']    = FALSE;
 $config['wrapper']        = '<ul class="breadcrumbs">|</ul>';
 $config['wrapper_inline'] = '<li>|</li>';

/* End of file breadcrumb.php */
/* Location: ../applications/gpanel/config/breadcrumb.php */
