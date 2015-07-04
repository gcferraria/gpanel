#!/bin/bash

JS_FILE='3rdparty.js'
CSS_FILE='3rdparty.css'

# Minify JavaScripts

echo "\nMinifying JavaScripts..."
jslist=`find ../js/3rdparty -type f -name \*.js | sort` 

for jsfile in $jslist
do
    echo "Processing: ${jsfile}"
    yui-compressor --type=js ${jsfile} >> $JS_FILE
done

# Minify Css

echo "\nMinifying Css..."
csslist=`find ../css/3rdparty -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    yui-compressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
done

# Copy file

echo "\nCoping files..."
mv $JS_FILE ../js
mv $CSS_FILE ../css

echo "\nDone."
exit 0
