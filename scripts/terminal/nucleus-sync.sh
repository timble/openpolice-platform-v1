#!/bin/bash
# This script will sync everything from the Nucleus server with the SS servers.
#
# Note: this script requires rsync 3.x with iconv support.
# Get it from, for example, using homebrew: brew install https://raw.github.com/Homebrew/homebrew-dupes/master/rsync.rb
#

echo "-- Dump all databases on Nucleus production (please supply fedpol password)"
ssh -t -p 9999 fedpol@188.93.153.147 << EOF
  mkdir /tmp/dumps
  mysql -N -ufedpol -pVNW6eatrdtyknQ -e 'SHOW DATABASES' | while read dbname; do mysqldump -ufedpol -pVNW6eatrdtyknQ --complete-insert --add-drop-table --extended-insert --quote-names \$dbname > /tmp/dumps/\$dbname.sql; done;

  cd /tmp/dumps
  tar -cvzf /tmp/dumps/production-backup.tar.gz *.sql
  cd /tmp
  rm -f /tmp/dumps/*.sql
EOF

echo "-- Download the dump from Nucleus (supply fedpol password)"
scp -P 9999 fedpol@188.93.153.147:/tmp/dumps/production-backup.tar.gz /tmp/production-backup.tar.gz

echo "-- Clean up on Nucleus server (supply fedpol password)"
ssh -t -p 9999 fedpol@188.93.153.147 "rm -rf /tmp/dumps"

echo "-- Upload the dumps to SS production .."
scp -P 9999 /tmp/production-backup.tar.gz deploy@127.0.10.10:/tmp/production-backup.tar.gz

echo "-- Import all databases on SS server .. (supply fedpol password)"
ssh -t -p 9999 fedpol@127.0.10.10 << EOF
  mkdir /tmp/dumps
  cd /tmp/dumps
  tar -xvzf /tmp/production-backup.tar.gz -C /tmp/dumps

  for dump in *.sql
  do
    mysql -N -ufedpol -pVNW6eatrdtyknQ "\${dump%.*}" < "\$dump"
  done

  rm -rf /tmp/dumps
  rm -f /tmp/production-backup.tar.gz
EOF

echo "-- Making a copy of the local backup files .."
cp -aR /Users/terminal/Sites/lokalepolitie.be/backups/files/capistrano/shared/sites /tmp/

echo "-- Syncing with Nucleus (please supply fedpol password) .."
/usr/local/bin/rsync --progress --iconv=UTF8-MAC,UTF8 --rsh "ssh -p 9999" fedpol@188.93.153.147:/var/www/lokalepolitie.be/capistrano/shared/sites/ /tmp/sites/ --update --perms --owner --group --recursive --times --no-links

echo "-- Pushing all changes to SS production"
/usr/local/bin/rsync --progress --iconv=UTF8-MAC,UTF8 --rsh "ssh -p 9999" /tmp/sites/ www-data@127.0.10.10:/var/www/lokalepolitie.be/capistrano/shared/sites/ --update --perms --owner --group --recursive --times --no-links

echo "-- Cleaning up"
rm -rf /tmp/sites
rm -f /tmp/production-backup.tar.gz