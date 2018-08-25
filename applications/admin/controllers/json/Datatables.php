<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTables extends JSON_Controller 
{
    /**
     * index: Get Translations for Datatables.
     *
     * @access public
     * @return json
    **/
    public function index($data = array()) 
    {
        parent::index( 
            array(
                // metronic spesific
                "metronicGroupActions" => "_TOTAL_ registos seleccionados:  ",
                //
                "sProcessing"   => "A processar...",
                "sLengthMenu"   => "Mostrar _MENU_ registos",
                "sInfo"         => "Encontrados um total de _TOTAL_ registos",
                "sInfoEmpty"    => "Não foram encontrados resultados",
                "sZeroRecords"  => "Não foram encontrados resultados",
                "sInfoFiltered" => "(filtrado de _MAX_ registos no total)",
                "sGroupActions" => "_TOTAL_ registos seleccionados:  ",
                "sAjaxRequestGeneralError" => "Could not complete request. Please check your internet connection",
                "sInfoPostFix"  => "",
                "sSearch"       => "Procurar:",
                "sUrl"          => "",
                "oPaginate"     => array(
                    "sFirst"    => "Primeiro",
                    "sPrevious" => "Anterior",
                    "sNext"     => "Seguinte",
                    "sLast"     => "Último",
                    "sPage"     => "Página",
                    "sPageOf"   => "de",
                )
            )
        );
    }
}