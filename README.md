ftp-spider
==========

PHP script for spidering through an FTP server, generating a list of the files inside.

By: (http://wogan.me)Wogan

Parameters
==========

Required:
* --host - The hostname or IP of the FTP server to connect to

Optional:
* --username - FTP username (for non-anonymous servers)
* --password - FTP Password (for non-anonymous servers)
* --debug - Be a bit more verbose
* --outputlinks - Prepend username, password and host

Samples
======

]# ./ftp-spider.php --host ftp.debian.org

]# ./ftp-spider.php --host secure.server.com --username myusername --password mypassword --outputlinks > link_list.txt

===License===

Public Domain