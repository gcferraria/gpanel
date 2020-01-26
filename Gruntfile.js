"use strict";

// Gruntfile.js

module.exports = function (grunt) {

    // path to tasks and global variables
    var options = {
        jshint: {
            all: ['public_html/admin/js/custom/11*.js','public_html/admin/js/custom/9*.js']
        },
        watch: {
            files: ['public_html/admin/js/custom/11*.js','public_html/admin/js/custom/9*.js'],
            tasks: ['jshint']
        },
        cssmin: {
            options: {
                rebase: true,
                report: "min",
                sourceMap: false
            },
            target: {
                files: {
                    "public_html/admin/css/main.css": [
                        'public_html/admin/css/main/*.css',
                        'public_html/admin/css/theme/*.css'
                    ],
                    "public_html/admin/css/3rdparty.css": [
                        'bower_components/bootstrap/dist/css/bootstrap.min.css',
                        'bower_components/font-awesome/css/font-awesome.css'
                    ]
                }
            }
        },
        uglify: {
            target: {
                files: {
                    "public_html/admin/js/main.js": [
                        'public_html/admin/js/custom/*.js',
                    ],
                    "public_html/admin/js/3rdparty.js": [
                        'public_html/admin/js/vendor/my.class.min.js',
                        'bower_components/bootstrap/dist/js/bootstrap.min.js',
                        'bower_components/font-awesome/js/font-awesome.js',
                    ]
                }
            }
        }
    };

    grunt.initConfig( options );

    grunt.loadNpmTasks("grunt-contrib-cssmin");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-contrib-jshint");
    grunt.loadNpmTasks("grunt-contrib-watch");
    
    grunt.registerTask("build", ["jshint","cssmin","uglify"]);
};
