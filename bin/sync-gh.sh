#! /bin/sh

ROOT=`dirname $0`/..

cd $ROOT

rsync -av doc/* ../OSS-Framework.github/

cd -



