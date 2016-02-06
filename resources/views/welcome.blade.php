@extends('layouts.default')
@section('body')
<div class="uk-container uk-container-center">
 <div class="uk-grid">
  <div class="uk-width-1-1">
   <div id="post_its" class="post-its">
    <div  v-for="postit in postits" class="uk-grid post-it">
     <div class="uk-width-medium-1-6">
      <div class="vote">
       <button v-bind:class="['uk-button', (postit.hasVoted == 1) ? 'uk-button-success' : '']" v-on:click="vote(postit,1)" >
        <i class="uk-icon uk-icon-arrow-circle-up"></i>
       </button>
       <h4>@{{ postit.vote_summary  }}</h4>
       <button v-bind:class="['uk-button', (postit.hasVoted == -1) ? 'uk-button-success' :  '']" v-on:click="vote(postit, -1)">
        <i class="uk-icon uk-icon-arrow-circle-down"></i>
       </button>
      </div>
     </div>
     <div class="uk-width-medium-5-6">
      <blockquote>
       @{{ postit.message }}
       <hr>
       <i>@{{ postit.created_at }}</i>
      </blockquote>
     </div>
    </div>
    </div>
   </div>
  </div>
 </div>
</div>
@stop


@section('scripts')
 <script type="text/javascript">

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
          var postits = PostIt.postits;

          for(var i = 0; i<postits.length; i++){
             var postit = postits[i];
             if (postit.id == json.id){
                 postit.vote_summary = json.vote_summary;
                 postit.hasVoted = json.hasVoted;

                 console.log(postit)
             }
          }

         PostIt.$set('postits',postits);
       }
      })

     }
   }

  });

  $(function(){
   $.ajax({
    url: '{{route('api.v1.postit.index')}}',
    data : {},
    success:function(json){
     PostIt.$set('postits',json);
    }
   })
  });
 </script>
@append