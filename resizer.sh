#!/bin/sh

log_sw=1
if [ $log_sw = "1" ]; then
	log_file=resizer.sh.log

	if [ ! -w "$log_file" ]; then
		if [ -f "$log_file" ]; then
			chmod u+w "$log_file"
			if [ "$?" != "0" ]; then
				echo "No access to the log file: "$log_file" permission denied. Exiting..."
				exit 010
			fi
		else
			touch "$log_file"
			if [ "$?" != "0" ]; then
				echo "The log file: "$log_file" wasn't created, permissions or system error. Exiting..."
				exit 011
			fi
			echo `date +"%Y/%m/%d %T.%N"` "A log file was created." >> "$log_file"
		fi
	fi
fi

log()
{
	if [ $log_sw = "1" ]; then
		echo `date +"%Y/%m/%d %T.%N"` "$1" >> "$log_file"
	fi
}

unsucc()
{
	#echo $1 $2 $3
	if [ "$1" != "0" ]; then
		log "$2"
		exit $3
	fi
}

conv=`which convert`
if [ ! -x "$conv" ]; then
	unsucc $? "No ImageMagick util at the "$conv" path or binary haven't execute permissions." 020
fi


zipping=`which zip`
if [ ! -x "$zipping" ]; then
	unsucc $? "No ZIP util at the "$zipping" path or binary haven't execute permissions." 021
fi


tmp_path='tmp'
if [ ! -w "$tmp_path" ]; then
	if [ -d "$tmp_path" ]; then
		chmod u+rwx "$tmp_path"
		unsucc $? "No access to the work directory: "$tmp_path" permission denied." 022
	else
		mkdir -m 755 "$tmp_path"
		unsucc $? "The work directory: "$tmp_path" wasn't created, permissions or system error." 023
	fi
fi

if [ -n "$1" ]; then
    source_img=$1
else
	unsucc $? "No objects for treatment (no any arguments)." 100
fi

if [ -n "$2" ]; then
	arch_path=$2
else
	unsucc $? "No path to archives (no argument)." 101
fi


dir_name=`echo "$source_img" | sed -e 's/^.*\///' | sed -e 's/\.[^.]*$//'`
if [ -z $dir_name ]; then
	unsucc $? "Unsuccessful process forming of \"dir_name\", system error." 200
fi

work_path="$tmp_path"/"$dir_name"
png_path="$work_path"/png
ico_path="$work_path"/ico

if [ -d "$work_path" ]; then
	unsucc 1 "The work directory: "$work_path" is already exist." 201
else
	mkdir -m 755 "$work_path"
	unsucc $? "The work directory: "$work_path" wasn't created, permissions or system error." 211
fi

mkdir -m 755 "$png_path"
unsucc $? "The work directory: "$png_path" wasn't created, permissions or system error." 212

mkdir -m 755 "$ico_path"
unsucc $? "The work directory: "$ico_path" wasn't created, permissions or system error." 213

clean()
{
	if [ $1 != "0" ]; then
		if [ -d "$work_path" ]; then
			rm -rf "$work_path"
			if [ $? != "0" ]; then
				unsucc $? "Unsuccessful work directory removing, system error." 500
			fi
		fi
	fi
	unsucc "$1" "$2" "$3"
}

for size in 256 128 108 92 72 64 60 48 40 32 24 16; do
	"$conv" "$source_img" -resize "$size"x"$size"! -filter Lanczos "$png_path"/"$dir_name"_$size.png
	clean $? "Unsuccessful resize. Bad source image: \"$source_img\" or system error." 300
done

"$conv" "$png_path"/*.png "$ico_path"/"$dir_name".ico
clean $? "Unsuccessful ICO file creating. ImageMagick or system error." 301

cp "$source_img" "$png_path"/512.png
clean $? "Unsuccessful copy source image to PNG directory, system error." 302

"$zipping"  -q -0 -X -r "$arch_path" "$work_path"
clean $? "Unsuccessful archive creating, system error." 400

clean 1 "Successful complete for "$source_img"." 0
