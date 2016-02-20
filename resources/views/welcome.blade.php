@extends('layouts.default')
@section('styles')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@stop
@section('body')
    <div class="uk-container uk-container-center">
        <div class="uk-grid" id="postit_form">
            <div class="uk-width-1-1">
                <textarea id="novo_postit" class="uk-width-1-1"></textarea>
                <button class="uk-button uk-button-primary uk-button-large uk-width-1-1" v-on:click="submitPostIt" >Submit</button>
            </div>
        </div>
    </div>
    <div class="uk-container uk-container-center post-its" id="post_its">
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <h2>Mais Novos</h2>
                <div  v-for="postit in newest" class="post-it uk-panel ">
                    <div class="vote">
                        <div class="uk-float-left">
                            <div class="vote uk-text-left">
                                <button v-bind:class="['uk-button', (postit.hasVoted == 1) ? 'uk-button-success' : '']" v-on:click="vote(postit,1,'newest')">
                                    <i class="uk-icon uk-icon-arrow-circle-up"></i>
                                </button>
                                <h3 class="app-inline uk-margin-remove">@{{ postit.vote_summary  }}</h3>
                                <button v-bind:class="['uk-button', (postit.hasVoted == -1) ? 'uk-button-success' :  '']" v-on:click="vote(postit, -1,'newest')">
                                    <i class="uk-icon uk-icon-arrow-circle-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="uk-clearfix">

                            <i>@{{ postit.created_at }}</i>
                        </div>
                    </div>
                    <div class="post uk-panel-box uk-margin-remove">
                        @{{{ postit.message }}}
                    </div>
                </div>
                <hr>
                <button onclick="AddPage('age','newest')" class="uk-margin-remove uk-button  uk-width-1-1">Add more</button>
            </div>
            <div class="uk-width-medium-1-2">
                <h2>Mais Curtidos</h2>
                <div  v-for="postit in most_voted" class="uk-grid post-it uk-panel-box  uk-margin-remove">
                    <div class="uk-width-medium-1-6 uk-width-small-1-4">
                        <div class="vote uk-text-center">
                            <button v-bind:class="['uk-button', (postit.hasVoted == 1) ? 'uk-button-success' : '']" v-on:click="vote(postit,1,'most_voted')" >
                                <i class="uk-icon uk-icon-arrow-circle-up"></i>
                            </button>
                            <h3>@{{ postit.vote_summary  }}</h3>
                            <button v-bind:class="['uk-button', (postit.hasVoted == -1) ? 'uk-button-success' :  '']" v-on:click="vote(postit, -1,'most_voted')">
                                <i class="uk-icon uk-icon-arrow-circle-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="uk-width-medium-6-6 uk-width-small-3-4">
                        @{{{ postit.message }}}
                        <div class="mui-divider"></div>
                        <i>@{{ postit.created_at }}</i>
                    </div>
                </div>
                <button onclick="AddPage('votes','most_voted')" class="uk-margin-remove uk-button uk-width-1-1">Add more</button>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
 <script type="text/javascript">

     var simplemde;

     var SubmitPost = new Vue({

         el: '#postit_form',

         methods: {

             submitPostIt: function(){

                 $.ajax({
                     url: '{{route('api.v1.postit.store')}}',
                     method: 'post',
                     data : {
                         _token: '{{csrf_token()}}',
                         message: simplemde.value()
                     },
                     success:function(json){
                         simplemde.value('')
                         PostIt.add(json);
                     }
                 })

             }
         }

     });

var PostIt = new Vue({

    el: '#post_its',

    data: {
        newest: [],
        most_voted: []
    },

    methods: {

        vote: function(postit, value,target){

            $.ajax({
                url: '{{route('api.v1.postit.vote.store',['postit'=>'#postit'])}}'.replace('#postit',postit.id),
                method: 'post',
                data : {
                    _token: '{{csrf_token()}}',
                    postit_id: postit.id,
                    value: value
                },
                success:function(json){
                    PostIt.update(json,target);
                    PostIt.resort(target);
                }
            })

        },

        add: function(json){
            var postits = PostIt.newest;
            console.log(json,[json].concat(postits));
            PostIt.$set('newest',[json].concat(postits));
        },

        update: function(json,target){

            var postits = PostIt[target];

            for(var i = 0; i<postits.length; i++){
                var postit = postits[i];
                if (postit.id == json.id){
                    postit.vote_summary = json.vote_summary;
                    postit.hasVoted = json.hasVoted;
                }
            }

            PostIt.$set(target,postits);
        },
        resort: function(target){
            var postits = PostIt[target];
            postits.sort(function(a,b){
                return parseInt(a.vote_summary) <= parseInt(b.vote_summary)
            })
            PostIt.$set(target,postits);
        }
    }
});

var current = {
    age: 0,
    votes: 0
};

 var AddPage = function(sort,target){
     var page = current[sort]++;
     $.ajax({
         url: '{{route('api.v1.postit.index')}}',
         data : {
             page: page,
             sort: sort
         },
         success:function(json){
             PostIt.$set(target,PostIt[target].concat(json));
             currentPage = page;
             lastResult = json.length;
         }
     })
 }

$(function(){
    simplemde = new SimpleMDE({
        element: document.getElementById("novo_postit"),
        autofocus: true,
        spellChecker: false,
    });



    AddPage('age','newest')
    AddPage('votes','most_voted')
});
 </script>
@append