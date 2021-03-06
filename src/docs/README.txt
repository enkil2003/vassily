;;;;;;;;;;;;
;; Readme ;;
;;;;;;;;;;;;

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


;;;;;;;;;;;;;;;;;;;;;;;;;;;
;; Setting up your VHOST ;;
;;;;;;;;;;;;;;;;;;;;;;;;;;;

Windows: You should copy the content of the virtual host to your virtual host file
Linux: You should create a vassilymas.conf file in sites-available and then run a2ensite vassilymas.
This command could need sudo prefix

<VirtualHost *:80>
    DocumentRoot "/home/ricardo/www/vassilymas/trunk/public"
    ServerName vassilymas.local
    ServerAlias staticvassilymas.local
    ServerAlias www.vassilymas.local
    ServerAlias www.staticvassilymas.local
    ServerAlias cdn.vassilymas.local
    
    # This should be omitted in the production environment
    SetEnv APPLICATION_ENV development
    SetEnv APPLICATION_CDN "http://staticvassilymas.local"
    
    ErrorLog "/home/ricardo/www/vassilymas/trunk/logs/apache/error.log"
    CustomLog "/home/ricardo/www/vassilymas/trunk/logs/apache/access.log" common
    CustomLog "/home/ricardo/www/vassilymas/trunk/logs/apache/deflate.log" deflate
    
    Header unset ETag
    FileETag None
    
    <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css|swf)(\.gz)?$$">
        ExpiresActive On
        ExpiresDefault "access plus 10 years"
        Header set Expires "Thu, 15 Apr 2020 20:00:00 GMT"
        Header unset ETag
        FileETag None
    </FilesMatch>

    <Directory "/home/ricardo/www/vassilymas/trunk/public">
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    <Directory "/home/ricardo/www/vassilymas/trunk/public/css">
        ExpiresDefault "access plus 10 years"
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    <Directory "/home/ricardo/www/vassilymas/trunk/public/js">
        ExpiresDefault "access plus 10 years"
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    <Directory "/home/ricardo/www/vassilymas/trunk/public/images">
        Header set Expires "access plus 10 years"
        ExpiresDefault "access plus 10 years"
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    <Directory "/home/ricardo/www/vassilymas/trunk/public/uploads/image">
        Header set Expires "access plus 10 years"
        ExpiresDefault "access plus 10 years"
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    <Directory "/home/ricardo/www/vassilymas/trunk/public/uploads/thumb">
        Header set Expires "access plus 10 years"
        ExpiresDefault "access plus 10 years"
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
    
    #<Location "/var/www/vassilymas/trunk/public">
    <Location "/home/ricardo/www/vassilymas/trunk/public">
        SetOutputFilter DEFLATE
        BrowserMatch ^Mozilla/4 gzip-only-text/html
        BrowserMatch ^Mozilla/4\.0[678] no-gzip
        BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
        SetEnvIfNoCase Request_URI \\.(?:gif|jpe?g|png)$ no-gzip dont-vary
        Header append Vary User-Agent env=!dont-vary
    </Location>
</VirtualHost>
