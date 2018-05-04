module.exports = function (grunt) {

	// Start out by loading the grunt modules we'll need
	require('load-grunt-tasks')(grunt);

	// Show elapsed time
	require('time-grunt')(grunt);

	grunt.initConfig(
		{

			/**
			 * Clean existing files
			 */
			clean: {
				styles:  {
					src: [
						'assets/css/*.css',
						'assets/css/*.map'
					]
				},
				scripts: {
					src: [
						'assets/js/*.js',
						'assets/js/*.map'
					]
				}
			},

			/**
			 * Autoprefix CSS
			 */
			postcss: {

				options: {
					map:        true,
					processors: [
						require('autoprefixer')({browsers: ['last 5 versions']}),
						require('pixrem')()
					]
				},

				dist: {
					src: 'assets/css/*.css'
				}
			},

			/**
			 * Minify CSS
			 */
			cssmin: {

				target: {

					files: [{
						expand: true,
						cwd:    'assets/css',
						src:    ['*.css'],
						dest:   'assets/css',
						ext:    '.min.css'
					}]

				}

			},

			/**
			 * Process SASS files
			 */
			sass: {

				dist: {

					options: {
						style:     'expanded',
						sourceMap: true,
						noCache:   true
					},

					files: {
						'assets/css/master.css':         'assets/css/sass/master.scss',
						'assets/css/editor.css':         'assets/css/sass/editor.scss'
					}
				}
			},

			/**
			 * Processes and compresses JavaScript.
			 */
			uglify: {

				production: {

					options: {
						beautify:         false,
						preserveComments: false,
						sourceMap:        false,
						mangle:           {
							reserved: ['jQuery']
						}
					},

					files: {
						'assets/js/footer.min.js':         [
							'assets/js/src/progress.js',
							'assets/js/src/skip-link-focus-fix.js',
							'assets/js/src/scripts.js'
						]
					}
				},

				dev: {

					options: {
						beautify:         true,
						preserveComments: true,
						sourceMap:        true,
						mangle:           {
							reserved: ['jQuery']
						}
					},

					files: {
						'assets/js/footer.js':         [
							'assets/js/src/progress.js',
							'assets/js/src/skip-link-focus-fix.js',
							'assets/js/src/scripts.js'
						]
					}
				}
			},

			/**
			 * Update translation file.
			 */
			makepot: {

				target: {
					options: {
						type:       'wp-theme',
						domainPath: '/languages',
						mainFile:   'style.css'
					}
				}
			},

			/**
			 * Clean up the JavaScript
			 */
			jshint: {
				options: {
					jshintrc: true
				},
				all:     ['assets/js/src/*.js']
			},

			/**
			 * Watch scripts and styles for changes
			 */
			watch: {

				options: {
					livereload: false
				},

				styles: {

					files: [
						'assets/css/sass/**/*'
					],

					tasks: ['clean:styles', 'sass', 'postcss', 'cssmin']

				},

				scripts: {

					files: [
						'assets/js/src/**/*.*'
					],

					tasks: ['jshint', 'clean:scripts', 'uglify:production', 'uglify:dev']

				}
			}
		}
	);

	// A very basic default task.
	grunt.registerTask('default', ['clean', 'jshint', 'sass', 'postcss', 'cssmin', 'jshint', 'uglify:production', 'uglify:dev', 'makepot']);
	grunt.registerTask('dev', ['default', 'watch']);

};
