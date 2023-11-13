<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" type="image/png" sizes="19x19" href="<?php echo e(url('images/logo/favicon.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="<?php echo e(url('fonts/ssp.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo e(url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(url('dist/css/adminlte.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('test/css/bootstrap-toggle.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('plugins/jquery-ui/jquery-ui.min.css')); ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo e(url('plugins/summernote/summernote-bs4.min.css')); ?>">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="<?php echo e(url('plugins/codemirror/codemirror.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('plugins/codemirror/theme/monokai.css')); ?>">
    <!-- SimpleMDE -->
    <link rel="stylesheet" href="<?php echo e(url('plugins/simplemde/simplemde.min.css')); ?>">


    <!-- <script> -->

   <!-- </script> -->
    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("<?php echo e(url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048')); ?>") format('woff2'),url("<?php echo e(url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d')); ?>") format('woff');
        }

        .swal-yk-title {
            color: #28a745 !important;
        }
        .dataTables_filter{
            margin-top:43px !important;
        }
    </style>
    <style>
        .sop-font, .sn-product-title {
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .yk-circle{
            border: 2px solid black;
            width: 36px;
            height: 36px;
            border-radius: 20px;
            text-align: center;
        }
        .yk-background{
            background-color: #f7b538;

        }
        .yk-btn-success {
            color: #fff;
            background-color: #f7b538;
            border-color: #ffa713;
        }
        .yk-btn-success:hover {
            color: #fff;
            background-color: #f7b538;
            border-color: #d99421;
        }
        html, body {
            height: 100%;
            margin: 0;
            overflow: auto;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        h1{
            font-weight:bold !important;
        }
        .yk-info{
            color: black;
        }
        .yk-info .yk-tootips{
            font-size: 18px !important;
            border: 2px solid #680606;
            background: #730d18;
            color: white;
            padding: 10px;
            width: 299px;
            position: absolute;
            z-index: 2222;
            visibility: hidden;
            font-family: 'Myanmar3', Sans-Serif !important;
            line-height: 1.5;
            left: 286px;



        }
        .yk-info:hover .yk-tootips {
            visibility: visible;
        }
          /* zh-media-query */
         @media (max-width: 576px) {
            .zh-header_shop{
                margin-left: 0% !important;
            }
         }
        @media (max-width: 576px) {
            .zh-header_shop {
                margin-left: 0% !important;
            }
            .yk-info .yk-tootips{
                font-size: 18px !important;

                border: 2px solid #680606;
                background: #730d18;
                color: white;
                padding: 10px;
                width: 314px;
                position: absolute;
                left:43px;
                z-index: 2222;
                visibility: hidden;
                font-family: 'Myanmar3', Sans-Serif !important;
                line-height: 1.5;


            }
        }

        legend {
          margin-bottom: 0px;
          margin-left: 18px;
          font-size: 13px;
          padding: 0 5px;
          color: rgba(64, 77, 97, 0.55);
          width: auto !important;
          font-weight: 700;
        }

    </style>
<?php echo $__env->yieldPushContent('css'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" style="height: 100%;">
      <?php echo $__env->yieldContent('content'); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo e(url('plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(url('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo e(url('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>

<script src="<?php echo e(url('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/pdfmake/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(url('plugins/datatables-buttons/js/buttons.colVis.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(url('dist/js/adminlte.min.js')); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(url('dist/js/demo.js')); ?>"></script>
<!-- Page specific script -->
<script src="<?php echo e(url('plugins/sweetalert2/sweetalert2.all.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(url('test/css/sntable.css')); ?>">
<script src="<?php echo e(url('plugins/summernote/summernote-bs4.min.js')); ?>"></script>

<script type="text/javascript">


        let data = new Array();
        let localData = new Array();
        let item_id = new Array();
        let boxes = new Array();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable
                .tables({visible: true, api: true})
                .columns.adjust().responsive.recalc();
        })






  $(function () {

      // $('#xfafe').DataTable({
      //     "responsive": true,

      //     "paging": true,
      //     "lengthChange": false,
      //     "searching": false,
      //     "ordering": true,
      //     "info": true,
      //     "autoWidth": false

      // });


      $("#datatable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          'columnDefs': [
              {responsivePriority: 1, targets: 2},
              {responsivePriority: 2, targets: 1},
              {responsivePriority: 3, targets: 3},
              {
                  "targets": [4],
                  'orderable': false,
              }
          ],
          language: {
              "search": '<i class="fa-solid fa-search sn-search-icon"></i>',
              "searchPlaceholder": 'Search by name or role or phone',
              paginate: {
                  next: '<i class="fa fa-angle-right"></i>', // or '→'
                  previous: '<i class="fa fa-angle-left"></i>' // or '←'
              }
          },
          "order": [0, 'desc']
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  });


  if (window.performance) {
      localStorage.removeItem('localData');
  }

  //Super Admin Count lists






</script>


<script src="<?php echo e(url('test/js/bootstrap-toggle.js')); ?>"></script>

<link rel="stylesheet" href="<?php echo e(url('test/css/sntable.css')); ?>">

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/backend/super_admin/datatable.blade.php ENDPATH**/ ?>