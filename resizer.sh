#!/bin/sh

conv='/usr/local/bin/convert'
zipping='/usr/local/bin/zip -q -0 -X -r'
tmp_path='tmp'
source_img=$1
arch_path=$2

if [ -z "$1" ]; then
    printf '\n'"No objects for treatment. Exiting..."'\n''\n'
    exit 1
fi

unsucc_test()
{
	if [ "$?" != "0" ]; then
		rm -rf "$work_path"
		printf '\n'"Something wrong. Exiting..."'\n''\n'
    	exit 1
	fi
}

dir_name=`echo "$source_img" | sed -e 's/^.*\///' | sed -e 's/\.[^.]*$//'`
work_path="$tmp_path"/"$dir_name"
png_path="$work_path"/png
mkdir -p "$png_path"
mkdir "$work_path"/ico

for size in 256 128 108 92 72 64 60 48 40 32 24 16; do
	$conv "$source_img" -resize "$size"x"$size"! -filter Lanczos "$png_path"/$size.png
	unsucc_test
done

$conv "$png_path"/*.png "$work_path"/ico/"$dir_name".ico

cp "$source_img" "$png_path"/512.png

$zipping "$arch_path"/"$dir_name".zip ./"$work_path"/

rm -rf "$work_path"
