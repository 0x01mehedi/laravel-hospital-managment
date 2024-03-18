@extends('layouts.app')
@section('page')

<?php
    echo Page::header(["title"=>"Edit Doctor"]);
    echo Page::body_open();
    echo Page::content_open(["title"=>"Edit Doctor"]);

    echo Form::open_laravel(["route"=>"doctors/$doctor->id","method"=>"PUT"]);
    echo Form::text(["name"=>"name","label"=>"Name","value"=>"$doctor->name"]);
    echo Form::text(["name"=>"email","label"=>"Email","value"=>"$doctor->email"]);
    echo Form::text(["name"=>"phone","label"=>"Phone","value"=>"$doctor->phone"]);
    echo Form::button(["name"=>"btnSubmit","type"=>"submit","value"=>"Update"]);
    echo Form::close();

    echo Page::content_close();
    echo Page::body_close();


?>


@endsection