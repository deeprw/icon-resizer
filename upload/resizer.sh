#!/bin/sh

conv='/usr/bin/convert'

if [ -z "$1" ]
    then
        printf '\n'"No objects for treatment. Exiting..."'\n''\n'
        exit 1
fi

dir_name=`echo $1 | sed -e 's/^.*\///' | sed -e 's/\.[^.]*$//'`
mkdir "$dir_name"

for size in 256 128 64 48 32 24 16
	do
		$conv $1 -resize "$size"x"$size"! -filter Lanczos ./$dir_name/$size.png
		if [ "$?" != "0" ]
			then
				printf '\n'"Something wrong. Exiting..."'\n''\n'
        		exit 1
		fi
	done
	
cp $1 ./$dir_name/512.png

zip -q -0 -X -r $dir_name.zip ./$dir_name/

rm -rf ./$dir_name
# rm $1
