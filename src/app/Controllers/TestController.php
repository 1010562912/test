<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author yuchangwei
 */

namespace app\Controllers;

use Server\CoreBase\Controller;

class TestController extends Controller {
    
    public function http_upload(){
        var_dump($this->http_input->getFiles());
        $this->http_output->end(1);
    }

    //put your code here

    public function bind_uid() {
        $data = $this->client_data->data;
        $this->bindUid($data);
        var_dump($data);
        $this->sendToAll($data);
    }

    public function ping() {
        $data = $this->client_data->data;
        var_dump($data);
        $this->send($data);
    }

    public function efficiency_test2() {
        $data = $this->client_data->data;
        var_dump($data);
        $this->sendToAll($data);
    }
    public function efficiency_test(){
        $data = $this->client_data->data;
        $this->sendToUid(mt_rand(1, 100), $data);
    }
}
