#!/bin/sh
origpath=`dirname "${0}"`
basename=`basename "${0}"`
absApplicationPath=`cd "$origpath" && echo ${PWD}`/$basename
require_admin=0

os_version=`uname -r`
machine_platform=`uname -p`
if [ "${machine_platform}" == "i386" ];then
    executable="osx-intel"
else
    executable="osx-ppc"
fi
if [ ! -O "$absApplicationPath" ] || [ x$require_admin == "x1" ]
then
"`dirname \"${0}\"`/Application Manager" $executable "$@"
else 
"`dirname \"${0}\"`/$executable" "$@"
fi
