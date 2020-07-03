jQuery(function($) {

    //change menu texts to make them shorter
    var sidebarNames = ['Home', 'Wallets', 'Financial Movements'];
    $('#sidebar .nav > .nav-item > .nav-link > .nav-text > span:first-child').each(function(index) {
        $(this).text(sidebarNames[index])
    })
    $('#sidebar .badge-primary').remove();

    //add big buttons to the "mega" menu
    $('#sidebar .nav > .nav-item.active > .submenu > .submenu-inner').prepend(
        '<li class="nav-item">\
     <div class="d-flex flex-wrap justify-content-center flex-xl-nowrap p-2 bgc-default-l4">\
      <button type="button" class="btn btn-sm btn-app btn-outline-primary btn-bgc-white radius-1 my-1 mx-1">\
              <i class="d-block h-6 fa fa-edit text-190"></i>\
              Edit\
              <span class="badge badge-warning badge-sm position-tl m-n2 text-70">11</span>\
      </button>\
      <button type="button" class="btn btn-sm btn-app btn-outline-secondary btn-bgc-white radius-1 my-1 mx-1">\
              <i class="d-block h-6 fa fa-cog text-190"></i>\
              Settings\
              <span class="badge badge-sm py-2px position-tr text-75 mt-1px text-dark-tp4">+3</span>\
          </button>\
          <button type="button" class="btn btn-sm btn-app btn-outline-success btn-bgc-white radius-1 my-1 mx-1">\
              <i class="d-block h-6 fa fa-sync text-190"></i>\
              Reload\
          </button>\
      </div>\
  </li>');

    // in demo we have added .invisible class to .sidebar-inner
    // because we are dynamically chaning it, like the above changes
    // and now we remove .invisible
    $('#sidebar .sidebar-inner').removeClass('invisible');

    // when collapsing it, remove nav-fill
    $('#sidebar').on('collapse.ace.sidebar', function() {
        $(this).find('.nav').removeClass('nav-fill text-center');
        $('#id-full-width').prop('checked', false)
    })
    $('#sidebar').on('expand.ace.sidebar', function() {
        $(this).find('.nav').addClass('nav-fill text-center');
        $('#id-full-width').prop('checked', true)
    })


    // make navbar not fixed, sidebar fixed (sticky)
    $('#id-navbar-fixed').prop('checked', false)
    $('.navbar').toggleClass('navbar-fixed', false)


    $('#id-full-width').on('change', function() {
        $('.sidebar .nav').toggleClass('nav-fill text-center');
    });

    $('#id-flip-highlight').on('change', function() {
        $('.sidebar .nav').toggleClass('active-on-right');
    });

    $('#id-sm-highlight').on('change', function() {
        $('.sidebar .nav').toggleClass('nav-active-sm');
    });
});