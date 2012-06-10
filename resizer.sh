#!/bin/sh

conv='/usr/local/bin/convert'

succ_test()
{
	if [ "$?" != "0" ]; then
		printf '\n'"Something wrong. Exiting..."'\n''\n'
    	exit 1
	fi
}

if [ -z "$1" ]
    then
        printf '\n'"No objects for treatment. Exiting..."'\n''\n'
        exit 1
fi

dir_name=`echo $1 | sed -e 's/^.*\///' | sed -e 's/\.[^.]*$//'`
png_path=$dir_name/png
mkdir -p "$png_path"
mkdir "$dir_name/ico"

for size in 256 128 108 92 72 64 60 48 40 32 24 16
	do
		$conv $1 -resize "$size"x"$size"! -filter Lanczos $png_path/$size.png
		succ_test
	done


$conv $png_path/*.png $dir_name/ico/$dir_name.ico
#succ_test

cp $1 $png_path/512.png

zip -q -0 -X -r $dir_name.zip ./$dir_name/
#succ_test

rm -rf ./$dir_name
# rm $1
