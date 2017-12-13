<?php
namespace OAuth\Storage;

/**
 * Created by PhpStorm.
 * User: Liu xiaoquan
 * Date: 2017/4/20
 * Time: 17:48
 */
interface StrorageInterface
{
    //事务
    public function trans_begin();
    public function trans_rollback();
    public function trans_commit();

    //connect db
    public function DB();
}