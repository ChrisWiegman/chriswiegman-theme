module.exports = function ( grunt ) {

	// Start out by loading the grunt modules we'll need
	require ( 'load-grunt-tasks' ) ( grunt );

	grunt.initConfig (
		{

			clean : {
				dist : {
					src : ['lib']
				}
			},

			autoprefixer : {

				options : {
					browsers : ['last 5 versions'],
					map      : true
				},

				files : {
					expand  : true,
					flatten : true,
					src     : 'lib/css/*.css',
					dest    : 'lib/css'
				}

			},

			cssmin : {

				target : {

					files : [{
						         expand : true,
						         cwd    : 'lib/css',
						         src    : ['*.css'],
						         dest   : 'lib/css',
						         ext    : '.min.css'
					         }]

				}

			},

			sass : {

				dist : {

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

					tasks : ['sass', 'autoprefixer', 'cssmin']

				},

				scripts : {

					files : [
						'assets/js/**/*'
					],

					tasks : ['uglify:development', 'uglify:production']

				}

			}

		}
	);

	// A very basic default task.
	grunt.registerTask ( 'default', ['clean', 'sass', 'autoprefixer', 'cssmin', 'uglify:development', 'uglify:production', 'watch'] );
	grunt.registerTask ( 'prod', ['clean', 'sass', 'autoprefixer', 'cssmin', 'uglify:development', 'uglify:production'] );

};