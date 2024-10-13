<?php

namespace App\Libraries;

class OwnAuth
{
    public static function setOwnAuth($result){
        $session = session();
        $array = ['logged_in' => true];
        $userdata = $result;
        $session->set('userdata', $userdata);
        $session->set($array);
    }

    public static function id(){
        $session = seesion();
        if($session->has('logged_in')){
            if($session->has('userdata')){
                return $session->get('userdata')['id'];
            }else{
                return null;
            }

        }else{
            return null;
        }
    }

    public static function check(){
        $session = session();
        return $session->has('user');
    }

    public static function forget(){
        $session = session();
        $session->remove('logged_in');
        $session->remove('userdata');
    }

    public static function user(){
        $session = seesion();
        if($session->has('logged_in')){
            if($session->has('userdata')){
                return $session->get('userdata');
            }else{
                return null;
            }

        }else{
            return null;
        }
    }
}