<?php
class DFImage {
    private $image = null;

    function DFImage($path, $realname = null) {
        return  $this->load($path, $realname);
    }

    public function load($path, $realname = null) {
        if (!file_exists($path)) {
            return false;
        }
        if ($realname == null) {
            $pinfo = pathinfo($path);
            $ext = $pinfo["extension"];
        } else {
            $pinfo = pathinfo($realname);
            $ext = $pinfo["extension"];
        }
        switch (strtolower($ext)) {
            case "jpeg":
            case "jpg":
                $this->image = imagecreatefromjpeg($path);
                break;
            case "gif":
                $this->image = imagecreatefromgif($path);
                break;
            case "png":
                $this->image = imagecreatefrompng($path);
                break;
            case "bmp":
                $this->image = imagecreatefrombmp($path);
                break;
        }
        if ($this->image == null) { return false; }
        return true;
    }

    public function thumbnail($maxWidth = 0, $maxHeight = 0) {
        if ($this->image == null) {
            return false;
        }

        $sizeX = imagesx($this->image);
        $sizeY = imagesy($this->image);
        $newSizeX = $sizeX;
        $newSizeY = $sizeY;
        if ($maxWidth != 0) {
            $newSizeX = $maxWidth;
        }
        if ($maxHeight != 0) {
            $newSizeY = $maxHeight;
        }
        if (($newSizeX > $sizeX) && ($newSizeY > $sizeY)) {
            return false;
        }
        $ratioX = $newSizeX / $sizeX;
        $ratioY = $newSizeY / $sizeY;
        if ($ratioX < $ratioY) {
            $ratio = $ratioX;
        } else {
            $ratio = $ratioY;
        }
        $thumb = imagecreatetruecolor($sizeX * $ratio, $sizeY * $ratio);
        imagecopyresampled($thumb, $this->image, 0, 0, 0, 0, $sizeX * $ratio, $sizeY * $ratio, $sizeX, $sizeY);
        $this->image = $thumb;
        return true;
    }

    public function getResourse() {
        return $this->image;
    }

    public function save($path) {
        if ($this->image == null) {
            return false;
        }
        $pinfo = pathinfo($path);
        $type = $pinfo["extension"];
        switch (strtolower($type)) {
            case "jpeg":
            case "jpg":
                imagejpeg($this->image, $path);
                break;
            case "png":
                imagepng($this->image, $path);
                break;
            case "gif":
                imagegif($this->image, $path);
                break;
            default:
                return false;
        }
        return true;
    }

    public function toClient($type = "jpeg") {
        if ($this->image == null) {
            return false;
        }
        switch (strtolower($type)) {
            case "jpeg":
            case "jpg":
                header("Content-type: image/jpeg");
                imagejpeg($this->image);
                break;
            case "png":
                header("Content-type: image/png");
                imagepng($this->image);
                break;
            case "gif":
                header("Content-type: image/gif");
                imagegif($this->image);
                break;
            default:
                return false;
        }
        return true;
    }
}

?>
