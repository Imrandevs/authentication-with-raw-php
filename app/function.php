<?php

    //alert msg

    function validate($msg,$type='danger'){
        return '<p class="alert alert-'.$type.'"> '.$msg.' <button class="close" data-dismiss="alert">&times;</button></p>';
    }

    // data insert

    function insert($sql){

        global $conn;

        $conn->query($sql);

    }

    //value check

    function valueCheck($tbl,$column,$val){
        global $conn;

        $sql="SELECT $column FROM $tbl WHERE $column='$val' ";
        $data=$conn->query($sql);
        return $data->num_rows;
    }

