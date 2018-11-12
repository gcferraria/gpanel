<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ------------------------
 * Config: upload_path
 * ------------------------
 * Default value:
 * $config['upload_path'] = "";
 *
 * The path to the folder where the upload should be placed.
 * The folder must be writable and the path can be absolute or relative.
 *
 */
 $config['upload_path'] = HOMEPATH . '/public_html/static/jfcastelo';

/**
 * ------------------------
 * Config: allowed_types
 * ------------------------
 * Default value:
 * $config['allowed_types'] = "";
 *
 * The mime types corresponding to the types of files you allow to be uploaded.
 * Usually the file extension can be used as the mime type.
 * Separate multiple types with a pipe.
 *
 */
 $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ai|mp4';

/**
 * ------------------------
 * Config: file_name
 * ------------------------
 * Default value:
 * $config['file_name'] = "";
 *
 * If set CodeIgniter will rename the uploaded file to this name.
 * The extension provided in the file name must also be an allowed file type.
 *
 */
 $config['file_name'] = '';

/**
 * ------------------------
 * Config: overwrite
 * ------------------------
 * Default value:
 * $config['overwrite'] = "FALSE";
 *
 * If set to true, if a file with the same name as the one you are uploading exists,
 * it will be overwritten. If set to false, a number will be appended to the filename
 * if another with the same name exists.
 *
 */
 $config['overwrite'] = 'FALSE';

/**
 * ------------------------
 * Config: max_size
 * ------------------------
 * Default value:
 * $config['max_size'] = "0";
 *
 * The maximum size (in kilobytes) that the file can be.
 * Set to zero for no limit. Note: Most PHP installations have their own limit,
 * as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.
 *
 */
 $config['max_size'] = '32000'; // 32MB

/**
 * ------------------------
 * Config: max_width
 * ------------------------
 * Default value:
 * $config['max_width'] = "0";
 *
 * The maximum width (in pixels) that the file can be. Set to zero for no limit.
 *
 */
 $config['max_width'] = '0';

/**
 * ------------------------
 * Config: max_height
 * ------------------------
 * Default value:
 * $config['max_height'] = "0";
 *
 * The maximum height (in pixels) that the file can be. Set to zero for no limit.
 *
 */
 $config['max_height'] = '0';

/**
 * ------------------------
 * Config: max_filename
 * ------------------------
 * Default value:
 * $config['max_filename'] = "0";
 *
 * The maximum length that a file name can be. Set to zero for no limit.
 *
 */
 $config['max_filename'] = '0';

/**
 * ------------------------
 * Config: encrypt_name
 * ------------------------
 * Default value:
 * $config['encrypt_name'] = "FALSE";
 *
 * If set to TRUE the file name will be converted to a random encrypted string.
 * This can be useful if you would like the file saved with a name that can not be
 * discerned by the person uploading it.
 *
 */
 $config['encrypt_name'] = FALSE;

/**
 * ------------------------
 * Config: remove_spaces
 * ------------------------
 * Default value:
 * $config['remove_spaces'] = "TRUE";
 *
 * If set to TRUE, any spaces in the file name will be converted to underscores.
 * This is recommended.
 *
 */
 $config['remove_spaces'] = TRUE;