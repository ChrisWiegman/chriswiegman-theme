module.exports = function ( grunt ) {

	// Start out by loading the grunt modules we'll need
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		sass: {
			options: {
				style: 'compressed',
				sourcemap: true,
				noCache: true
			},
			production: {
				files: {
					'css/master.css': 'lib/scss/master.scss'
				}
			}
		},

		uglify: {
			options: {
				beautify: false,
				preserveComments: false
			},
			production: {
				options: {
					beautify: false,
					mangle: {
						except: ['jQuery']
					}
				},
				files: {
					'js/footer.min.js': [
						'lib/js/skip-link-focus-fix.js',
						'lib/js/backstretch.js',
					    'lib/js/scripts.js'
					]
				}
			}
		},

		watch: {
			options: {
				livereload: true
			},
			styles: {
				files: [
					'lib/scss/components/font-awesome/*',
					'lib/scss/components/*',
					'lib/scss/*'
				],
				tasks: [ 'sass' ]
			},
			scripts: {
				files: [
					'lib/js/*'
				],
				tasks: ['uglify']
			}
		}

	} );

	// A very basic default task.
	grunt.registerTask( 'default',
		[
			'sass',
			'uglify'
		]
	);

};