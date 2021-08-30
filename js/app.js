// Dom7
var $$ = Dom7;

// Theme
var theme = 'auto';
if (document.location.search.indexOf('theme=') >= 0) {
  theme = document.location.search.split('theme=')[1].split('&')[0];
}

// Init App
var app = new Framework7({
  id: 'io.framework7.partner',
  root: '#partner',
  theme: theme,
  data: function () {
    return {
      user: {
        firstName: 'John',
        lastName: 'Doe',
      },
    };
  },
  methods: {
    helloWorld: function () {
      app.dialog.alert('Hello World!');
    },
  },
  routes: routes,
  toolbar: {
    hideOnPageScroll: true,
  },
  onAjaxStart: function (xhr) { app.preloader.show(); },
  onAjaxComplete: function (xhr) {  setTimeout(function () {
    app.preloader.hide();
  }, 3000);} 
});

/* show hide app loader */
app.preloader.show();
$(window).on('load', function(){
     app.preloader.hide();
})

/* page inside iframe just for demo app */
if (self !== top) {
     $('body').addClass('max-demo-frame')
 }


$$(document).on('page:init', '.page[data-name="dashboard"]', function (e) {   
    $(".dynamicsparkline").sparkline([5,6,7,2,0,4,2,5,6,7,2,0,4,2,4], { type: 'bar', height: '25', barSpacing: 2, barColor: '#a9d7fe', negBarColor: '#ef4055', zeroColor: '#ffffff'});
});

$$(document).on('page:init', '.page[data-name="project-list"]', function (e) {   
    $(".dynamicsparkline").sparkline([5,6,7,2,0,4,2,5,6,7,2,0,4,2,4], { type: 'bar', height: '25', barSpacing: 2, barColor: '#a9d7fe', negBarColor: '#ef4055', zeroColor: '#ffffff'});
});

$$(document).on('page:init', '.page[data-name="profile"]', function (e) {   
    $(".dynamicsparkline").sparkline([5,6,7,2,0,4,2,5,6,7,2,0,4,2,4], { type: 'bar', height: '25', barSpacing: 2, barColor: '#a9d7fe', negBarColor: '#ef4055', zeroColor: '#ffffff'});
});

$$(document).on('page:init', '.page[data-name="project-detail"]', function (e) {   
    $(".dynamicsparkline").sparkline([5,6,7,2,0,4,2,5,6,7,2,0,4,2,4], { type: 'bar', height: '25', barSpacing: 2, barColor: '#a9d7fe', negBarColor: '#ef4055', zeroColor: '#ffffff'});
  
    
});