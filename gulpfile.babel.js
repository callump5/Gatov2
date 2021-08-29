import gulp from 'gulp'
import sass from 'gulp-sass'
import browserSync from 'browser-sync';
import del from 'del';

// Create server instance
const server = browserSync.create();

// Paths to Folders & Files
const paths = {
    styles: {
        src : "src/scss/main.scss",
        dest: "public/css"
    }
}

// Init Server (ENTER SERVER LOCATION)
export const serve = (done) => {
    server.init({
        proxy: "gatov2.cal"
    });
    done();
}

// Reload Server
export const reload = (done) => {
    server.reload();
    done();
}

// Delete existing CSS 
export const delCss = () => {
    return del('public/css/main.css');
}

// Convert SCSS to CSS
export const styles = () => {    
    return gulp.src(paths.styles.src)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(server.stream())
}


// Watch For Changes
export const watch = () => {
    gulp.watch('src/**/*.scss', styles);
    gulp.watch('**/*.html', reload);
    gulp.watch('**/*.php', reload);
}

// Dev Function
export const dev = gulp.series( delCss, styles, serve, watch);


//Gulp Default
export default dev;
