<?php

require_once "dtb.php";

function dbquery($sql)
{
  global $conn;
  $result = mysqli_query($conn, $sql);
  $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  return $res;
}

function dbexecute($sql)
{
  global $conn;
  if($result = mysqli_query($conn, $sql))
  {
    mysqli_free_result($result);
    return true;
  }
  return false;
}
