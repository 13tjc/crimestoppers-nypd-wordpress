module.exports = function(grunt) {

  // config
  grunt.initConfig({
 
    // get package meta data
    pkg: grunt.file.readJSON('package.json'),

    // sass
    sass: {
      dev: {
        options: {
          style: 'expanded'
        },
        files: {
          'css/crimestoppers.css': 'css/crimestoppers.scss',
          'css/crimestoppers-ie.css': 'css/crimestoppers-ie.scss'
        }
      }
    },

    // watch
    watch: {
      css: {
        files: ['css/*.scss', 'css/**/*.scss', 'css/**/**/*.scss'],
        tasks: ['sass']
      }
    }

  });

  // load tasks
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // register tasks
  grunt.registerTask('dev', ['watch']);

};