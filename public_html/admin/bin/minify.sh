#!/bin/bash

JS_FILE='main.js'
CSS_FILE='main.css'
THEME_FILE='theme.css'

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
jslist=`find ../js/index -type f -name \*.js | sort` 

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
csslist=`find ../css/main -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    if [ "$machine" == "Mac" ]; then
        yuicompressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
    else 
        yui-compressor --type=css --preserve-semi ${cssfile} >> $CSS_FILE
    fi
done

csslist=`find ../css/theme -type f -name \*.css | sort` 

for cssfile in $csslist
do
    echo "Processing: ${cssfile}"
    if [ "$machine" == "Mac" ]; then
        yuicompressor --type=css --preserve-semi ${cssfile} >> $THEME_FILE
    else
        yui-compressor --type=css --preserve-semi ${cssfile} >> $THEME_FILE
    fi
done

# Copy file

echo "\nCoping files..."
mv $JS_FILE ../js
mv $CSS_FILE ../css
mv $THEME_FILE ../css

echo "\nDone."
exit 0
