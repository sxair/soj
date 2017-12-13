<?php

namespace App\Http\Tools;

use ZipArchive;

class zip extends ZipArchive
{
    /**
     * create a zip file
     * @param $filename
     * @return mixed
     */
    public function create($filename)
    {
        return $this->open($filename, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
    }

    /**
     * add file to zip
     * @param $path
     */
    public function addDir($path)
    {
        $tmp = explode('/', $path);
        dump($tmp);
        $turePath = end($tmp);
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($path . "/" . $filename)) { // 递归处理文件夹
                    $this->addDir($path . "/" . $filename);
                } else {
                    $this->addFile($path.'/'.$filename, $turePath.'/'.$filename);
                }
            }
        }
        @closedir($path);
    }
}