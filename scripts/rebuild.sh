#!/bin/bash

ROOTPATH="/var/www"
SVNUSER=""
SVNPASS=""
SVNURL="https://subversion.assembla.com/svn/timble-police/releases/development/code/"
LOG="/var/log/rebuild.log"

START=$(date +%s)

echo " " >> $LOG
echo "Rebuild Started at `date`" >> $LOG

# Checkout the site if its not already there
if [ ! -d "$ROOTPATH/svn" ]
then
	echo "Creating svn folder" >> $LOG
	mkdir $ROOTPATH/svn >> $LOG
	echo "Checking out working copy" >> $LOG
	svn co --username $SVNUSER --password $SVNPASS --non-interactive --no-auth-cache $SVNURL $ROOTPATH/svn >> $LOG
fi

# Update SVN (Currently from trunk but a tag might be better)
echo "- Update the working copy" >> $LOG
svn update --username $SVNUSER --password $SVNPASS --non-interactive --no-auth-cache $ROOTPATH/svn >> $LOG

# Export filebase
echo "- Export to public_tmp"  >> $LOG
svn export $ROOTPATH/svn $ROOTPATH/public_tmp >> $LOG

# Move necessary files.
cp -R $ROOTPATH/public/sites/ $ROOTPATH/public_tmp/sites/ >> $LOG
cp $ROOTPATH/public/configuration.php $ROOTPATH/public_tmp/ >> $LOG
exit
# Delete the current public folder
echo "- Delete the current public folder" >> $LOG
rm -fr $ROOTPATH/public >> $LOG

# Rename the checkout folder to public making it live
echo "- Rename public_tmp to public" >> $LOG
mv $ROOTPATH/public_tmp $ROOTPATH/public >> $LOG

# Set permissions on new public folder
echo "- Set permissions to public folder" >> $LOG
chown -Rf apache:apache $ROOTPATH/public >> $LOG
find $ROOTPATH/public -type f -exec chmod 644 {} \; >> $LOG
find $ROOTPATH/public -type d -exec chmod 755 {} \; >> $LOG

END=$(date +%s)
DIFF=$(( $END - $START ))
echo "Rebuild completed in $DIFF seconds" >> $LOG
echo " " >> $LOG