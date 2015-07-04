#!/bin/bash

JS_FILE='main.js'
CSS_FILE='main.css'
THEME_FILE='theme.css'

# Minify JavaScripts

echo "\nMinifying JavaScripts..."
jslist=`find ../js/index -type f -name \*.js | sort` 

for jsfile in $jslist
do
    echo "Processing: ${jsfile}"
    yui-compressor --type=js ${jsfile} >> $JS_FILE
done

# Minify Css

echo "\nMinifying Css..."
csslist=`find ../css/main -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    yui-compressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
done

csslist=`find ../css/theme -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    yui-compressor --type=css --preserve-semi ${cssfile} >> $THEME_FILE
done

# Copy file

echo "\nCoping files..."
mv $JS_FILE ../js
mv $CSS_FILE ../css
mv $THEME_FILE ../css

echo "\nDone."
exit 0
