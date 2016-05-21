@extends('layouts.default')
@section('styles')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@stop
@section('body')
    <div id="content"></div>

@stop

@section('scripts')
    <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script type="text/babel">
        var Create = React.createClass({
            getInitialState: function(){
                return {
                    simplemde : null
                }
            },
            componentDidMount: function() {
                this.setState({
                    simplemde: new SimpleMDE({
                        element: document.getElementById("novo_postit"),
                        autofocus: true,
                        spellChecker: false,
                    })
                })
            },
            create: function(){
                var ref = this;
                $.ajax({
                    url: '{{route('api.v1.postit.store')}}',
                    method: 'post',
                    data : {
                        _token: '{{csrf_token()}}',
                        message:  ref.state.simplemde.value()
                    },
                    success:function(json){
                        ref.state.simplemde.value('')
                        ref.props.list.addPostIt(json)

                    }
                })
            },
            render: function(){
                var styles = {
                    container: {
                        paddingTop: "20px",
                        paddingBottom: "20px"
                    }
                }
                return (
                    <div className="mui-row" id="postit_form" style={styles.container}>
                        <div className="mui-col-xs-12">
                            <textarea id="novo_postit" className="mui-col-xs-12"></textarea>
                            <button className="mui-btn mui-btn--raised mui-btn--primary mui-col-xs-12" onClick={this.create}>Enviar</button>
                        </div>
                    </div>
                )
            }
        })
        var PostIt = React.createClass({
            getInitialState : function(){
                return {
                    hasVoted : this.props.item.hasVoted,
                    currentVote: this.props.item.vote_summary
                }
            },
            getClasses : function(condition){
                return "mui-btn mui-btn--raised mui-btn--small " + ( this.state.hasVoted == condition ? 'mui-btn--primary' : '');
            },
            voteUp : function(){
                this.vote(1);
            },
            voteDown: function(){
                this.vote(-1)
            },
            vote: function(direction){
                var ref = this;
                $.ajax({
                    url: '{{route('api.v1.postit.vote.store',['postit'=>'#postit'])}}'.replace('#postit',ref.props.item.id),
                    method: 'post',
                    data : {
                        _token: '{{csrf_token()}}',
                        postit_id: ref.props.item.id,
                        value: direction
                    },
                    success:function(json){
                        ref.setState({
                            hasVoted : json.hasVoted,
                            currentVote: json.vote_summary
                        })
                    }
                })
            },
            render: function(){
                return (
                    <div className="mui-row mui--text-left">
                        <div className='mui-col-xs-12'>
                            <div className='mui-panel'>
                                <div className="mui-col-xs-1 mui--text-center">
                                <button className={this.getClasses(1)} onClick={this.voteUp}>
                                    <i className="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                </button>
                                <h3>{this.state.currentVote}</h3>
                                <button className={this.getClasses(-1)} onClick={this.voteDown}>
                                    <i className="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                </button>
                                </div>
                                <div className="mui-col-xs-11">
                                <div dangerouslySetInnerHTML=@{{__html: this.props.item.message}}></div>
                                </div>
                            </div>
                        </div>
                    </div>
                )
            }
        })
        var PostItList = React.createClass({
            getInitialState : function(){
              return {
                  postits : [],
                  page: 1
              }
            },
            getPage: function(page){
                var ref = this;
                $.ajax({
                    url: '{{route('api.v1.postit.index')}}',
                    data : {
                        page: page,
                        sort: this.props.sort
                    },
                    success:function(json){
                        ref.setState({postits: ref.state.postits.concat(json)});
                    }
                })
            },
            addPostIt: function(json){
                this.setState({postits: [json].concat(this.state.postits)});
            },
            componentDidMount: function() {
                this.getPage(this.state.page);
            },
            render: function() {
                var postits = this.state.postits;
                var PostItDom = postits.map(function(postit){
                    return (
                        <PostIt item={postit}/>
                    )
                })

                return (
                    <div>
                        {PostItDom}
                        <Create list={this}/>
                    </div>
                );
            }
        });


        ReactDOM.render(
            <PostItList sort='newest'/>,
            document.getElementById('content')
        );
    </script>
@append