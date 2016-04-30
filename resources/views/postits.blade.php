@extends('layouts.default')
@section('styles')
    <link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/postit.css')}}">
@stop
@section('body')
<ul class="post">
  <li ng-repeat="postit in postits">
    <post-it message="postit.message"></post-it>
  </li>
</ul>
<!-- <input type="text" ng-model="title" /> -->
@stop

@section('scripts')
 // var url = '{{route('api.v1.postit.vote.store',['postit'=>'#postit'])}}'.replace('#postit',postit.id)
@stop
