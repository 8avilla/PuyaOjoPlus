<?php

class Idiom {

    private $title = "Censo Electoral";
    private $title_login = "Entrar";
    //**************************
    private $login = "Iniciar sesión";
    private $label_escrutinio = "Escrutinio";
    private $username = "Numero de Cédula";
    private $password = "Contraseña";
    private $btn_login = "Inicio de sesión";
    private $clue_username = "Digite su numero de cédula";
    private $clue_password = "Digite su contraseña";
    private $clue_Iforgot = "Olvidé mi contraseña";
    private $clue_register = "Registrar un nuevo usuario";
    private $label_Remember = "Recuérdame";
    private $label_Candidates = "Candidatos";
    private $label_leaders = "Lideres";
    private $label_stadistics = "Estadisticas";
    private $label_town = "Departamentos y Municipios";
    private $label_place = "Puestos de Votación";
    private $label_voter = "Votantes";
    private $label_query_place = "Consultar Puesto";
    private $label_sign_out = "Salir";
    private $add_leader = "Agregar Líder";
    private $add_voter = "Agregar Líder";
    private $label_email = "E-mail";
    private $modal_add_voter = "Agregar Votante";
    private $modal_label_cc = "Cédula de ciudadanía";
    private $modal_label_name = "Nombre";
    private $modal_label_lastname = "Apellidos";
    private $modal_label_departament = "Departamento";
    private $modal_label_town = "Municipio";
    private $modal_label_place = "Lugar de votación";
    private $modal_label_dir_place = "Dirección del lugar";
    private $modal_label_table = "Mesa";
    private $modal_label_tel = "Teléfono";
    private $modal_label_cel = "Celular";
    private $view_leaders = "Mostrar lideres";
    private $view_voters = "Mostrar votantes";
    //****action btn****
    private $btn_close = "Cerrar";
    private $btn_save = "Guardar";

    function __construct() {
        
    }
    
    function getLabel_escrutinio() {
        return $this->label_escrutinio;
    }

    function setLabel_escrutinio($label_escrutinio) {
        $this->label_escrutinio = $label_escrutinio;
    }

        
    function getLabel_Candidates() {
        return $this->label_Candidates;
    }

    function setLabel_Candidates($label_Candidates) {
        $this->label_Candidates = $label_Candidates;
    }

        
    function getTitle() {
        return $this->title;
    }

    function getTitle_login() {
        return $this->title_login;
    }
    
    

    function getLogin() {
        return $this->login;
    }

    function getUsername() {
        return $this->username;
    }
    function getModal_label_cel() {
        return $this->modal_label_cel;
    }

        function getAdd_leader() {
        return $this->add_leader;
    }

    function getPassword() {
        return $this->password;
    }

    function getBtn_login() {
        return $this->btn_login;
    }

    function getClue_username() {
        return $this->clue_username;
    }

    function getClue_password() {
        return $this->clue_password;
    }

    function getClue_Iforgot() {
        return $this->clue_Iforgot;
    }

    function getClue_register() {
        return $this->clue_register;
    }

    function getLabel_Remember() {
        return $this->label_Remember;
    }

    function getLabel_leaders() {
        return $this->label_leaders;
    }

    function getLabel_stadistics() {
        return $this->label_stadistics;
    }

    function getLabel_town() {
        return $this->label_town;
    }

    function getLabel_place() {
        return $this->label_place;
    }

    function getLabel_voter() {
        return $this->label_voter;
    }

    function getLabel_query_place() {
        return $this->label_query_place;
    }

    function getLabel_sign_out() {
        return $this->label_sign_out;
    }

    function getAdd_voter() {
        return $this->add_voter;
    }

    function getLabel_email() {
        return $this->label_email;
    }

    function getModal_add_voter() {
        return $this->modal_add_voter;
    }

    function getModal_label_cc() {
        return $this->modal_label_cc;
    }

    function getModal_label_name() {
        return $this->modal_label_name;
    }

    function getModal_label_lastname() {
        return $this->modal_label_lastname;
    }

    function getModal_label_departament() {
        return $this->modal_label_departament;
    }

    function getModal_label_town() {
        return $this->modal_label_town;
    }

    function getModal_label_place() {
        return $this->modal_label_place;
    }

    function getModal_label_dir_place() {
        return $this->modal_label_dir_place;
    }

    function getModal_label_table() {
        return $this->modal_label_table;
    }

    function getModal_label_tel() {
        return $this->modal_label_tel;
    }

    function getView_leaders() {
        return $this->view_leaders;
    }

    function getView_voters() {
        return $this->view_voters;
    }

    function getBtn_close() {
        return $this->btn_close;
    }

    function getBtn_save() {
        return $this->btn_save;
    }

}

?>