<?php

class Serviesblog
{
    private $serverconn;

    public function __construct()
    {
        $this->serverconn = mysqli_connect("sdb-81.hosting.stackcp.net", "msjblog-353038378fa1", "1j3np4epe5", "msjblog-353038378fa1");
        if (mysqli_connect_errno()) {
            echo json_encode(["status" => "500", "Internal Server Error" . mysqli_connect_error()]);
            exit();
        }
    }

    public function Getdatabytable($tablename)
    {
        $tabledatasql = "SELECT * FROM $tablename";
        $tabledataresult = mysqli_query($this->serverconn, $tabledatasql);
        $data = mysqli_fetch_all($tabledataresult, MYSQLI_ASSOC);
        return $data;
    }
}
