// -------------------- RELEASE (generate package for themeforest) --------------------------

// get scutum version
const pjson = require('../../package.json');
const version = pjson.version;

// directories
const releaseDir = '../../../_release/' + version + '/';
const releaseSrcDir = releaseDir + '/scutum_v' + version + '/admin/html/src/';
const releaseDistDir = releaseDir + '/scutum_v' + version + '/admin/html/dist/';
const releaseVuejsSrcDir = releaseDir + '/scutum_v' + version + '/admin/vuejs/';
const releaseDocDir = releaseDir + '/scutum_v' + version + '/documentation/';
const releaseLandingPageDir = releaseDir + '/scutum_v' + version + '/landing_page/';
const releaseDemoDir = releaseDir + '/demo/';
const vuejsDir = '../../vuejs/';
const landingPageDir = '../../vuejs/';

module.exports = function (gulp, plugins, onError, del, exec) {
	const modules = {};
	modules.cleanup = function () {
		return del(
			[
				releaseDir + '**',
				releaseDemoDir + '**'
			],
			{ force: true }
		)
	};
	modules.copySrcFiles = function (done) {
		gulp.src([
			'**/*',
			'.*',
			'!{.idea, .idea/**}',
			'!{node_modules,node_modules/**}'
		], {base: './'})
			.pipe(gulp.dest(releaseSrcDir));
		done();
	};
	modules.copyDistFiles = function (done) {
		gulp.src([
			'**/*'
		], {cwd: '../dist'})
			.pipe(gulp.dest(releaseDistDir))
			.pipe(gulp.dest(releaseDemoDir + 'scutum-html/'));
		done();
	};
	modules.copyVueSrcFiles = function (done) {
		gulp.src([
			'**/*',
			'.*',
			'!{node_modules,node_modules/**}',
			'!{scutum-spa,scutum-spa/**}',
			'!{scutum-universal,scutum-universal/**}',
			'!{.idea, .idea/**}',
			'!{.nuxt, .nuxt/**}',
			'!{.https, .https/**}'
		], {cwd: vuejsDir + '/src'})
			.pipe(gulp.dest(releaseVuejsSrcDir + 'src/'));
		done();
	};
	modules.copyVueSsrFiles = function (done) {
		gulp.src([
			'**/*',
			'.*'
		], {cwd: vuejsDir + 'src/scutum-universal/'})
			// .pipe(gulp.dest(releaseVuejsSrcDir + 'scutum-universal/'))
			.pipe(gulp.dest(releaseDemoDir + 'scutum-universal/'));
		done();
	};
	modules.copyVueSpaFiles = function (done) {
		gulp.src([
			'**/*',
			'.*'
		], {cwd: vuejsDir + 'src/scutum-spa/'})
			// .pipe(gulp.dest(releaseVuejsSrcDir + 'scutum-spa/'))
			.pipe(gulp.dest(releaseDemoDir + 'scutum-spa/'));
		done();
	};
	modules.copyVueLaravelFiles = function (done) {
		gulp.src([
			'**/*',
			'.*',
			'!{.idea, .idea/**}',
		], {cwd: vuejsDir + 'laravel-nuxt/'})
			.pipe(gulp.dest(releaseVuejsSrcDir + 'laravel-nuxt/'));
		done();
	};
	modules.copyLandingPage = function (done) {
		gulp.src([
			'index.html',
			'favicon.ico',
			'{assets,assets/**}',
			'!{node_modules,node_modules/**}',
			'!{.idea, .idea/**}',
		], {cwd: '../../../landing_page/'})
			.pipe(gulp.dest(releaseDemoDir + 'landing-page/'))
			.pipe(gulp.dest(releaseLandingPageDir));
		done();
	};
	modules.copyDocumentation = function (done) {
		gulp.src([
			'**/*'
		], {cwd: '../../../documentation/'})
			.pipe(gulp.dest(releaseDocDir));
		done();
	};
	modules.generateDemoHTML = function (cb) {
		exec('php build/generate_html_demo.php', cb);
	};
	return modules;
};