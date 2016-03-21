module.exports = function ( grunt ) {

	// Start out by loading the grunt modules we'll need
	require( 'load-grunt-tasks' )( grunt );

	grunt.initConfig(
		{

			/**
			 * Clean existing files
			 */
			clean : {
				styles : {
					src : [
						'assets/css/*.css',
						'assets/css/*.map'
					]
				},
				scripts : {
					src : [
						'assets/js/*.js',
						'assets/js/*.map'
					]
				}
			},

			/**
			 * Autoprefix CSS
			 */
			autoprefixer : {

				options : {
					browsers : ['last 5 versions'],
					map      : true
				},

				files : {
					expand  : true,
					flatten : true,
					src     : ['assets/css/*.css'],
					dest    : 'assets/css'
				}

			},

			/**
			 * Minify CSS
			 */
			cssmin : {

				target : {

					files : [{
						expand : true,
						cwd    : 'assets/css',
						src    : ['*.css'],
						dest   : 'assets/css',
						ext    : '.min.css'
					}]

				}

			},

			/**
			 * Process SASS files
			 */
			sass : {

				dist : {

					options : {
						style     : 'expanded',
						sourceMap : true,
						noCache   : true
					},

					files : {
						'assets/css/style.css' : 'assets/sass/style.scss'
					}

				}

			},

			/**
			 * Processes and compresses JavaScript.
			 */
			uglify : {

				production : {

					options : {
						beautify         : false,
						preserveComments : false,
						sourceMap        : false,
						mangle           : {
							except : ['jQuery']
						}
					},

					files : {
						'assets/js/theme.min.js' : [
							'assets/js/src/navigation.js',
						    'assets/js/src/skip-link-focus-fix.js',
							'assets/js/src/scripts.js'
						]
					}
				},

				dev : {

					options : {
						beautify         : true,
						preserveComments : true,
						sourceMap        : true,
						mangle           : {
							except : ['jQuery']
						}
					},

					files : {
						'assets/js/theme.js' : [
							'assets/js/src/navigation.js',
							'assets/js/src/skip-link-focus-fix.js',
							'assets/js/src/scripts.js'
						]
					}
				}

			},

			/**
			 * Update translation file.
			 */
			makepot : {

				target : {
					options : {
						type       : 'wp-theme',
						domainPath : '/languages',
						mainFile   : 'style.css'
					}
				}
			},

			/**
			 * Run PHP unit tests.
			 */
			phpunit : {

				classes : {
					dir : 'tests/'
				},

				options : {

					bin        : './vendor/bin/phpunit',
					testSuffix : 'Tests.php',
					bootstrap  : 'bootstrap.php',
					colors     : true

				}
			},

			/**
			 * Clean up the JavaScript
			 */
			jshint : {
				options : {
					jshintrc : true
				},
				all     : ['assets/js/src/*.js']
			},

			/**
			 * A better browser reloader
			 */
			browserSync : {
				bsFiles : {
					src : 'assets/**/*.*'
				},
				options : {
					proxy     : 'www.chriswiegman.pv',
					watchTask : true
				}
			},

			/**
			 * Watch scripts and styles for changes
			 */
			watch : {

				options : {
					livereload : false
				},

				styles : {

					files : [
						'assets/sass/**/*'
					],

					tasks : ['clean:styles', 'sass', 'autoprefixer', 'cssmin']

				},

				scripts : {

					files : [
						'assets/js/src/**/*.*'
					],

					tasks : ['clean:scripts','uglify:production']

				}
			}
		}
	);

	// A very basic default task.
	grunt.registerTask( 'default', ['phpunit', 'jshint', 'clean:styles', 'sass', 'autoprefixer', 'cssmin', 'phpunit', 'jshint', 'clean:scripts', 'uglify:production', 'uglify:dev', 'makepot'] );
	grunt.registerTask( 'dev', ['default', 'browserSync', 'watch'] );

};