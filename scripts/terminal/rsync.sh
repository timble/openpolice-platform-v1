#!/bin/bash
# This script will attempt to connect to the police-production server
# and rsync the mysql dumps and www files
#
# Note: this script requires rsync 3.x with iconv support.
# Get it from, for example, using homebrew: brew install https://raw.github.com/Homebrew/homebrew-dupes/master/rsync.rb

/usr/local/bin/rsync -avz --delete -e "ssh -p 9999" deploy@127.0.10.10:/var/backups/databases/ /Users/terminal/Sites/lokalepolitie.be/backups/databases
/usr/local/bin/rsync -avz --delete --iconv=UTF8-MAC,UTF8 -e "ssh -p 9999" --no-links --exclude-from 'rsync.exclude' deploy@127.0.10.10:/var/www/lokalepolitie.be/ /Users/terminal/Sites/lokalepolitie.be/backups/files/

/usr/local/bin/rsync -avz --delete -e "ssh -p 9999" deploy@127.0.10.10:/etc/nginx/ /Users/terminal/Sites/lokalepolitie.be/backups/nginx