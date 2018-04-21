var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var cssmin = require('gulp-cssmin');
var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var browserSync= require('browser-sync');
var reload= browserSync.reload;
var sass = require('gulp-sass');


/*
 * images task 
 * 
 */

gulp.task('images', function () {
    gulp.src('src/FrontEnd/images/*', {
            base: 'src/FrontEnd/images/'
        })
        .pipe(gulp.dest('web/images/'))
        .pipe(reload({stream:true}));
});
/*
 * sass task 
 * 
 */


gulp.task('dashboard_styles_sass', function () {
    gulp.src('src/FrontEnd/scss/dashboard_styles/dashboard_styles_main.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(concat('dashboard_styles.css'))
        .pipe(gulpif(env == 'prod', cssmin()))
        .pipe(gulp.dest('web/css/'))
        .pipe(reload({stream:true}));
});


gulp.task('homepage_styles_sass', function () {
    gulp.src('src/FrontEnd/scss/homepage_styles/homepage_styles_main.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(concat('homepage_styles.css'))
        .pipe(gulpif(env == 'prod', cssmin()))
        .pipe(gulp.dest('web/css/'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_other_sass', function () {
    gulp.src('src/FrontEnd/scss/mobile_styles/mobile_other/mobile_styles_main.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(concat('mobile_styles.css'))
        .pipe(gulpif(env == 'prod', cssmin()))
        .pipe(gulp.dest('web/css/'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_discussion_sass', function () {
    gulp.src('src/FrontEnd/scss/mobile_styles/mobile_discussion/mobile_discussion_main.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(concat('mobile_discussion_styles.css'))
        .pipe(gulpif(env == 'prod', cssmin()))
        .pipe(gulp.dest('web/css/'))
        .pipe(reload({stream:true}));
});


gulp.task('mobile_fos_sass', function () {
    gulp.src('src/FrontEnd/scss/mobile_styles/mobile_fos/mobile_fos_main.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(concat('mobile_fos_styles.css'))
        .pipe(gulpif(env == 'prod', cssmin()))
        .pipe(gulp.dest('web/css/'))
        .pipe(reload({stream:true}));
});


/*
 * javascript task 
 * 
 */

gulp.task('lib-js', function() {
 return gulp.src([
 'bower_components/jquery/jquery.js',
 'bower_components/jquery-ui/jquery-ui.js',
 'bower_components/moment/moment.js',
 'bower_components/jsrender/jsrender.js',
 'bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js'
 ])
 .pipe(concat('app.js'))
// .pipe(gulpif(env == 'prod', uglify()))
 .pipe(gulp.dest('web/js/'))
 .pipe(reload({stream:true}));
});


gulp.task('dashboard_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/dashboard_js/*.js'])
        .pipe(concat('dashboard_js.js'))
//        .pipe(gulpif(env == 'prod', uglify()))
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});

gulp.task('homepage_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/homepage_js/*.js'])
        .pipe(concat('homepage_js.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_new_item_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/mobile_js/mobile_new_item_js/*.js'])
        .pipe(concat('mobile_new_item_js.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_chat_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/mobile_js/mobile_chat_js/*.js'])
        .pipe(concat('mobile_chat_js.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_my_inbox_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/mobile_js/mobile_my_inbox_js/*.js'])
        .pipe(concat('mobile_my_inbox_js.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});

gulp.task('mobile_show_js', function () {
    gulp.src([
        'src/FrontEnd/js/forthparty/mobile_js/mobile_show_js/*.js'])
        .pipe(concat('mobile_show_js.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('web/js'))
        .pipe(reload({stream:true}));
});
/*
 * Browser syncing task 
 * 
 */

gulp.task('browser-sync', function(){
    browserSync.init({
        //proxy: "community.dev/web/app_dev.php"
        proxy: "127.0.0.1:8000/app_dev.php"
    });
});


/*
 * Watch task 
 * 
 */
gulp.task('watch', function()
{
   gulp.watch('src/FrontEnd/js/forthparty/dashboard_js/*.js',['dashboard_js']);
   gulp.watch('src/FrontEnd/js/forthparty/homepage_js/*.js',['homepage_js']);
   gulp.watch('src/FrontEnd/js/forthparty/mobile_js/mobile_new_item_js/*.js',['mobile_new_item_js']);
   gulp.watch('src/FrontEnd/js/forthparty/mobile_js/mobile_chat_js/*.js',['mobile_chat_js']);
   gulp.watch('src/FrontEnd/js/forthparty/mobile_js/mobile_my_inbox_js/*.js',['mobile_my_inbox_js']);
   gulp.watch('src/FrontEnd/js/forthparty/mobile_js/mobile_show_js/*.js',['mobile_show_js']);
   gulp.watch([
        'bower_components/jquery/jquery.js',
        'bower_components/jquery-ui/jquery-ui.js',
        'bower_components/jsrender/jsrender.js',
        'bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js'
        ],['lib-js']);
   gulp.watch('src/FrontEnd/scss/homepage_styles/*',['homepage_styles_sass']);
   gulp.watch('src/FrontEnd/scss/dashboard_styles/*',['dashboard_styles_sass']);
   gulp.watch('src/FrontEnd/scss/mobile_styles/mobile_discussion/*',['mobile_discussion_sass']);
   gulp.watch('src/FrontEnd/scss/mobile_styles/mobile_other/*',['mobile_other_sass']);
   gulp.watch('src/FrontEnd/scss/mobile_styles/mobile_fos/*',['mobile_fos_sass']);
    gulp.watch('src/FrontEnd/images/*',['images']);
    
});

gulp.task('default', [
    'browser-sync',
    'dashboard_styles_sass',
    'homepage_styles_sass',
    'mobile_discussion_sass',
    'mobile_other_sass',
    'mobile_fos_sass',
    'dashboard_js',
    'homepage_js',
    'mobile_chat_js',
    'mobile_new_item_js',
    'mobile_my_inbox_js',
    'mobile_show_js',
    'images',
    'lib-js',
    'watch']);

