<?php

  //
  // == List of Login/Pass-Users ==
  //
  // -- Setup an "admin" user, with password "secret" --
  $userlist['admin']['pass'] = "secret";
  $userlist['admin']['role'] = "root"; // used to call "/diag.php"

  //*
  // -- Setup readonly-user for regression tests (yourdomain.com/addressbook/test/
  $userlist['simpletest']['pass']   = "simple";
  $userlist['simpletest']['role']   = "readonly";
  $userlist['simpletest']['domain'] = 9999;

  //
  // == User table in database ==
  // - Excludes the table_prefix!
  $usertable = "users";

  //
  // == Look & Feel of the domains
  //
  $skin_color = "red"; // global skin color, e.g. on login

  // blue, brown, green, grey, pink, purple, red, turquoise, yellow
  $domain[0]['skin'] = "red";
  $domain[1]['skin'] = "pink";
  $domain[2]['skin'] = "yellow";
