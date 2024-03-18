@extends('layouts.app')
@section('page')
<?php
    echo Page::header(["title"=>"Create Doctor"]);
    echo Page::body_open();
    echo Page::content_open(["title"=>"Create Doctor"]);

  echo Form::open_laravel(["route"=>"doctors"]);
  echo Form::text(["name"=>"name","label"=>"Name"]);
  echo Form::text(["name"=>"email","label"=>"Email"]);
  echo Form::text(["name"=>"phone","label"=>"Phone"]);
  echo Form::button(["name"=>"btnSubmit","value"=>"Save","type"=>"submit"]);
  echo Form::close();
  echo Page::content_close();
  echo Page::body_close();
?>
@endsection