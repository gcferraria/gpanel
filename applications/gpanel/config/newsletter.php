<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------
 * Config: from_emails
 * ------------------------
 * Default value:
 * $config['newsletter_from_emails'] = '';
 *
 * Define the available emails for send newsletters.
 */
 $config['newsletter_from_emails'] = array(
    'No Reply - Junta de Freguesia do Castelo' => 'no_reply@jf-castelo.pt',
    'Junta de Freguesia do Castelo' 		   => 'geral@jf-castelo.pt' ,
    'Sesimbra Summer Cup'  					   => 'sesimbracup@jf-castelo.pt',
 );

/**
 * ------------------------
 * Config: templates
 * ------------------------
 * Default value:
 * $config['newsletter_templates'] = '';
 *
 * Define the available templates.
 */
 $config['newsletter_templates'] = array(
    'Atualidade' => 'news',
 );

/**
 * ------------------------
 * Config: websites
 * ------------------------
 * Default value:
 * $config['newsletter_websites'] = '';
 *
 * Define the available websites for select contents.
 */
 $config['newsletter_websites'] = array(
    'http://www.jf-castelo.pt'   => '/sites/jfc/',
    'http://www.sesimbracup.com' => '/sites/ssc/',
 );

/**
 * ------------------------
 * Config: content types
 * ------------------------
 * Default value:
 * $config['newsletter_content_typess'] = '';
 *
 * Define the available content types for populate the template.
 */
 $config['newsletter_content_types'] = array('new','event');

/**
 * ------------------------
 * Config: templates_path
 * ------------------------
 * Default value:
 * $config['newsletter_templates_path'] = '';
 *
 * Define the path of the newsletter templates
 */
 $config['newsletter_templates_path'] = '_templates/newsletter';