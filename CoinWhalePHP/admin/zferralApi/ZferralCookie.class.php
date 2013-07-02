<?php

class ZferralCookie
{
  /**
   * zferral Cookie
   *
   * @param string $dateExpire e.g. '2010-10-20 14:45:00'
   *
   * @return void
   */
  public function __construct($dateExpire = null)
  {
    if (!isset($_COOKIE['hash']) || $_COOKIE['hash'] == '0')
    {
      $zref = (isset($_GET['zref']) ? $_GET['zref'] : (isset($_POST['zref']) ? $_POST['zref'] : '0'));
      $zref = explode(',', rawurldecode($zref));
      $hash = $zref[0];
      $dateExpire = ($dateExpire ? strtotime($dateExpire) : isset($zref[1]) ? $zref[1] : 0);
      setrawcookie('hash', $hash, $dateExpire, '/');
    }
  }
}