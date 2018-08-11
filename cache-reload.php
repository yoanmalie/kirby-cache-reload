<?php
#######################################################

# What is it?
#     This will clean your Kirby file cache folder and
#     then rebuild it by checking all pages.

# How to use?
#     Put this file in your Kirby website root
#     and just go to yoursite.com/cache-reload.php
#     You should rename this file for security reason.

# About:
#     github.com/yoanmalie/kirby-cache-reload
#     yoan-malie.fr
#     twitter.com/yoanmalie

#######################################################

// Configs
define('DS', DIRECTORY_SEPARATOR);
$filename = DS . basename(__FILE__);
$urls = [];
$result = [];


// Load kirby
require(__DIR__ . DS . 'kirby' . DS . 'bootstrap.php');


// Clean current cache
$kirby = kirby();
$kirby->configure();
$kirby->cache()->flush();


// Search for all pages
foreach(site()->children() as $page):

  $urls[] = str_replace($filename, '', $page->url());

  if ($page->hasChildren()):
    foreach ($page->children() as $child):

      $urls[] = str_replace($filename, '', $child->url());

    endforeach;
  endif;

endforeach;


// Rebuild a new cache
foreach ($urls as $url) {
  $ch = curl_init();

  // URL to fetch
  curl_setopt($ch, CURLOPT_URL, $url);

  // User agent
  curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Curl - Kirby cache reload');

  // Include header in result?
  // (true = yes, false = no)
  curl_setopt($ch, CURLOPT_HEADER, true);

  // Should cURL return or print out the data?
  // (true = return, false = print)
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Timeout in seconds
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);

  // Execute the given URL, and return output
  $result[] = curl_exec($ch);

  curl_close($ch);
}
