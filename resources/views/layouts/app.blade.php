<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'AdminLTE 3 | Dashboard')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

  @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('layouts.header')

  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid pt-3 px-3">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Please check the following errors:</strong>
          <ul class="mb-0 mt-1 pl-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
    </div>

    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.footer')

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script>
$(function () {
  var $input = $('#sidebar-menu-search');
  var $results = $('#sidebar-menu-search-results');
  var $btn = $('#sidebar-menu-search-btn');

  if (!$input.length) {
    return;
  }

  function menuItems() {
    var items = [];

    $('.nav-sidebar .nav-item').each(function () {
      var $link = $(this).children('a.nav-link').first();
      if (!$link.length) {
        return;
      }

      var href = ($link.attr('href') || '').trim();
      if (!href || href === '#' || href.indexOf('javascript:') === 0) {
        return;
      }

      var name = $link.children('p').clone().children().remove().end().text().trim();
      if (!name) {
        name = $link.text().trim();
      }
      if (!name) {
        return;
      }

      var path = [];
      $link.parents('.nav-item').each(function () {
        var parentName = $(this).children('a.nav-link').children('p').clone().children().remove().end().text().trim();
        if (parentName && parentName !== name) {
          path.unshift(parentName);
        }
      });

      items.push({ name: name, href: href, path: path.join(' → ') });
    });

    return items;
  }

  function hideResults() {
    $results.attr('hidden', true).empty();
    $btn.find('i').removeClass('fa-times').addClass('fa-search');
  }

  function showResults(html) {
    $results.html(html).removeAttr('hidden');
    $btn.find('i').removeClass('fa-search').addClass('fa-times');
  }

  function render(query) {
    var q = (query || '').trim().toLowerCase();
    if (!q) {
      hideResults();
      return;
    }

    var matches = menuItems().filter(function (item) {
      return item.name.toLowerCase().indexOf(q) !== -1
        || item.path.toLowerCase().indexOf(q) !== -1;
    });

    if (!matches.length) {
      showResults('<div class="empty">No menu item found</div>');
      return;
    }

    var html = matches.map(function (item, index) {
      var path = item.path ? '<span class="search-path">' + item.path + '</span>' : '';
      var active = index === 0 ? ' active' : '';
      return '<a class="' + active.trim() + '" href="' + item.href + '">' + item.name + path + '</a>';
    }).join('');

    showResults(html);
  }

  function goToActive() {
    var $active = $results.find('a.active').first();
    if ($active.length) {
      window.location.href = $active.attr('href');
    }
  }

  $input.on('input', function () {
    render($(this).val());
  });

  $input.on('keydown', function (e) {
    var $links = $results.find('a');
    if (!$links.length) {
      return;
    }

    var $active = $links.filter('.active');
    var index = $links.index($active);

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      $links.removeClass('active');
      $links.eq(Math.min(index + 1, $links.length - 1)).addClass('active');
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      $links.removeClass('active');
      $links.eq(Math.max(index - 1, 0)).addClass('active');
    } else if (e.key === 'Enter') {
      e.preventDefault();
      goToActive();
    } else if (e.key === 'Escape') {
      hideResults();
      $input.val('');
    }
  });

  $results.on('mouseenter', 'a', function () {
    $results.find('a').removeClass('active');
    $(this).addClass('active');
  });

  $btn.on('click', function () {
    if ($results.is('[hidden]')) {
      render($input.val());
      $input.focus();
    } else {
      hideResults();
      $input.val('').focus();
    }
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.sidebar-menu-search').length) {
      hideResults();
    }
  });

  $('#navbar-menu-search-form').on('submit', function (e) {
    e.preventDefault();
    var query = ($('#navbar-menu-search').val() || '').trim().toLowerCase();
    if (!query) {
      return;
    }

    var match = menuItems().find(function (item) {
      return item.name.toLowerCase().indexOf(query) !== -1
        || item.path.toLowerCase().indexOf(query) !== -1;
    });

    if (match) {
      window.location.href = match.href;
    } else {
      alert('No matching page found in the menu.');
    }
  });
});
</script>

@stack('scripts')
</body>
</html>