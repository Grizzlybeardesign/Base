module.exports = function(grunt) {
  // time
  require('time-grunt')(grunt);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        sourceMap: true,
        includePaths: ['bower_components/bootstrap-sass/assets/stylesheets/bootstrap']
      },

      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'css/app.css': 'scss/app.scss'
        }
      }
    },

    copy: {
      scripts: {
        expand: true,
        cwd: 'bower_components/bootstrap-sass/javascripts/',
        src: '**',
        flatten: 'true',
        dest: 'js/vendor/'
      },

      iconfonts: {
        expand: true,
        cwd: 'bower_components/fontawesome/',
        src: ['**', '!**/less/**', '!**/css/**', '!bower.json'],
        dest: 'assets/fontawesome/'
      },

    },
      'string-replace': {

        fontawesome: {
          files: {
            'assets/fontawesome/scss/_variables.scss': 'assets/fontawesome/scss/_variables.scss'
          },
          options: {
            replacements: [
              {
                pattern: '../fonts',
                replacement: '../assets/fontawesome/fonts'
              }
            ]
          }
        },
      },

    concat: {
        options: {
          separator: ';',
        },
        dist: {
          src: [

          // Bootstrap core
          'bower_components/bootstrap-sass/javascripts/bootstrap.min.js',

          // Include your own custom scripts (located in the custom folder)
          'js/custom/*.js'

          ],
          // Finally, concatinate all the files above into one single file
          dest: 'js/bootstrap.js',
        },
      },

    uglify: {
      dist: {
        files: {
          // Shrink the file size by removing spaces
          'js/bootstrap.js': ['js/bootstrap.js']
        }
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass'],
        options: {
              livereload:true,
            }
      },

      js: {
        files: 'js/custom/**/*.js',
        tasks: ['concat', 'uglify'],
        options: {
          livereload:true,
        }
      },

       all: {
        files: '**/*.php',
        options: {
            livereload:true,
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-string-replace');

  grunt.registerTask('build', ['copy', 'string-replace:fontawesome', 'sass', 'concat', 'uglify']);
  grunt.registerTask('default', ['watch']);
};