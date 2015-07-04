<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GP_Router extends CI_Router {

    /**
     * _validate_request: Validates the supplied segments. Attempts to determine the path to
     *                    the controller.
     *
     * @access private
     * @param  array
     * @return array
     */
    function _validate_request( $segments ) {

        if ( count( $segments ) == 0 )
            return $segments;

        // Does the requested controller exist in the root folder?
        if ( file_exists( APPPATH . 'controllers/' . $segments[0] . EXT ) )
            return $segments;

        // Is the controller in a sub-folder?
        if ( is_dir( APPPATH . 'controllers/' . $segments[0] ) ) {

            $dir = '';
            do {
                if ( strlen( $dir ) > 0 )
                    $dir .= '/';

                $dir .= array_shift( $segments );
            } while ( count( $segments ) > 0
                && is_dir(  APPPATH . 'controllers/' . $dir . '/' . $segments[0] )
                && ( isset( $segments[1] ) && is_file( APPPATH . 'controllers/' . $dir . '/' . $segments[0] . '/' . $segments[1] . '.php' ) )
            );

            // Set the directory and remove it from the segment array
            $this->set_directory($dir);

            if ( count( $segments ) > 0 && ! file_exists( APPPATH . 'controllers/' . $this->fetch_directory() . $segments[0] . EXT ) )
                array_unshift($segments, $this->default_controller);

            if ( count( $segments ) > 0 ) {

                // Does the requested controller exist in the sub-folder?
                if ( ! file_exists( APPPATH . 'controllers/' . $this->fetch_directory() . $segments[0] . EXT ) )
                    $this->directory = '';
            }
            else {

                // Is the method being specified in the route?
                if ( strpos( $this->default_controller, '/') !== FALSE ) {
                    $x = explode('/', $this->default_controller);

                    $this->set_class($x[0]);
                    $this->set_method($x[1]);
                }
                else {
                    $this->set_class($this->default_controller);
                    $this->set_method('index');
                }

                // Does the default controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT)) {
                    $this->directory = '';
                    return array();
                }
            }

            return $segments;
        }

        // If we've gotten this far it means that the URI does not correlate to a valid
        // controller class.  We will now see if there is an override
        if ( !empty($this->routes['404_override'] ) ) {
            $x = explode('/', $this->routes['404_override']);

            $this->set_class($x[0]);
            $this->set_method(isset($x[1]) ? $x[1] : 'index');

            return $x;
        }

        // Nothing else to do at this point but show a 404.
        show_404( $segments[0] );
    }

    /**
     * set_directory: Set the directory name
     *
     * @access  public
     * @param   string
     * @return  void
     */
    function set_directory( $dir ) {
        $this->directory = str_replace( array('.'), '', $dir ) . '/';
    }

}

/* End of file GP_Router.php */
/* Location: ../applications/gpanel/core/GP_Router.php */
