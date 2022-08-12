<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('admin.name')}}</title>
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/c.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/iconfont.css') }}">
    <script src='{{ URL::asset('vendor/laravel-admin/js/jquery.min.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('vendor/laravel-admin/js/c.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('vendor/laravel-admin/js/admin.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('vendor/laravel-admin/js/bootstrap-treeview.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('vendor/laravel-admin/js/ckeditor.js') }}' type='text/javascript'></script>
</head>
<body>
<style>
    .ck-editor__editable_inline {height: 500px;border-left:1px solid #c4c4c4 !important;border-bottom:1px solid #c4c4c4 !important;border-right:1px solid #c4c4c4 !important;border-top:none !important;}
</style>
