@extends('layouts.default')
@section('styles')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@stop
@section('body')
    <div class="mui-container">
        <div class="mui-row" id="postit_form">
            <div class="mui-col-md-12">
                <textarea id="novo_postit" class="uk-width-1-1"></textarea>
                <button class="mui-btn mui-btn--colored" v-on:click="submitPostIt" >Submit</button>
            </div>
        </div>
    </div>
<div class="mui-container post-its"  id="post_its" >
    <div  v-for="postit in postits" class="mui-row post-it uk-panel-box uk-margin-top">
         <div class="mui-col-md-1">
              <div class="vote mui--text-center">
               <button v-bind:class="['mui-btn', (postit.hasVoted == 1) ? 'mui-btn--accent' : '']" v-on:click="vote(postit,1)" >
                <i class="uk-icon uk-icon-arrow-circle-up"></i>
               </button>
               <h3>@{{ postit.vote_summary  }}</h3>
               <button v-bind:class="['mui-btn', (postit.hasVoted == -1) ? 'mui-btn--accent' :  '']" v-on:click="vote(postit, -1)">
                <i class="uk-icon uk-icon-arrow-circle-down"></i>
               </button>
              </div>
         </div>
         <div class="mui-col-md-11 mui-panel mui--text-body1">
             @{{ postit.message }}
             <div class="mui-divider"></div>
             <i>@{{ postit.created_at }}</i>
         </div>
    </div>
    <div id="bottom_div">&nbsp;</div>
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
        postits: []
    },

    methods: {

        vote: function(postit, value){

            $.ajax({
                url: '{{route('api.v1.postit.vote.store',['postit'=>'#postit'])}}'.replace('#postit',postit.id),
                method: 'post',
                data : {
                    _token: '{{csrf_token()}}',
                    postit_id: postit.id,
                    value: value
                },
                success:function(json){
                    PostIt.update(json);
                    PostIt.resort();
                }
            })

        },

        add: function(json){
            var postits = PostIt.postits;
            console.log(json,[json].concat(postits));
            PostIt.$set('postits',[json].concat(postits));
        },

        update: function(json){

            var postits = PostIt.postits;

            for(var i = 0; i<postits.length; i++){
                var postit = postits[i];
                if (postit.id == json.id){
                    postit.vote_summary = json.vote_summary;
                    postit.hasVoted = json.hasVoted;
                }
            }

            PostIt.$set('postits',postits);
        },
        resort: function(){
            var postits = PostIt.postits;
            postits.sort(function(a,b){
                return parseInt(a.vote_summary) <= parseInt(b.vote_summary)
            })
            PostIt.$set('postits',postits);
        }
    }
});

    $(function(){
        simplemde = new SimpleMDE({
            element: document.getElementById("novo_postit"),
            autofocus: true
        });

        var currentPage=1;
        var lastResult=1;
        var AddPage = function(page){
            $.ajax({
                url: '{{route('api.v1.postit.index')}}',
                data : {
                    page:page
                },
                success:function(json){
                    PostIt.$set('postits',PostIt.postits.concat(json));
                    currentPage = page;
                    lastResult = json.length;
                }
            })
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                if (lastResult > 0){
                    AddPage(currentPage + 1)
                }
            }
        });

        AddPage(1)
    });
 </script>
@append