#!/bin/sh

# Ensure that we received a url
if [ "$1" != "" ]; then
  echo "Working with the $1 repository"
else
  echo "ERROR: No repository URL provided!"
  echo "USAGE: ./commit.sh https://github.com/user/repo 'Comment for commit'"
  exit
fi

# And a comment
if [ "$2" != "" ]; then
  echo "Committing with the following comment: $2"
else
  echo "ERROR: No comment provided!"
  echo "USAGE: ./commit.sh https://github.com/user/repo 'Comment for commit'"
  exit
fi

# Move the config out the way
cp includes/class.config.php includes/class.config.php.production

# Copy the staging back
cp includes/class.config.php.staging includes/class.config.php

# Git commit the changes
git commit -am $2

# Push them upstream
git push $1

# Wait for the auth and push to happen and move the original config back to where we need it
cp includes/class.config.php.production includes/class.config.php
rm includes/class.config.php.production