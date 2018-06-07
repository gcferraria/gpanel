#!/bin/bash

JS_FILE='3rdparty.js'
CSS_FILE='3rdparty.css'

# Detect SO in Machine

unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    *)          machine="UNKNOWN:${unameOut}"
esac

echo "Running in ${machine}"

# Minify JavaScripts

echo "\nMinifying JavaScripts..."
jslist=`find ../js/3rdparty -type f -name \*.js | sort` 

for jsfile in $jslist
do
    echo "Processing: ${jsfile}"
    if [ "$machine" == "Mac" ]; then
        yuicompressor --type=js ${jsfile} >> $JS_FILE
    else
        yui-compressor --type=js ${jsfile} >> $JS_FILE
    fi
done

# Minify Css

echo "\nMinifying Css..."
csslist=`find ../css/3rdparty -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    if [ "$machine" == "Mac" ]; then
        yuicompressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
    else 
        yui-compressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
    fi
done

# Copy file

echo "\nCoping files..."
mv $JS_FILE ../js
mv $CSS_FILE ../css

echo "\nDone."
exit 0
