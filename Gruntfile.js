module.exports = function ( grunt ) {

	// Start out by loading the grunt modules we'll need
	require ( 'load-grunt-tasks' ) ( grunt );

	grunt.initConfig (
		{

			clean : ["assets/css", "lib"],

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

				minify : {
					expand : true,
					cwd    : 'assets/css',
					src    : ['*.css'],
					ext    : '.css'
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
						'assets/css/master.css' : 'assets/scss/master.scss'
					}

				},

				development : {

					options : {
						style     : 'expanded',
						sourcemap : 'auto',
						noCache   : true
					},

					files : {
						'lib/css/master.css' : 'assets/scss/master.scss'
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
						'lib/js/footer.js' : [
							'assets/js/skip-link-focus-fix.js',
							'assets/js/backstretch.js',
							'assets/js/scripts.js'
						]
					}

				},

				development : {

					options : {
						beautify         : true,
						preserveComments : true,
						mangle           : {
							except : ['jQuery']
						}
					},

					files : {
						'lib/js/footer.js' : [
							'assets/js/skip-link-focus-fix.js',
							'assets/js/backstretch.js',
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
	grunt.registerTask ( 'default', ['sass:development', 'uglify:development', 'watch'] );
	grunt.registerTask ( 'prod', ['clean','sass:production', 'autoprefixer', 'cssmin', 'uglify:production'] );

};