module.exports = function ( grunt ) {

	// Start out by loading the grunt modules we'll need
	require ( 'load-grunt-tasks' ) ( grunt );

	grunt.initConfig (
		{

			autoprefixer : {

				options : {
					browsers : ['last 5 versions']
				},

				files : {
					expand  : true,
					flatten : true,
					src     : 'assets/css/*.css',
					dest    : 'assets/css'
				}

			},

			cssmin : {

				target : {

						files : [{
						         expand : true,
						         cwd    : 'assets/css',
						         src    : ['*.css'],
						         dest   : 'lib/css',
						         ext    : '.min.css'
					         }]

				}

			},

			sass : {

				production : {

					options : {
						style     : 'expanded',
						sourcemap : 'none',
						noCache   : true
					},

					files : {
						'assets/css/master.css' : 'assets/scss/master.scss',
						'assets/css/editor.css' : 'assets/scss/editor.scss'
					}

				},

				development : {

					options : {
						style     : 'expanded',
						sourcemap : 'auto',
						noCache   : true
					},

					files : {
						'lib/css/master.css' : 'assets/scss/master.scss',
						'lib/css/editor.css' : 'assets/scss/editor.scss'
					}

				}

			},

			uglify : {

				production : {

					options : {
						beautify         : false,
						preserveComments : false,
						mangle           : {
							except : ['jQuery']
						}
					},

					files : {
						'lib/js/footer.min.js' : [
							'assets/js/analytics.js',
							'assets/js/progress.js',
							'assets/js/skip-link-focus-fix.js',
							'assets/js/scripts.js'
						]
					}

				},

				development : {

					options : {
						beautify         : true,
						preserveComments : true
					},

					files : {
						'lib/js/footer.js' : [
							'assets/js/analytics.js',
							'assets/js/progress.js',
							'assets/js/skip-link-focus-fix.js',
							'assets/js/scripts.js'
						]
					}

				}

			},

			watch : {

				options : {
					livereload : true
				},

				styles : {

					files : [
						'assets/scss/**/*'
					],

					tasks : ['sass:development']

				},

				scripts : {

					files : [
						'assets/js/**/*'
					],

					tasks : ['uglify:development']

				}

			}

		}
	);

	// A very basic default task.
	grunt.registerTask ( 'dev', ['sass:development', 'sass:production', 'autoprefixer', 'cssmin',  'uglify:development', 'uglify:production', 'watch'] );
	grunt.registerTask ( 'default', ['sass:development', 'sass:production', 'autoprefixer', 'cssmin',  'uglify:development', 'uglify:production'] );

};