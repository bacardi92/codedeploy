<?php
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Deploy extends WPCD
{

    public $mode;
    public $remoteService;
    public $request;
    public $service;
    public $repository;
    public $execStart;


    public function __construct()
    {
        parent::__construct();
        $this->mode = get_option('_wpcd_connection');
        $this->remoteService = self::which_repo();
        $this->request = $_POST;
        $this->service = $this->load_service($this->mode);
        $this->execStart = "cd " . WP_CONTENT_DIR . " && ";
        $this->repository = get_option('_wpcd_repository');
        $this->initCurrent();
    }

    public function initCurrent()
    {
        if (!file_exists(WP_CONTENT_DIR . "/.git")) {
            exec($this->execStart."git init", $output, $errorCode);
            if($errorCode != 0){
                self::admin_danger($output[0]);
            }
        }
        $this->setOrigin();

    }

    public function setOrigin()
    {
        if (!file_exists(WP_CONTENT_DIR . "/.git")) {
            self::admin_danger(__("Not a git repository (or any of the parent directories): .git"));
            return false;
        }
        $isOriginExists = $this->isOriginExists();
        if(!$isOriginExists){
            return false;
        }
        if(!count($isOriginExists)){
            exec($this->execStart."git remote add origin ".$this->repository, $output, $errorCode);
        }else{
            exec($this->execStart."git remote set-url origin ".$this->repository, $output, $errorCode);
        }
        return true;
    }

    public function isOriginExists()
    {
        exec($this->execStart."git remote -v", $output, $errorCode);
        if($errorCode != 0){
            self::admin_danger(__("Can't set origin remote!"));
            return false;
        }
        return $output;
    }

    public function fetchOrigin()
    {
        exec($this->execStart."git fetch origin", $output, $errorCode);
    }

    public function getOriginBranches()
    {
        exec($this->execStart."git fetch origin", $output, $errorCode);
    }


}