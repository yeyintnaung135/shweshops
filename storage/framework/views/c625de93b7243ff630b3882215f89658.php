<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="<?php echo e(url('fonts/css/all.min.css')); ?>">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Myanmar3';
            src: local('Myanmar3'), url("<?php echo e(url('mmfont/PyidaungsuZawDecode.woff2?93a8fffb927d8bfcaac5683829dcd048')); ?>") format('woff2'), url("<?php echo e(url('PyidaungsuZawDecode.woff?0e8dd9ee5f902f7ff573524de8b4f94d')); ?>") format('woff');
        }
        .yk-font{
            font-family: 'Myanmar3', Sans-Serif !important;

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
        }

        .highlight-text {
            color: #780116;
        }

        .btn-refresh {
            background-color: #780116;
            color: #fff;
            font-size: 1rem;
        }
        
        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */

            display: flex;
            align-items: center;
        }

        .icon-rotate {
            /* width: 100px; */
            animation: rotation 12s infinite linear;
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(359deg);
            }
        }

    </style>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body style="background-color:white;" class="yk-font">
<div style=""></div>
    <div id="app" >



















































        <main >
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <script src="<?php echo e(url('plugins/jquery/jquery.min.js')); ?>"></script>

        <?php echo $__env->yieldPushContent('scripts'); ?>

    </div>
</body>
</html>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/app.blade.php ENDPATH**/ ?>