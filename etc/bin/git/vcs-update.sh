#!/bin/sh
#


# (1) change working directory
SCRIPT_NAME=$(readlink -e "$0")
DIR=$(dirname "$SCRIPT_NAME")
DIR=$(dirname "$DIR")
DIR=$(dirname "$DIR")
PROJECT_DIR=$(dirname "$DIR")
cd "$PROJECT_DIR"


# (2) update project
[ ! -d ".git" ] && echo error: .git directory not found in project "$PROJECT_DIR" && exit
echo Updating $(basename "$PROJECT_DIR")...

git fetch origin                                                                  || exit
git status                                                                        || exit
git diff --stat --ignore-space-at-eol HEAD origin                                 || exit
git reset --hard origin/master                                                    || exit
git status                                                                        || exit


# (3) check/update additional requirements: dependencies, submodules, file permissions
