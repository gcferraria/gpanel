<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GP_Form_validation extends CI_Form_validation 
{
    /**
     * unique: Check if value already exist in Table/Column of Database.
     *
     * @access public
     * @param  string $value, [Required] Value to Validate.
     * @param  string $field, [Required] table and field to validate in Database. (separated by (.) ).
     * @return boolean, FALSE if value already exist in Table/Column of Database and TRUE if not.
    **/
    public function is_unique($str, $field) 
    {
        // If exist 2 condictions.
        if ( substr_count( $field, '.' ) == 3 ) 
        {
            list($table, $field, $id_field, $id_val ) = explode('.', $field);

            $query = $this->CI->db->limit(1)
                ->where($field, $str)
                ->where($id_field.' != ',$id_val)
                ->get($table);
        }
        else // One condiction only. 
        {
            list($table, $field)=explode('.', $field);

            $query = $this->CI->db->limit(1)->get_where(
                $table,
                array( $field => $str )
            );
        }

        return $query->num_rows() === 0;
    }

    /**
     * spaces: Check if the value has spaces.
     *
     * @access public
     * @param  string $value, [Required] Value to Validate.
     * @return boolean, FALSE if value has spaces, and TRUE if not.
    **/
    public function spaces( $value ) 
    {
        return preg_match('/\s/', $value ) ? FALSE : TRUE;
    }

    /**
     *
     * uriname: Check if the value is valid for uri.
     *
     * @param  public
     * @param  string $value, [Required] Value to Validate.
     * @return boolean, FALSE if is valid for uri, and TRUE if not.
    **/
    public function uriname( $value ) 
    {
        return preg_match('/^\w[\w\-]+$/', $value ) ? TRUE : FALSE;
    }

    /**
     *
     * valid_domain: Check if the value is a valid domain.
     *
     * @param  public
     * @param  string $value, [Required] Value to Validate.
     * @return boolean.
    **/
    public function valid_domain( $value ) 
    {
        // Remove www.
        $domain = str_replace('www.','',$value);

        // Return FALSE if value has spaces, and TRUE if not.
        return preg_match('/^([a-zA-Z0-9\-_]+\.)?[a-zA-Z0-9\-_]+\.[a-zA-Z]{2,5}$/', $value ) ? TRUE : FALSE;
    }

    /**
     *
     * min_string_size: Check if the text has the number minimum of letters.
     *
     * @param  public
     * @param  string $value, [Required] Value to Validate.
     * @param  int    $size , [Required] Number minimum of letters
     * @return boolean.
    **/
    public function min_string_size( $value, $size ) 
    {
        return ( strlen( $value ) > $size );
    }

    /**
     *
     * max_string_size: Check if the text has the number maximum of letters.
     *
     * @param  public
     * @param  string $value, [Required] Value to Validate.
     * @param  int    $size , [Required] Number maximum of letters
     * @return boolean.
    **/
    public function max_string_size( $value, $size ) 
    {
        return ( strlen( $value ) < $size );
    }

}