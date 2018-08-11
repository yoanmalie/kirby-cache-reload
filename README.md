# kirby-cache-reload
> Clean the cache folder and rebuild the cache file.

This will clean your Kirby file cache folder and then rebuild it by checking all pages.  
**This is an experimental project, use it at your own risk.**  
Curl function may be slow on large project and/or in a cheap webhost.

## How to use it?
:warning: This is not a Kirby plugin.  
Put this file in your Kirby website root and just go to yoursite.com/cache-reload.php  
I suggest you to rename this file to avoid strange visitors to load it.

For a better experience, create an alias to lanch the build through command line.  
`alias mysite-cache="curl -s -S https://yoursite.com/cache-reload.php"`

## Troubleshooting
If you're on localhost and running on HTTPS, you maybe have to add these lines after the `curl_init()`:  
```php
// Ignore SSL security in localhost
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
```
