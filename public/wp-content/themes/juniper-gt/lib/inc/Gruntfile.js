module.exports = function(grunt) {

	  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

             compass: {
            dev: {
                options: {
                    sassDir: 'src/sass', 
                    cssDir: 'css',
                    fontsDir: 'fonts',
                    imagesDir: 'images',
                    relativeAssets: true,
                    force: true                
                }                
            }, 
            deploy: {
                options: {                    
                    sassDir: 'src/sass', 
                    cssDir: 'css',
                    fontsDir: 'fonts',
                    imagesDir: 'assets',
                    relativeAssets: true,
                    force: true,
                    outputStyle: 'compressed',
                    cssDir: 'css'
                }
            }
        },
    uglify: { 
           options: {
                beautify: true
            },

            dev: {
                options: {}, 
                files: '<%= uglify.files %>'
            },

            deploy: {
                options: {
                    beautify: false
                },
                files: '<%= uglify.files %>'
            },
            files: {
                   'js/application.js': ['src/js/media-uploader.js',
                                         'src/js/options-custom.js',
                                         'src/js/rangeslider.js'
                                         ]
            } 
    },
        watch: {
            css: {
                files: [ 'src/sass/**/*.scss' ],
                tasks: [ 'compass:dev' ]
            }, 
            js: {
                files: [ 'src/js/**/*.js' ],
                tasks: [ 'uglify:dev' ]
            }
        }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
 // grunt.loadNpmTasks('grunt-contrib-uglify');
 //grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.registerTask(
        'dev',         
        [ 'compass:dev',
          'uglify:dev',
          'watch' ]
    ); 
    grunt.registerTask(
        'deploy', 
        [ 'compass:deploy',
          'uglify:deploy' ]
    );      
 }
