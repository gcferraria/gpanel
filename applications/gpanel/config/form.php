<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: form_template
 * ------------------------
 * Default value:
 * $config['form_template'] = form;
 *
 * Define the location of the form template.
 *
 */
 $config['form_template'] = 'form/form';

/**
 * ------------------------
 * Config: form_multisteptemplate
 * ------------------------
 * Default value:
 * $config['form_multisteptemplate'] = '';
 *
 * Define the location of the multistep for template.
 *
 */
 $config['form_multistep_template'] = 'form/forms/multistep';

/**
 * ------------------------
 * Config: fields_template
 * ------------------------
 * Default value:
 * $config['fields_template'] = form/fields;
 *
 * Define the location of the fields template.
 *
 */
 $config['fields_template'] = 'form/fields/';

/**
 * ------------------------
 * Config: allowed_fields
 * ------------------------
 * Default value:
 * $config['allowed_fields'] = array();
 *
 * Define the allowed fields to render in form.
 *
 */
 $config['allowed_fields'] = array(
        'text',
        'password',
        'select',
        'textarea',
        'datetime',
        'category',
        'wysiwyg',
        'file',
        'image',
        'email',
        'spinner',
        'tag',
        'file',
    );

/* End of file form.php */
/* Location: ../applications/gpanel/config/form.php */
