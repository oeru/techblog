#!/bin/bash
NEW='drupal-7.43'
PREV='drupal-7.42'
DRUP='drupal7'
#
# settings likely to be the same on a given server
USER="dave"
GROUP="dave"
#
# git pull
## remove link if it exists.
if [ -L "$PREV-link" ] ; then
  echo "removing $PREV-link"
  rm $PREV-link
fi
## get the new drupal, if it's not already there...
if [ ! -d "$NEW" ] ; then
  echo "downloading $NEW"
  drush dl $NEW
else
  echo "new drupal: $NEW already exists?!"
fi
## if it's there, continue
if [ -d "$NEW" ] ; then
  ## move the old Drupal out of the way
  mv $DRUP $PREV
  ## rm any old reminder link...
  if [ -L "$PREV-link" ] ; then
    rm $PREV-link
  fi
  ## move the new Drupal into position
  mv $NEW $DRUP  
  ## create the reminder link (with "-link" suffix to ensure it doesn't clash with a future drush dl)
  ln -sf $DRUP $NEW-link
  ## do a switcheroo on the sites dirs:
  mv $DRUP/sites $DRUP/sites.orig
  mv $PREV/sites $DRUP/sites
  ## if there's an image.imagick file, shift it appropriately
  if [ -f "$PREV/includes/image.imagemagick.inc" ] ; then
    mv $PREV/includes/image.imagemagick.inc $DRUP/includes/
  fi
  ## make sure the new dir has appropriate ownership.
  echo "setting file permissions to $USER:$GROUP"
  chown -R $USER:$GROUP $DRUP
fi

# git commit -m "update $DRUP to $NEW from $PREV" .
# git push
# cd $DRUP/sites/default
# drush updatedb

